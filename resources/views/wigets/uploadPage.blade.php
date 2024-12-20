@include('navbar')
<!-- Footer Section -->
<footer class="bg-white rounded-xl p-3">
    <div class="container mx-auto grid grid-rows-2">
        <div class="flex space-x-12">
            <!-- Left Section: Upload cover book -->
            <div class="p-8 justify-center items-center min-h-screen bg-white">
                <h1 class="text-xl font-bold mb-4">Upload Cover Image</h1>
                <div class="w-full relative grid grid-cols-1 md:grid-cols-3 border border-gray-300 bg-gray-100 rounded-lg">
                    <div class="rounded-l-lg p-4 bg-gray-200 flex flex-col border-0 border-r border-gray-300 h-full">
                        <label class="cursor-pointer hover:opacity-80 inline-flex items-center shadow-md my-2 px-2 py-2 bg-green-900 text-gray-50 border border-transparent
                                        rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none
                                        focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        for="restaurantImage">
                            Select image
                            <input id="restaurantImage" class="text-sm cursor-pointer w-36 hidden" type="file" onchange="showImage(event)">
                        </label>
                    </div>
                    <div class="relative order-first md:order-last h-32 md:h-64 flex justify-center items-center border border-dashed border-gray-400 col-span-2 m-2 rounded-lg bg-no-repeat bg-center bg-origin-padding bg-cover"
                        id="imagePreview">
                        <span class="text-gray-400 opacity-75">
                            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="0.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Right Section: Upload book -->
                <div class="mb-4 mt-6">
                    <label class="text-lg font-semibold">Upload Book</label>
                </div>
                <div class="grid grid-cols-1 space-y-2">
                    <label class="text-sm font-bold text-gray-500 tracking-wide">Attach Document</label>
                    <div class="flex w-full items-center justify-center bg-grey-lighter">
                        <label
                            class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-green-500">
                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                            <span class="mt-2 text-base leading-normal">Select a Word document</span>
                            <input type='file' class="hidden" accept=".doc, .docx" id="fileInput" onchange="showFileName()"/>
                        </label>
                    </div>
                    <div id="fileName" class="mt-2 text-sm text-gray-500"></div>
                </div>
            </div>

            <div class="flex-1 items-center p-8">
                <div class="grid grid-cols-1 space-y-2">
                    <label class="text-sm font-bold text-gray-500 tracking-wide">Title</label>
                    <input
                        class="text-base p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                        type="" placeholder="Title">
                    <textarea class="description sec p-3 h-60 border border-gray-300 outline-none" spellcheck="false"
                        placeholder="Describe everything about this post here"></textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <button
                        class="w-2/12 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">Upload</button>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript to show selected image -->
<script>
    function showFileName() {
        const fileInput = document.getElementById('fileInput');
        const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : '';
        document.getElementById('fileName').textContent = fileName ? `Selected file: ${fileName}` : '';
    }


    function showImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.style.backgroundImage = `url(${e.target.result})`;
            imagePreview.style.backgroundSize = 'cover';
            imagePreview.style.backgroundPosition = 'center';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
