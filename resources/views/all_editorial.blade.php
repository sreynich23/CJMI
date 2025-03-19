@extends('layouts.app')

@section('content')
    <aside class="p-2 flex bg-white gap-5">
        <!-- Sidebar -->
        <div class="w-1/5 sticky top-4 h-screen overflow-y-auto">
            <ul class="space-y-4">
                @foreach ($policies->groupBy('type') as $type => $groupedPolicies)
                    <li>
                        <h3 class="text-lg font-semibold text-white text-center rounded-sm border bg-blue-900">{{ ucfirst($type) }}</h3>

                        @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                            <ul class="space-y-2">
                                <li>
                                    <a href="javascript:void(0);"
                                        onclick="toggleCategory('category-{{ Str::slug($category) }}')"
                                        class="block border border-blue-700 rounded-md px-4 py-2 text-black hover:bg-blue-600 hover:text-white">
                                        {{ $category }}
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-gray-100 w-full p-5 rounded gap-5">
            <div class="text-lg lg:text-2xl md:text-xl font-bold">Policies and Guidelines</div>
            <div class="bg-white rounded p-6 space-y-6">
                @if(isset($groupedPolicies) && $groupedPolicies->isNotEmpty())
                    @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                        <div id="category-{{ Str::slug($category) }}" class="contentSection hidden">
                            <h4 class="text-xl font-bold">{{ ucfirst($category) }}</h4>

                            @foreach ($categoryPolicies as $policy)
                                <h1 id="dynamicTitle" class="text-lg font-semibold text-gray-800">{{ $policy->title }}</h1>
                                <p class="text-gray-600 mt-2">
                                    {!! Str::of(nl2br(e($policy->description)))
                                        ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')  // Links
                                        ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')  // Emails
                                    !!}
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">No policies available.</p>
                @endif
            </div>
        </div>
    </aside>
    <script>
        function toggleCategory(categoryId) {
            const contentSection = document.getElementById(categoryId);
            contentSection.classList.toggle('hidden');
        }
    </script>
@endsection
