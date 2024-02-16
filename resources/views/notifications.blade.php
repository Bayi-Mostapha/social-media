<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <x-navbar />
    <main class="p-2">
        <h1 class="text-2xl font-bold">Notifications</h1>
        @foreach ($notifications as $notification)
            <div class="my-2 px-3 py-2 bg-gray-50 rounded-sm flex justify-between items-center">
                <div class="flex flex-col">
                    <p class="text-gray-500 font-semibold">{{$notification->author->name}} commented on your post #{{$notification->post_id}}</p>
                    <p class="text-gray-500 text-sm">{{$notification->created_at}}</p>
                </div>
                <a class="underline text-blue-400" href="{{route('posts.show', $notification->post_id)}}">view</a>
            </div>
        @endforeach
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>