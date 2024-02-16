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
    <x-flash />
    <x-navbar />
    <div class="px-3 py-1">
        <div>
            <div class="flex gap-2 p-1 items-center justify-end">
                @can('delete', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('delete')
                        @csrf
                        <button class="bg-red-100 text-red-500 px-3 py-1 rounded-md">Delete</button>
                    </form>
                @endcan
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="block bg-green-100 text-green-500 px-3 py-1 rounded-md">Edit</a>
                @endcan
            </div>
            <div class="flex gap-2 items-center">
                <div class="w-14 h-14 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $post->user->image) }});"></div>
                <div class="flex flex-col">
                    <p class="text-blue-500">{{$post->user->name}}</p>
                    <p class="text-sm text-gray-500">posted {{$post->created_at}}</p>
                </div>
            </div>
            <h4 class="my-2 font-semibold">{{$post->title}}</h4>
            <p>{{$post->body}}</p>
    
            @if($post->image)
                <img class="my-3" src="{{ asset('storage/' . $post->image) }}" alt="post img">
            @endif
        </div>

        <h2 class="text-xl text-gray-600 font-bold">Comments</h2>
        
        @auth
            <form class="my-4 px-6 flex justify-center" action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pid" value="{{ $post->id }}">
                <input class="w-full outline-none px-1 py-2 border border-black-200" type="text" name="comment" placeholder="Add comment">
                <button class="bg-blue-400 text-white py-1 px-3 font-bold">Save</button>
            </form>
        @endauth

        @foreach ($post->comments as $comment)
            <div class="py-2">
                <div class="flex gap-2 p-1 items-center justify-end">
                    @can('delete', $comment)
                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                            @method('delete')
                            @csrf
                            <button class="bg-red-100 text-red-500 px-3 py-1 rounded-md">Delete</button>
                        </form>
                    @endcan
                    @can('update', $comment)
                        <a href="{{ route('comments.edit', $comment) }}" class="block bg-green-100 text-green-500 px-3 py-1 rounded-md">Edit</a>
                    @endcan
                </div>
                <div class="flex gap-1">
                    <div class="w-14 h-14 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $comment->user->image) }});"></div>
                    <div class="w-fit">
                        <p class="text-blue-500">{{$comment->user->name}}</p>
                        <p class="text-sm text-gray-500">{{$comment->created_at}}</p>
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>