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
    <main class="p-3">
        @foreach ($conversations as $conversation)
            @php
                $otherUser = null;
                if ($conversation->user_id1 != auth()->id()) {
                    $otherUser = $conversation->user1;
                } elseif ($conversation->user_id2 != auth()->id()) {
                    $otherUser = $conversation->user2;
                }
            @endphp

            <div class="my-2 px-3 py-2 bg-gray-50 rounded-sm flex items-center gap-2">
                <div class="w-12 h-12 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $otherUser->image) }});"></div>
                <div class="flex flex-col">
                    <p class="font-bold text-gray-500">{{$otherUser->name}}</p>
                    <a class="underline text-blue-400 text-sm" href="{{route('conversation', $conversation->id)}}">read messages</a>
                </div>
            </div>
        @endforeach
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>