<header>
    <ul>
        @if(!$Auth->check())
        <li><a href="{{ route('login.index') }}">Login</a></li>
        <li><a href="{{ route('register.index') }}">Register</a></li>
        @endif
        @if($Auth->check())
        <li><a href="{{ route('logout') }}">Logout</a></li>
        @endif
    </ul>
</header>