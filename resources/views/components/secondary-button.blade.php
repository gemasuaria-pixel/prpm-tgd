<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-light btn-sm rounded shadow-sm text-uppercase fw-semibold disabled-opacity']) }}>
    {{ $slot }}
</button>
