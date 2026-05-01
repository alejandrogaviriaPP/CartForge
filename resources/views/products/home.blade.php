<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartForge</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
 
</head>

<body class="h-screen bg-cover bg-no-repeat   font-sans"
      style="background-image: url('/images/background.png');"></body>


    <div class="absolute inset-0 bg-slate-900/40"></div>

    <!-- contenedor principal -->
    <div class="relative flex items-center justify-center h-full text-center px-6">

        <div class="max-w-2xl">

            <h1 class="text-7xl md:text-8xl font-bold text-white tracking-tight">
                CartForge
            </h1>

            <p class="max-w-xl mx-auto mt-6 text-2xl md:text-xl text-gray-200 leading-relaxed">
                Build your shopping experience with power and simplicity. Discover a modern and seamless ecommerce experience.
            </p>

            <div class="mt-8">
                <a href="/products"
                   class=" inline-block px-10 py-4 text-lg font-medium text-white rounded-xl 
                          bg-gradient-to-r from-blue-400 to-indigo-700 
                          transition duration-300 transform hover:-translate-y-1">
                    Explore Products
                </a>
            </div>

        </div>

    </div>

</body>