<nav class="py-2 px-3 z-30">
    <ul class="flex justify-end align-center gap-4">
        @auth
            <input type="hidden" name="auth-user" id="auth-user" value="{{ auth()->id() }}">
            <li>
                <a href="{{ route('home') }}">home</a>
            </li>
            <li>
                <a href="{{ route('posts.index') }}">Your posts</a>
            </li>
            <li>
                <a href="{{ route('users.show', auth()->id() ) }}">Profile</a>
            </li>
            <li class="relative">
                <a href="{{ route('notification.index') }}">Notifications</a>
                <div id="notification-bubble" class="hidden absolute top-0 right-0 w-2 h-2 bg-red-500 rounded"></div>
            </li>
            <li>
                <a href="{{ route('users.index') }}">Users</a>
            </li>
            <li>
                <a href="{{ route('conversation.index') }}">Chat</a>
            </li>
            <li>
                <a href="{{ route('login.logout') }}">logout</a>
            </li>
        @endauth
        @guest
            <a class="text-blue-400 font-semibold" href="{{ route('login.show') }}">login</a>
            <a class="text-blue-400 font-semibold" href="{{ route('register.show') }}">register</a>
        @endguest
    </ul>
</nav>