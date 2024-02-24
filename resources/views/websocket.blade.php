<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="pt-3">
    <x-navbar />
    <main class="mx-auto p-1 w-96 h-[90vh] relative flex flex-col">
        <input type="hidden" id="other_id" value="{{ $other->id }}">
        <div class="p-1 absolute top-0 left-0 right-0 bg-gray-200 flex gap-2 items-center">
            <div class="relative w-12 h-12 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $other->image) }});">
                <div class="absolute top-0 right-0 w-3 h-3 z-10 rounded-full" id="isOnline"></div>
            </div>
            <div class="flex flex-col">
                <p class="text-blue-400 font-semibold">{{ $other->name }}</p>
                <p class="h-4 text-gray-600" id="isTyping"></p>
            </div>
        </div>
        <ul class="p-1 my-12 overflow-y-auto bg-gray-50" id="list-messages">
            @foreach ($messages as $message)
                <li class="{{ $message->senderUser->id == auth()->user()->id ? 'ml-auto bg-blue-100' : 'bg-gray-100' }} my-2 p-3 rounded-md w-fit">
                    <p class="text-sm text-gray-400">{{$message->senderUser->name}}</p>
                    <p class="font-semibold">{{$message->content}}</p>
                </li>
            @endforeach
        </ul>    
        <form id="form" class="absolute bottom-0 left-0 right-0">
            <input id="cid" type="hidden" name="cid" value="{{$cid}}">
            <p id="error" class="hidden text-red-500">you cannot send an empty message!!</p>
            <div class="w-full flex">
                <input class="p-1 w-full outline-none border border-black-200" id="input-message" type="text" name="message" placeholder="write your message">
                <button class="py-1 px-3 bg-blue-400 text-white font-bold">send</button>
            </div>
        </form>
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/chat.js') }}"></script>
</body>
</html>