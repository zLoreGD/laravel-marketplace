<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#EFE6DD] text-[#231F20]">

@auth
<!-- HEADER -->
<header class="w-full max-w-6xl mx-auto px-6 py-8 flex flex-col gap-4">
    <h2 class="text-3xl font-semibold">
        Welcome, {{ Auth::user()->name }}
    </h2>

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

        <a href="/"
           class="px-5 py-2 rounded-xl border border-[#231F20] hover:bg-[#231F20] hover:text-[#EFE6DD] transition">
            Home
        </a>
    </div>
</header>


<section class="w-full max-w-6xl mx-auto px-6 mb-6">
    <h1 class="text-3xl font-semibold">Your cart</h1>
</section>


<section class="w-full max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($items as $item)
    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col gap-4">
        <img src="{{ asset('storage/' . $item->product->image_path) }}">
        <h2 class="text-2xl font-semibold">
            {{ $item->product->name }}
        </h2>

        <p class="text-sm text-gray-600">
            {{ $item->product->description }}
        </p>

        <div class="text-lg font-medium">
            Quantity: <span class="font-semibold">{{ $item->quantity }}</span>
        </div>

        <p class="text-xl font-bold">
            ${{ $item->product->price * $item->quantity }}
        </p>

        <form action="/delete-item" method="post" class="mt-auto">
            @csrf
            @method("DELETE")
            <input type="hidden" name="product_id" value="{{ $item->product->id }}">

            <button class="w-full px-4 py-2 hover:cursor-pointer rounded-xl border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition">
                Remove item
            </button>
        </form>
    </div>
@empty
    <p class="col-span-full text-center text-gray-600">
        Your cart is empty.
    </p>
@endforelse
</section>

@else
<!-- GUEST VIEW -->
<section class="min-h-screen flex flex-col items-center justify-center gap-10 px-6">
    <h1 class="text-3xl font-semibold text-center">
        Please register or log in to view your cart
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
        <!-- REGISTER -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Register</h2>
            <form action="/register" method="post" class="flex flex-col gap-3">
                @csrf
                <input class="input" type="text" name="name" placeholder="Username">
                <input class="input" type="email" name="email" placeholder="Email">
                <input class="input" type="password" name="password" placeholder="Password">
                <button class="btn-primary">Create account</button>
            </form>
        </div>

        <!-- LOGIN -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Login</h2>
            <form action="/login" method="post" class="flex flex-col gap-3">
                @csrf
                <input class="input" type="text" name="name" placeholder="Username">
                <input class="input" type="password" name="password" placeholder="Password">
                <button class="btn-primary">Login</button>
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
