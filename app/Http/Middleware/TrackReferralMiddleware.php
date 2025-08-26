<?php

namespace App\Http\Middleware;

use App\Services\ReferralService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackReferralMiddleware
{
    public function __construct(private ReferralService $referralService) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref') && ! $request->user()) {
            $refToken = $request->input('ref'); // Use input() to get from both query and body
            if ($refToken) {
                $this->referralService->trackReferralClick($request, $refToken);
            }
        }

        return $next($request);
    }
}
