@extends('layouts.app')

@section('content')
    <div class="mt-5 bg-white shadow cursor-pointer rounded-xl">
        <div class="flex">
            <div class="flex-1 py-5 pl-5 overflow-hidden">
                <ul>
                    <li class="text-xs text-gray-600 uppercase ">All Editorials</li>
                    @foreach ($editorials as $editorial)
                        <li class="list-group-item">{{ $editorial->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="flex-1 py-5 pl-1 overflow-hidden">
                <ul>
                    <li class="text-xs text-gray-600 uppercase">All Reviewers</li>
                    @foreach ($reviewers as $reviewer)
                        <li class="list-group-item">{{ $reviewer->name }}</li>
                    @endforeach
                </ul>
            </div>
            @guest
            @else
                @if (auth()->user()->role === 'user')
                    <div class="relative px-2">
                        <button data-toggle="reviewer-form"
                            class="flex p-1 m-3 items-center border rounded-md bg-slate-700 hover:bg-slate-900 text-white text-xl">Become a
                            Reviewer
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 5.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0zM12 18a8 8 0 00-16 0h16z" />
                                <path d="M17.657 14.657a8 8 0 01-11.314 0M14.828 17.828a10.971 10.971 0 01-3.757-3.757" />
                            </svg>

                        </button>
                    </div>
                @endif
            @endguest
        </div>
    </div>

    <div id="reviewerFormModal" class="hidden flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6">
            <!-- Form Content -->
            <form action="{{ route('reviewer.create') }}" method="POST" enctype="multipart/form-data">
                <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Request to Become a Reviewer</h1>
                @csrf

                <!-- CV Upload -->
                <div class="mb-4">
                    <label for="cv" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload CV (PDF)
                    </label>
                    <input type="file" name="cv" id="cv"
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition"
                        accept="application/pdf" required />
                </div>

                <!-- Position -->
                <div class="mb-4">
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Position
                    </label>
                    <input type="text" name="position" id="position"
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition"
                        placeholder="e.g., Artificial Intelligence" required />
                </div>

                <!-- Expertise -->
                <div class="mb-4">
                    <label for="expertise" class="block text-sm font-medium text-gray-700 mb-2">
                        Expertise
                    </label>
                    <input type="text" name="expertise" id="expertise"
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition"
                        placeholder="e.g., Artificial Intelligence" required />
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" id="terms" name="terms"
                        class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-400 focus:ring-2">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-blue-500 underline">terms and conditions</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 focus:outline-none transition">
                    Request Reviewer Role
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('[data-toggle="reviewer-form"]');
            const formModal = document.querySelector('#reviewerFormModal');

            if (toggleButton && formModal) {
                toggleButton.addEventListener('click', () => {
                    formModal.classList.toggle('hidden');
                });

                // Close the modal when clicking outside
                document.addEventListener('click', (event) => {
                    if (!formModal.contains(event.target) && !toggleButton.contains(event.target)) {
                        formModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection
