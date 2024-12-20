<aside class="p-2 flex bg-white gap-5">
    <!-- Sidebar -->
    <div class="w-1/5 sticky top-4 h-screen overflow-y-auto">
        <div class="flex items-end justify-end mb-4">
            <!-- Button to show the form -->
            <button onclick="showForm()"
                class="rounded-md p-3 flex items-center gap-2 bg-blue-600 text-white hover:bg-blue-700">
                Add
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <ul class="space-y-2">
            {{-- Sidebar Links --}}
            @forelse ($abouts as $about)
                <li>
                    <a href="#{{ Str::slug($about->title) }}"
                        onclick="editAbout('{{ $about->id }}', '{{ $about->title }}', '{{ $about->description }}')"
                        class="block border border-green-700 rounded-md px-4 py-2 text-black hover:bg-green-600 hover:text-white">
                        {{ $about->title }}
                    </a>
                </li>
            @empty
                <li class="text-gray-500"></li>
            @endforelse
        </ul>

    </div>

    <!-- Main Content -->
    <div class="bg-gray-100 w-full p-5 rounded gap-5">
        <div class="bg-white rounded p-6 space-y-6">
            <div class="text-2xl font-semibold">About This Journal
            </div>
            <!-- Dynamic Content Section -->
            @forelse ($abouts as $about)
                <div id="contentSection">
                    <h1 id="dynamicTitle" class="text-xl font-bold">{{ $about->title }}</h1>
                    <p id="dynamicDescription" class="text-gray-700">{{ $about->description }}</p>
                </div>
            @empty
                <li class="text-gray-500"></li>
            @endforelse
        </div>
    </div>
</aside>

<!-- Hidden Form Section -->
<div id="addForm"
    class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <form method="POST" action="{{ route('about.store') }}" id="aboutForm"
        class="bg-white p-10 rounded shadow-lg w-1/2">
        @csrf
        <input type="hidden" id="about_id" name="about_id">
        <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold text-lg mb-2">Title</label>
            <input type="text" id="title" name="title"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>
        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-semibold text-lg mb-2">Description</label>
            <textarea id="description" name="description" rows="8"
                class="w-full px-5 py-3 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-green-500" required></textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit"
                class="px-6 py-3 bg-green-500 text-white font-semibold text-lg rounded-lg hover:bg-green-600">
                Submit
            </button>
            <button type="button" onclick="hideForm()"
                class="px-6 py-3 bg-gray-500 text-white font-semibold text-lg rounded-lg hover:bg-gray-600">
                Cancel
            </button>
        </div>
    </form>
</div>
<script>
    // Elements
    const addForm = document.getElementById("addForm");
    const aboutForm = document.getElementById("aboutForm");
    const aboutIdInput = document.getElementById("about_id");
    const titleInput = document.getElementById("title");
    const descriptionInput = document.getElementById("description");

    // Function to show the form
    function showForm() {
        addForm.classList.remove("hidden");
        // Reset form for new entry
        aboutForm.action = "{{ route('about.store') }}";
        aboutForm.method = "POST";

        // Remove any existing method field
        const existingMethod = document.getElementById('method_field');
        if (existingMethod) {
            existingMethod.remove();
        }

        aboutIdInput.value = "";
        titleInput.value = "";
        descriptionInput.value = "";
    }

    // Function to edit existing about
    function editAbout(id, title, description) {
        addForm.classList.remove("hidden");
        aboutForm.action = `/about/${id}`;

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        methodField.id = 'method_field';
        aboutForm.appendChild(methodField);

        aboutIdInput.value = id;
        titleInput.value = title;
        descriptionInput.value = description;
    }

    // Function to hide the form
    function hideForm() {
        addForm.classList.add("hidden");
    }

    // Close the form when clicking outside it
    addForm.addEventListener("click", (e) => {
        if (e.target === addForm) {
            hideForm();
        }
    });
</script>

