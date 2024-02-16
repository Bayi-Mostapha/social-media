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
        <form class="flex flex-col items-center gap-4" action="{{ route('forgot.update-password')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <div>
                <input class="outline-none p-1 border border-black-200" type="password" name="password" placeholder="enter your new password">
            </div>
            <div>
                <input class="outline-none p-1 border border-black-200" type="password" name="password_confirmation" placeholder="confirm your new password">
            </div>
            <button class="bg-blue-400 text-white py-1 px-3 font-bold">Confirm</button>
        </form>
    </main>
</body>
</html>