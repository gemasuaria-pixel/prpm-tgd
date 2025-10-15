<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-primary btn-sm rounded shadow-sm text-uppercase fw-semibold']) }}>
    {{ $slot }}
</button>
