<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <x-navbar />
    <h1 class="text-xl font-bold p-5">New post</h1>

    @if ($errors->any())
        <div class="bg-red-100 p-3 m-3 w-fit rounded-md">
            <ul class="text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" class="p-4" enctype="multipart/form-data">
        @csrf
        <div class="my-2">
            <input class="outline-none p-1 border border-black-200" type="text" name="title" placeholder="Post title">
        </div>
        <div class="my-2">
            <textarea rows="10" cols="50" class="outline-none p-1 border border-black-200" name="body" placeholder="Post body"></textarea>
        </div>
        <input type="file" name="image">
        <button class="bg-blue-400 text-white py-1 px-3 font-bold">Post</button>
    </form>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>