<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <main class="h-screen flex flex-col justify-center items-center gap-4">
        <h1 class="text-xl font-bold p-5">Register</h1>
        @if ($errors->any())
            <div class="bg-red-100 p-3 m-3 w-fit rounded-md">
                <ul class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="flex flex-col items-center gap-4" action="{{ route('register.register')}}" method="POST">
            @csrf
            <div>
                <input class="outline-none p-1 border border-black-200" name="name" type="text" placeholder="username" value="{{ old('name') }}">
            </div>
            <div>
                <input class="outline-none p-1 border border-black-200" name="email" type="email" placeholder="email" value="{{ old('email') }}">
            </div>
            <div>
                <input class="outline-none p-1 border border-black-200" name="password" type="password" placeholder="password">
            </div>
            <div>
                <input class="outline-none p-1 border border-black-200" name="password_confirmation" type="password" placeholder="confirm password">
            </div>
            <div>
                <button class="bg-blue-400 text-white py-1 px-3 font-bold">Register</button>
            </div>
        </form>
        <p class="mt-5">you have an account? <a class="text-blue-500" href="{{ route('login.show') }}">login</a></p>
    </main>
</body>
</html>