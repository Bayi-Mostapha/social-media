<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <main class="h-screen flex flex-col justify-center items-center gap-4">
        <form class="flex flex-col items-center gap-4" action="{{ route('forgot.get-email')}}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <input class="outline-none p-1 border border-black-200" type="email" name="email" placeholder="enter your email">
            </div>
            <div>
                <button class="bg-blue-400 text-white py-1 px-3 font-bold">Confirm</button>
            </div>
        </form>
    </main>
</body>
</html>