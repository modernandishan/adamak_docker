<div class="card p-3 rounded shadow-lg application-box">
    <h5 class="fs-15 lh-base mb-3">مشاوران متخصص آدمک</h5>
    <div class="avatar-group">
        @if($consultants->count())
            @foreach($consultants as $consultant)
                <a href="" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $consultant->name . ' ' . $consultant->family }}">
                    <div class="avatar-xs">
                        <img src="{{ Storage::url($consultant->profile->avatar) }}" alt="{{ $consultant->name . ' ' . $consultant->family }}" class="rounded-circle img-fluid">
                    </div>
                </a>
            @endforeach
        @endif
        <a href="" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="مشاوران آدمک">
            <div class="avatar-xs">
                <div class="avatar-title fs-13 rounded-circle bg-light border-dashed border text-primary">بیشتر +</div>
            </div>
        </a>
    </div>
</div>
