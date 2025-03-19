<aside class="p-2 flex bg-white gap-5">
    <!-- Sidebar -->
    <div class="w-1/5 sticky top-4 h-screen overflow-y-auto">
        <div class="flex items-end justify-end mb-4">
            <button onclick="showFormPolicies()"
                class="rounded-md p-3 flex items-center gap-2 bg-blue-600 text-white hover:bg-blue-700">
                Add Policies and Guidelines
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
        <div class="text-xl font-semibold">Policies and Guidelines</div>
        <ul class="space-y-4">
            @foreach ($policies->groupBy('type') as $type => $groupedPolicies)
                <li>
                    <h3 class="text-lg font-semibold text-blue-600">{{ ucfirst($type) }}</h3>

                    @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                        <ul class="space-y-2 pl-4">
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
        <div class="bg-white rounded p-6 space-y-6">
            @if($groupedPolicies && $groupedPolicies->isNotEmpty())
                @foreach ($groupedPolicies->groupBy('category') as $category => $categoryPolicies)
                    <div id="category-{{ Str::slug($category) }}" class="contentSection hidden">

                        <h4 class="text-xl font-bold">{{ ucfirst($category) }}</h4>

                        @foreach ($categoryPolicies as $policy)
                            <div class="flex gap-2">
                                <h1 id="dynamicTitle" class="text-lg font-semibold text-gray-800">{{ $policy->title }}</h1>
                                <button onclick="editPolicy(
                                    {{ $policy->id }},
                                    '{{ addslashes($policy->type) }}',
                                    '{{ addslashes($policy->category) }}',
                                    '{{ addslashes($policy->title) }}'
                                )"
                                class="rounded-md px-1 flex gap-2 border">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                                    </svg>
                                </button>
                            </div>
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

<!-- Hidden Form Section -->
<div id="addFormPolicies"
    class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <form method="POST" action="{{ route('admin.policies_guidelines.store') }}" id="policyForm"
        class="bg-white p-10 rounded shadow-lg w-1/2">
        @csrf
        <input type="hidden" id="policy_id" name="policy_id">
        <h2 class="text-2xl font-semibold mb-6" id="formTitle">Add Policy</h2>
        <div class="mb-6">
            <label for="type" class="block text-gray-700 font-semibold text-lg mb-2">Policies or Guidelines</label>
            <select id="type" name="type"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option value="" disabled selected>Select an option</option>
                <option value="policy">Policies</option>
                <option value="guideline">Guidelines</option>
            </select>
        </div>
        <div class="mb-6">
            <label for="category" class="block text-gray-700 font-semibold text-lg mb-2">Title</label>
            <input type="text" id="category" name="category"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold text-lg mb-2">Main Point</label>
            <input type="text" id="title" name="title"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-semibold text-lg mb-2">Description</label>
            <textarea id="description" name="description" rows="8"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit"
                class="px-6 py-3 bg-green-500 text-white font-semibold text-lg rounded-lg hover:bg-green-600">Submit</button>
            <button type="button" onclick="hideForm()"
                class="px-6 py-3 bg-gray-500 text-white font-semibold text-lg rounded-lg hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>

<script>
    window.onload = function() {
        const addFormPolicies = document.getElementById("addFormPolicies");
        const policyForm = document.getElementById("policyForm");
        const policyIdInput = document.getElementById("policy_id");
        const typeInput = document.getElementById("type");
        const categoryInput = document.getElementById("category");
        const titleInput = document.getElementById("title");
        const descriptionInput = document.getElementById("description");
        const formTitle = document.getElementById("formTitle");

        window.showFormPolicies = function() {
            addFormPolicies.classList.remove("hidden");
            formTitle.textContent = "Add Policy";
            policyForm.action = "{{ route('admin.policies_guidelines.store') }}";
            policyForm.method = "POST";
            policyIdInput.value = "";
            titleInput.value = "";
            descriptionInput.value = "";
            const methodField = document.getElementById('method_field');
            if (methodField) methodField.remove();
        };

        window.editPolicy = function(id, type, category, title) {

            const addFormPolicies = document.getElementById("addFormPolicies");
            const formTitle = document.getElementById("formTitle");
            const policyForm = document.getElementById("policyForm");
            const policyIdInput = document.getElementById("policy_id");
            const typeInput = document.getElementById("type");
            const categoryInput = document.getElementById("category");
            const titleInput = document.getElementById("title");
            const descriptionInput = document.getElementById("description");

            // Show the form
            addFormPolicies.classList.remove("hidden");

            // Set form title and populate form fields with current data
            formTitle.textContent = "Update Policy";
            policyForm.action = `/admin/policies-guidelines/${id}/edit`;
            policyIdInput.value = id;
            typeInput.value = type;
            categoryInput.value = category;
            titleInput.value = title;

            // Optionally, you can add the _method hidden input for a PUT request, if required
            const methodField = document.getElementById('method_field');
            if (!methodField) {
                const newMethodField = document.createElement('input');
                newMethodField.type = 'hidden';
                newMethodField.name = '_method';
                newMethodField.value = 'GET';
                newMethodField.id = 'method_field';
                policyForm.appendChild(newMethodField);
            }
        };

        window.hideForm = function() {
            addFormPolicies.classList.add("hidden");
        };

        addFormPolicies.addEventListener("click", (e) => {
            if (e.target === addFormPolicies) hideForm();
        });
    };

    function toggleCategory(categoryId) {
        const contentSection = document.getElementById(categoryId);
        contentSection.classList.toggle('hidden');
    }
</script>
