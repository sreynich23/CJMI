<div class="container h-screen bg-white border border-gray-300 rounded-lg p-6">    <h1 class="text-2xl font-semibold mb-4">Editorials</h1>

    <!-- Button to Show Add Editor Form -->
    <button onclick="toggleForm()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Add New Editor
    </button>

    <!-- Add Editor Form (Initially Hidden) -->
    <div id="addEditorForm" class="mt-4 p-4 border border-gray-300 rounded-lg bg-gray-50 hidden">
        <h2 class="text-xl font-semibold mb-2">Add New Editor</h2>
        <form action="{{ route('admin.editorials.store') }}" method="POST">
            @csrf
            <label class="block mb-2">Name:</label>
            <input type="text" name="name" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Position:</label>
            <input type="position" name="position" class="w-full p-2 border rounded mb-4" required>
            <label class="block mb-2">Description:</label>
            <input type="description" name="description" class="w-full p-2 border rounded mb-4" required>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
        </form>
    </div>

    <!-- Editors Table -->
    <div class="overflow-x-auto mt-4">
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Position</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Description</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($editors as $editor)
                    <tr class="border border-gray-300 hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $editor->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $editor->position }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $editor->description }}</td>
                        <td class="px-4 py-2 text-center flex space-x-5">
                            <!-- Button to Show Update Form -->
                            <button onclick="toggleUpdateForm({{ $editor->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Edit
                            </button>
                            <!-- Delete Form -->
                            <form action="{{ route('admin.editorials.destroy', $editor->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- <div id="updateForm-{{ $editor->id }}"
    class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
    onclick="closeModalUpdate(event, {{ $editor->id }})">

    <div class="bg-white rounded-lg p-6 w-96" onclick="event.stopPropagation();">
        <h2 class="text-xl font-semibold mb-4">Edit Editor</h2>
        <form action="{{ route('admin.editorials.update', $editor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2">Name:</label>
            <input type="text" name="name" value="{{ $editor->name }}" class="w-full p-2 border rounded mb-2">

            <label class="block mb-2">Position:</label>
            <input type="text" name="position" value="{{ $editor->position }}" class="w-full p-2 border rounded mb-2">

            <label class="block mb-2">Description:</label>
            <input type="text" name="description" value="{{ $editor->description }}" class="w-full p-2 border rounded mb-2">

            <div class="flex justify-end space-x-2 mt-4">
                <!-- Update Button -->
                <button type="submit"
                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Update
                </button>
            </div>
        </form>
    </div>
</div> --}}

<!-- JavaScript to Toggle Form -->
<script>
    function toggleUpdateForm(editorId) {
        let form = document.getElementById("updateForm-" + editorId);
        form.classList.toggle("hidden");
    }
    function toggleForm() {
        let form = document.getElementById("addEditorForm");
        form.classList.toggle("hidden");
    }
    function closeModalUpdate(event, editorId) {
        let modal = document.getElementById("updateForm-" + editorId);
        // Close only if the background overlay is clicked (not the form)
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    }
</script>
