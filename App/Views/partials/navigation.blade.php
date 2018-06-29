<header class="header">
    <nav class="header__nav">
        <ul>
            @if(!$Auth->check())
            <li class="header__nav-item"><a class="header__nav-item-link" href="{{ route('login.index') }}">Login</a></li>
            <li class="header__nav-item"><a class="header__nav-item-link" href="{{ route('register.index') }}">Register</a></li>
            @endif @if($Auth->check())
            <li class="header__nav-item"><a class="header__nav-item-link" href="{{ route('logout') }}">Logout</a></li>
            @endif
        </ul>
    </nav>
</header>