<div class="flex justify-between items-center mb-8">
    <div class="flex space-x-8">
        @php
            $steps = [
                1 => 'Start',
                2 => 'Upload Submission',
                3 => 'Enter Metadata',
                4 => 'Confirmation',
                5 => 'Next Steps'
            ];
            $currentStep = intval(substr(Route::currentRouteName(), -1));
        @endphp

        @foreach($steps as $step => $label)
            <div class="text-center {{ $step === $currentStep ? 'border-b-2 border-green-700' : '' }}">
                @if($step < $currentStep)
                    <a href="{{ route('submit.step'.$step) }}"
                        class="text-green-700 hover:text-green-800 font-semibold">
                        {{ $step }}. {{ $label }}
                    </a>
                @else
                    <span class="{{ $step === $currentStep ? 'text-green-700 font-semibold' : 'text-gray-500' }}">
                        {{ $step }}. {{ $label }}
                    </span>
                @endif
            </div>
        @endforeach
    </div>

    <a href="{{ route('submissions.index') }}"
       class="text-green-700 hover:text-green-800 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        View My Submissions
    </a>
</div>
