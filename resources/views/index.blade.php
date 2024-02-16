<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <x-navbar />
    @auth
        <div class="p-3">
            @foreach($posts as $post)
                <x-post :post="$post" />
            @endforeach
        </div>
    @endauth

    @guest
        <main class="p-3">
            <h1 class="text-xl font-bold">welcome!</h1>
            <p>login or create an account to join the plateform</p>
        </main>
    @endguest
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>