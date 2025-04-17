@extends('layouts.app')

@section('content')
    <aside class="p-2 flex bg-white gap-5">
        <ul class="space-y-4">
            <div class="text-xl font-semibold text-white text-center bg-red-600 ml-4 mb-6 p-1">Policies and Guidelines</div>
            @foreach ($policies->groupBy('type') as $type => $groupedPolicies)
                <li>
                    <h3 class="text-lg font-semibold text-white text-center bg-blue-950 ml-4 ">{{ ucfirst($type) }}</h3>

                    @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                        <ul class="space-y-2 pl-4 mt-1">
                            <li>
                                <a href="javascript:void(0);"
                                    class="block px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 hover:text-white toggle-category"
                                    data-category="{{ $category }}">
                                    {{ $category }}
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </li>
            @endforeach
        </ul>

        <!-- Content Section -->
        <div class="bg-gray-100 w-full p-5 rounded gap-5">
            <div class="bg-white rounded p-6 space-y-6">
                @foreach ($policies->groupBy('type') as $type => $groupedPolicies)
                    @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                        <div class="contentSection" id="category_{{ $category }}" style="display:none;">
                            <h4 class="text-xl font-bold">{{ ucfirst($category) }}</h4>

                            @foreach ($categoryPolicies as $policy)
                            @if (addslashes($policy->category) === 'Manuscript structure and Template')
                                <a href="{{ asset('storage/manuscripts/CJMRI_Templete.docx') }}"
                                    class="text-blue-500 hover:underline" target="_blank">Download Manuscript Template</a>
                            @endif
                                <h1 class=" font-bold">{{$policy->title}}</h1>
                                <p class="text-gray-600 mt-2">
                                    {!! Str::of(nl2br(e($policy->description)))
                                        ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')  // Links
                                        ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')  // Emails
                                    !!}
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </aside>
    <script>
        // Add click event listeners to category links
    const categoryLinks = document.querySelectorAll('.toggle-category');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function () {
            const category = this.getAttribute('data-category');
            const contentSection = document.getElementById(`category_${category}`);

            // Toggle visibility
            if (contentSection.style.display === "none" || contentSection.style.display === "") {
                // Hide all other sections
                document.querySelectorAll('.contentSection').forEach(section => {
                    section.style.display = "none";
                });

                // Show the clicked section
                contentSection.style.display = "block";
            } else {
                contentSection.style.display = "none";
            }
        });
    });
    </script>
@endsection
