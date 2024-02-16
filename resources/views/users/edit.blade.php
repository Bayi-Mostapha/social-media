<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <x-flash />
    <x-navbar />

    <h1 class="text-xl font-bold p-5">Edit profile</h1>
    @if ($errors->any())
        <div class="bg-red-100 p-3 m-3 w-fit rounded-md">
            <ul class="text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="flex flex-col items-center gap-4" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="w-64 h-64 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $user->image) }});"></div>
        <div>
            <p class="text-center">change profile picture:</p>
            <input class="border border-black-200" type="file" name="image">
        </div>
        <div>
            <input class="outline-none p-1 border border-black-200" name="name" type="text" placeholder="username" value="{{ $user->name }}">
        </div>
        <div>
            <input class="outline-none p-1 border border-black-200" name="email" type="email" placeholder="email" value="{{ $user->email }}">
        </div>
        <div>
            <button class="bg-blue-400 text-white py-1 px-3 font-bold">Save changes</button>
        </div>
    </form>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>