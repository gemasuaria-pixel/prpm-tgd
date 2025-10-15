<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger btn-sm rounded shadow-sm text-uppercase fw-semibold']) }}>
    {{ $slot }}
</button>
