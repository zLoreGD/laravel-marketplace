<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#EFE6DD] text-[#231F20]">

@auth
<!-- HEADER -->
<header class="w-full max-w-6xl mx-auto px-6 py-8 flex flex-col gap-4">
    <h2 class="text-3xl font-semibold">
        Welcome, {{ Auth::user()->name }}
    </h2>

    <div class="flex gap-3">
        <form action="/logout" method="post">
            @csrf
            <button class="px-5 hover:cursor-pointer py-2 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">
                Log out
            </button>
        </form>

        <form action="/cart" method="get">
            <button class="px-5 hover:cursor-pointer py-2 rounded-xl border border-[#231F20] hover:bg-[#231F20] hover:text-[#EFE6DD] transition">
                Cart
            </button>
        </form>
    </div>
</header>

<!-- SEARCH -->
<section class="w-full max-w-6xl mx-auto px-6 mb-8">
    <form action="/search-product" method="get" class="flex gap-3">
        @csrf
        <input
            type="text"
            name="search"
            placeholder="Search for products..."
            class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]"
        >
        <button class="px-6 py-3 rounded-xl hover:cursor-pointer bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">
            Search
        </button>
    </form>
</section>

<!-- CATEGORIES -->
<section class="w-full max-w-6xl mx-auto px-6 mb-10">
    <form method="get" action="/category-search" class="flex gap-3 flex-wrap">
        @foreach (['Peripherals', 'Gaming', 'Office', 'Audio','All'] as $cat)
            <button
                name="category"
                value="{{ $cat }}"
                class="px-4 py-2 rounded-full border border-[#231F20] hover:bg-[#231F20] hover:cursor-pointer hover:text-[#EFE6DD] transition"
            >
                {{ $cat }}
            </button>
        @endforeach
    </form>
</section>

<!-- PRODUCTS -->
<section class="w-full max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($products as $product)
    @if($product->available)
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col gap-4">
            
            <img class = "h-[200px] w-[200px] object-cover self-center"src="{{ asset(path: 'storage/' . $product->image_path) }}">
            
            <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
            <p class="text-sm text-gray-600">{{ $product->description }}</p>
            <p class="text-xl font-bold">${{ $product->price }}</p>
            
            <form action="/add-to-cart" method="post" class="mt-auto flex gap-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input
                    type="number"
                    name="quantity"
                    min="1"
                    value="1"
                    class="w-20 px-3 py-2 rounded-lg border border-gray-300"
                >
                <button class="flex-1 px-4 py-2 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 hover:cursor-pointer transition">
                    Add to cart
                </button>
                
            </form>
            <form action = "/details/{{ $product->id }}" method = "get" class="mt-auto flex gap-2">
                <button class="flex-1 px-4 py-2 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 hover:cursor-pointer transition">
                    View Details
                </button>
            </form>
            
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center justify-center text-center grayscale opacity-70">
            <p class="text-sm font-semibold mb-2">NOT AVAILABLE</p>
            <h1 class="text-2xl">{{ $product->name }}</h1>
            <p class="text-lg font-bold">${{ $product->price }}</p>
        </div>
    @endif
@endforeach
</section>

@else
<!-- GUEST VIEW -->
<section class="min-h-screen flex flex-col items-center justify-center gap-10 px-6">
    <h1 class="text-4xl font-semibold">Marketplace</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
        <!-- REGISTER -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Register</h2>
            <form action="/register" method="post" class="flex flex-col gap-3">
                @csrf
                <input class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]" type="text" name="name" placeholder="Username">
                <input class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]" type="text" name="email" placeholder="Email">
                <input class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]" type="password" name="password" placeholder="Password">
                <button class="px-6 py-3 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">Create account</button>
            </form>
        </div>

        <!-- LOGIN -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Login</h2>
            <form action="/login" method="post" class="flex flex-col gap-3">
                @csrf
                <input class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]" type="text" name="name" placeholder="Username">
                <input class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]" type="password" name="password" placeholder="Password">
                <button class="px-6 py-3 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">Login</button>
            </form>
        </div>
    </div>
</section>
@endauth

@if ($errors->any())
<div class="fixed bottom-6 right-6 bg-red-500 text-white p-4 rounded-xl shadow-lg">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success bg-green-500 p-4 text-white shadow-lg rounded-xl bottom-6 right-6 fixed">
        {{ session()->get('success') }}
    </div>
@endif
</body>
</html>
