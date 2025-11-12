<div class="mb-5 position-relative">
    {{-- Progress Bar --}}
    <div class="progress rounded-pill" style="height: 10px;">
        <div class="progress-bar bg-gradient" role="progressbar"
             style="width: {{ ($step / $totalSteps) * 100 }}%; transition: width 0.4s ease;">
        </div>
    </div>

    {{-- Step Items --}}
    <div class="d-flex justify-content-between mt-3 text-center small fw-semibold">
        @foreach ($labels as $i => $info)
            <div class="step-item flex-fill">
                <div class="rounded-circle mx-auto mb-1 
                    {{ $step >= $i ? 'bg-primary text-white shadow' : 'bg-light text-secondary border' }}"
                    style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                    <i class="bi {{ $info['icon'] }}"></i>
                </div>
                <div class="{{ $step === $i ? 'text-primary' : 'text-muted' }}">
                    {{ $info['label'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>
