<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white p-4 rounded-xl shadow">
                <img src="https://via.placeholder.com/200" class="w-full h-48 object-contain mb-4">

                <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $product->description }}</p>

                <p class="mt-2 font-bold">${{ $product->price }}</p>

                <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded">
                    Add to Cart
                </button>
            </div> 
        @endforeach
    </div>
</div>
</body>
</html>