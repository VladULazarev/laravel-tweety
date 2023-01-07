<div class="right-side-bar">

    <h4 class="mb-4">Друзья</h4>

    <ul>
        @forelse(auth()->user()->follows as $user)
        <li class="mb-3">
            <div class="friends">
                <a href="{{ route('user-profile', $user) }}">
                    <img class="rounded-circle me-3"
                    width="50"
                    src="{{ $user->avatar }}"
                    alt="{{ $user->username }}'s avatar">
                </a>
                <a class="right-side-link" href="{{ route('user-profile', $user->username) }}">
                    {{ $user->username }}
                </a>
            </div>
        </li>
        @empty
        <li class="mb-3">
            <div class="friends py-2 ps-3">
                У Вас нет друзей.
            </div>
        </li>
        @endforelse
    </ul>

</div>