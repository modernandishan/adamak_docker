@props([
    'circular' => true,
    'size' => 'md',
])

<img
    @if(auth()->user() && auth()->user()->profile && auth()->user()->profile->avatar)
        src="{{ asset('storage/' . auth()->user()->profile->avatar) }}"
    @endif
    {{
        $attributes
            ->class([
                'fi-avatar object-cover object-center',
                'rounded-md' => ! $circular,
                'fi-circular rounded-full' => $circular,
                match ($size) {
                    'sm' => 'h-6 w-6',
                    'md' => 'h-8 w-8',
                    'lg' => 'h-10 w-10',
                    default => $size,
                },
            ])
    }}
/>
