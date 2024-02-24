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
    <main class="p-2">
        <div class="flex flex-col items-center gap-2">
            <div class="sm:w-64 w-36 sm:h-64 h-36 bg-cover bg-center rounded-full" style="background-image: url({{ asset('storage/' . $user->image) }});"></div>
            <p>{{ $user->name }}</p>
            <p class="mb-3">{{ $user->email }}</p>
            <div class="flex sm:flex-row flex-col items-center gap-2">
                @can('update', $user)
                    <a class="block bg-green-100 text-green-500 px-3 py-1 rounded-md" href="{{ route('users.edit', $user->id) }}">Edit info</a>
                @endcan
                @can('update', $user)
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-100 text-red-500 px-3 py-1 rounded-md">Delete Account</button>
                    </form>
                @endcan
            </div>
        </div>
        <h4 class="text-l font-bold p-3">Posts</h4>
        <div class="p-3">
            @foreach($user->posts as $post)
                <x-post :post="$post" />
            @endforeach
        </div>
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>