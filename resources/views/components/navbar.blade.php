<nav class="py-2 px-3 sm:flex justify-between items-center z-30 shadow-sm">
    <div class="flex justify-between">
        <h1 class="text-xl font-bold text-blue-400">SM</h1>
        <button id="nav-btn" class="sm:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24">
                <path d="M20 7L4 7" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M20 12L4 12" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M20 17L4 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
    <ul id="nav" class="w-fit hidden sm:block sm:flex justify-end align-center gap-4">
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

<script>
    const navbar = document.getElementById('nav');
    const navBtn = document.getElementById('nav-btn');
    navBtn.addEventListener('click', () => {
        if (navbar.classList.contains('hidden')) {
            navBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="1.5rem" height="1.5rem" viewBox="-3.5 0 19 19" class="cf-icon-svg"><path d="M11.383 13.644A1.03 1.03 0 0 1 9.928 15.1L6 11.172 2.072 15.1a1.03 1.03 0 1 1-1.455-1.456l3.928-3.928L.617 5.79a1.03 1.03 0 1 1 1.455-1.456L6 8.261l3.928-3.928a1.03 1.03 0 0 1 1.455 1.456L7.455 9.716z"/></svg>';
        } else {
            navBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="1.5rem" height="1.5rem" viewBox="0 0 24 24"><path d="M20 7L4 7" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/><path d="M20 12L4 12" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/><path d="M20 17L4 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/></svg>';
        }
        navbar.classList.toggle('hidden');
    });
</script>