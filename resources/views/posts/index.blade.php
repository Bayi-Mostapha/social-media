<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4">
    {{--flashbag--}}
    <x-flash />
    <x-navbar />

    <h1 class="text-3xl font-bold">Your posts</h1>

    <a href="{{ route('posts.create') }}" class="block w-fit bg-blue-400 text-white py-1 px-3 font-bold rounded-md my-6">add new post</a>

    @foreach(auth()->user()->posts as $post)
        <x-post :post="$post" />
    @endforeach
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>