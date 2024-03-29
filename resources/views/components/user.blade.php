<div class="p-3 border border-blue-300 flex flex-col items-center">
    <div class="sm:w-64 w-36 sm:h-64 h-36 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $user->image) }});"></div>
    <p class="font-semibold">{{ $user->name }}</p>
    <p class="text-gray-500 text-sm mb-3">{{ $user->email }}</p>
    <a href="{{route('users.show', $user->id)}}">view profile</a>
    <a href="{{route('chat', $user->id)}}">chat</a>
</div>