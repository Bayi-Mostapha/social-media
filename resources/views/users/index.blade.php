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
    <main class="py-6 px-3 grid grid-cols-4 gap-4">
        @foreach($users as $user)
            @if(auth()->id() !== $user->id)
                <x-user :user="$user" />
            @endif
        @endforeach
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>