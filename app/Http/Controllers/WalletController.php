<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class WalletController extends Controller
{
    public function showChargeForm()
    {
        $user = Auth::user();
        $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id], ['balance' => 0]);

        // دریافت تراکنش‌های کیف پول کاربر با مرتب سازی از جدید به قدیم
        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('wallet-charge', compact('wallet', 'transactions'));
    }

    // ارسال درخواست به درگاه پرداخت
    public function sendToGateway(Request $request)
    {
        $request->validate(PaymentGatewayService::getChargeAmountRules());

        $amount = (int) $request->input('amount');

        // Validate amount using service
        if (! PaymentGatewayService::validateChargeAmount($amount)) {
            return back()->withErrors([
                'amount' => 'مبلغ وارد شده خارج از محدوده مجاز است.',
            ])->withInput();
        }

        try {
            $payment = PaymentGatewayService::getPayment();
            $invoice = PaymentGatewayService::createInvoice($amount);

            $result = $payment
                ->callbackUrl(route('wallet.callback'))
                ->purchase($invoice, function ($driver, $transactionId) use ($amount) {
                    $user = Auth::user();
                    $wallet = $user->wallet()->firstOrCreate(
                        ['user_id' => $user->id],
                        ['balance' => 0]
                    );

                    $wallet->transactions()->create([
                        'transaction_id' => $transactionId,
                        'amount' => $amount,
                        'type' => 'charge',
                        'description' => 'در انتظار پرداخت',
                        'status' => 'pending',
                    ]);
                })
                ->pay();

            // If we get here, the payment was successful and we should redirect
            return $result->render();

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Payment gateway error: '.$e->getMessage(), [
                'amount' => $amount,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'payment' => 'خطا در اتصال به درگاه پرداخت: '.$e->getMessage(),
            ])->withInput();
        }
    }

    // پردازش بازگشت از درگاه پرداخت
    public function callback(Request $request)
    {
        $status = $request->input('Status');
        $authority = $request->input('Authority');

        if (! $status || ! $authority) {
            abort(400, 'اطلاعات بازگشتی نامعتبر است.');
        }

        $transaction = WalletTransaction::where('transaction_id', $authority)
            ->where('status', 'pending')
            ->firstOrFail();

        if ($status !== 'OK') {
            $transaction->update([
                'status' => 'failed',
                'description' => 'پرداخت توسط کاربر لغو شد یا تایید نشد.',
            ]);

            return redirect()->route('user.wallet.charge.form')->withErrors([
                'payment' => 'پرداخت توسط شما لغو شد.',
            ]);
        }

        $payment = PaymentGatewayService::getPayment();

        try {
            $receipt = $payment->amount($transaction->amount)
                ->transactionId($authority)
                ->verify();

            $transaction->update([
                'status' => 'completed',
                'tracking_code' => (int) $receipt->getReferenceId(),
                'description' => 'پرداخت کامل شد.',
            ]);

            $wallet = $transaction->wallet;
            $wallet->increment('balance', $transaction->amount);

            return redirect()->route('user.wallet.charge.form')->with([
                'success' => 'کیف پول شما با موفقیت شارژ شد. مبلغ: '.number_format($transaction->amount).' تومان',
            ]);

        } catch (InvalidPaymentException $e) {
            $transaction->update([
                'status' => 'failed',
                'description' => 'خطا در پرداخت: '.$e->getMessage(),
            ]);

            return redirect()->route('user.wallet.charge.form')->withErrors([
                'payment' => 'خطا در پرداخت: '.$e->getMessage(),
            ]);
        }
    }
}
