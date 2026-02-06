<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#EFE6DD] text-[#231F20]">

@auth
<!-- HEADER -->
<header class="w-full max-w-6xl mx-auto px-6 py-8 flex flex-col gap-4">
    <h2 class="text-3xl font-semibold">Welcome, {{ Auth::user()->name }}</h2>
    <div class="flex gap-3 flex-wrap">
        <form action="/logout" method="post">
            @csrf
            <button class="px-5 py-2 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">
                Log out
            </button>
        </form>

        <form action="/cart" method="get">
            <button class="px-5 py-2 rounded-xl border border-[#231F20] hover:bg-[#231F20] hover:text-[#EFE6DD] transition">
                Cart
            </button>
        </form>

        <a href="/" class="px-5 py-2 rounded-xl border border-[#231F20] hover:bg-[#231F20] hover:text-[#EFE6DD] transition">
            Home
        </a>
    </div>
</header>

<!-- PRODUCT DETAILS -->
<section class="w-full max-w-6xl mx-auto px-6 mb-10">
    <h1 class="text-3xl font-semibold mb-6">Product Details</h1>
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left: Product Info -->
        <div class="w-full lg:w-[70%] bg-white rounded-2xl shadow-md p-6 flex flex-col gap-4">
            <h2 class="text-2xl font-semibold text-center">{{ $product->name }}</h2>
            <img class="h-[200px] w-[200px] object-cover self-center rounded-xl" src="{{ asset('storage/' . $product->image_path) }}">
            <p class="text-gray-600 text-center">{{ $product->description }}</p>
        </div>

        <!-- Right: Price & Purchase -->
        <div class="w-full lg:w-[30%] bg-white rounded-2xl shadow-md p-6 flex flex-col gap-4 justify-center items-center">
            <h2 class="text-4xl font-bold">{{ $product->price }}$</h2>
            <button class="px-6 py-3 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 hover:cursor-pointer transition">
                Purchase
            </button>
        </div>
    </div>
</section>

<!-- COMMENTS -->
<section class="w-full max-w-6xl mx-auto px-6 mb-6">
    <h1 class="text-3xl font-semibold mb-4">Comments</h1>

    <!-- Add Comment -->
    <div class="w-full bg-white rounded-2xl shadow-md p-6 flex gap-3 items-center mb-4">
        <img class="w-12 h-12 rounded-full" src="{{ asset('storage/users/unknown.png') }}">
        <form method="post" action="/comment" class="flex-1 flex gap-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input
                type="text"
                name="description"
                placeholder="Write a comment..."
                class="flex-1 px-5 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#231F20]"
            >
            <button class="px-4 py-2 rounded-xl bg-[#231F20] text-[#EFE6DD] hover:opacity-90 transition">
                Comment
            </button>
        </form>
    </div>

    <!-- Existing Comments -->
    @foreach ($comments as $comment)
        <div class="w-full bg-white rounded-2xl shadow-md p-6 flex gap-3 items-start mb-4">
            <img class="w-12 h-12 rounded-full" src="{{ asset('storage/users/unknown.png') }}">
            <div>
                <p class="font-semibold">{{ $comment->user->name }}</p>
                <p class="text-gray-700">{{ $comment->description }}</p>
            </div>
        </div>
    @endforeach
</section>

@else
<!-- GUEST VIEW -->
<section class="min-h-screen flex flex-col items-center justify-center gap-10 px-6">
    <h1 class="text-3xl font-semibold text-center">
        Please register or log in to view this page
    </h1>

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

</body>
</html>
