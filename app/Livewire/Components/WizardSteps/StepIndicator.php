<?php

namespace App\Livewire\Components\WizardSteps;

use Livewire\Component;

class StepIndicator extends Component
{
    public int $step = 1;

    public array $labels = [];

    public int $totalSteps = 0;

    protected $listeners = [
        'setStep' => 'setStep',
    ];

    // Lifecycle hook: jalan setiap render / mount ulang
    public function mount($step = 1, $labels = [])
    {
        $this->step = $step;
        $this->labels = !empty($labels)
            ? $labels
            : [
                1 => ['label' => 'Step 1', 'icon' => 'bi-1-circle'],
                2 => ['label' => 'Step 2', 'icon' => 'bi-2-circle'],
            ];

        $this->totalSteps = count($this->labels);
    }

    public function setStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->step = $step;
        }
    }

    public function render()
    {
        return view('livewire.components.wizard-steps.step-indicator');
    }
}
