<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CartForge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

<div class="min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl
                animate-[fadeIn_0.6s_ease]">

        <h2 class="text-2xl font-bold text-center mb-2">
            Create your account
        </h2>

        <p class="text-sm text-gray-500 text-center mb-6">
            Start building your shopping experience
        </p>

        <!-- GOOGLE -->
        <a href="/auth/google"
           class="flex items-center justify-center gap-2 w-full border rounded-lg py-2 hover:bg-gray-100 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
            <span>Continue with Google</span>
        </a>

        <!-- SEPARADOR -->
        <div class="flex items-center my-4">
            <div class="flex-grow h-px bg-gray-300"></div>
            <span class="px-3 text-gray-400 text-sm">or</span>
            <div class="flex-grow h-px bg-gray-300"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" placeholder="Name"
                class="w-full mt-2 p-2 border rounded-lg focus:ring-2 focus:ring-black">

             <input type="text" name="address" placeholder="Address"
                class="w-full mt-2 p-2 border rounded-lg focus:ring-2 focus:ring-black">    

            <input type="email" name="email" placeholder="Email"
                class="w-full mt-3 p-2 border rounded-lg focus:ring-2 focus:ring-black">

            <input id="password" type="password" name="password" placeholder="Password"
                class="w-full mt-3 p-2 border rounded-lg focus:ring-2 focus:ring-black">

            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="w-full mt-3 p-2 border rounded-lg focus:ring-2 focus:ring-black">

            <!-- SHOW PASSWORD -->
            <button type="button" onclick="togglePassword()" 
                class="text-xs text-gray-500 mt-1">
                Show password
            </button>

            <button
                class="w-full mt-6 bg-black text-white py-2 rounded-lg
                       hover:bg-gray-800 transition active:scale-95 hover:shadow-lg">
                Create Account
            </button>

        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-black">
                Already registered?
            </a>
        </div>

    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}
</script>

</body>
</html>