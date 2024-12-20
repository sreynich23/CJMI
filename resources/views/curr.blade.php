
<body class="bg-gray-100">
    <!-- Header Section -->
    @include('navbar')


    <div class="container mx-auto p-4 flex space-x-6">
            <div class="flex-1 bg-gray-100 p-4 rounded-lg">
                @include('currents.curr')
            </div>
        </div>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <h2 class="font-bold mb-2">Information</h2>
                    <ul>
                        <li>About Us</li>
                        <li>Contact</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold mb-2">My Account</h2>
                    <ul>
                        <li>Login</li>
                        <li>Register</li>
                        <li>Profile</li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold mb-2">Extras</h2>
                    <ul>
                        <li>Downloads</li>
                        <li>FAQs</li>
                        <li>Support</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
