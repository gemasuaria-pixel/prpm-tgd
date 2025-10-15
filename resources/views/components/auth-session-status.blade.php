@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success py-2 px-3 mb-2']) }}>
        {{ $status }}
    </div>
@endif
