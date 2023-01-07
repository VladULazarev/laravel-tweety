<ul class="left-side-bar-ul">

    <li><i class="fa fa-home"></i>
        <a class="{{ request()->segment(1) === 'home' ? 'active-link' : 'left-side-bar-link' }}"
        href="{{ route('tweets.index') }}">Главная</a>
    </li>

    <li><i class="far fa-hashtag"></i>
        <a class="{{ request()->segment(1) === 'explore' ? 'active-link' : 'left-side-bar-link' }}"
        href="{{ route('explore') }}">Обзор</a>
    </li>

    <li><i class="far fa-user"></i>
        <a class="{{ request()->segment(1) === 'profiles' ? 'active-link' : 'left-side-bar-link' }}"
        href="{{ route( 'user-profile', auth()->user() ) }}">Профиль</a>
    </li>

    <li><i class="far fa-user"></i>
        <form class="d-inline" method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="left-side-bar-link">Выйти</button>
        </form>
    </li>

</ul>

