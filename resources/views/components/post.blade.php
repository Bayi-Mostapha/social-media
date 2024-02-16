@props(['post'])
<div class="my-4 px-3 py-1 border border-gray-300">
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

    {{--run command php artisan storage:link--}}
    @if($post->image)
        <img class="my-3" src="{{ asset('storage/' . $post->image) }}" alt="post img">
    @endif
    <a class="text-gray-500 underline" href="{{ route('posts.show', $post->id)}}">view comments</a>
</div>