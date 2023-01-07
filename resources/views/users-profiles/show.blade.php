<!-- Home -->
<x-app-layout>
    <div class="col-lg-7 cont">

        <header class="profile-header">

            <div class="relative">
                <img class="profile-bunner mb-4 mw-100" src="/images/default-banner.jpg"
                    alt="Pofile banner">
                <img class="rounded-circle me-3 profile-avatar"
                    src="{{ $user->avatar }}"
                    alt="{{ $user->username }}'s avatar">
            </div>

            <div class="profile-content">

                <div class="flex justify-end mb-5">
                    @if (auth()->user()->name == $user->name )
                        <a href="{{ route('profile.edit') }}"
                        class="btn-white shadow-sm">Изменить профиль</a>
                    @else
                        <x-follow-button :user="$user"></x-follow-button>
                    @endif
                </div>

                <div class="mb-3">

                    @if ( $user->name == auth()->user()->name )
                    <div class="profile-name">{{ $user->name }}</div>
                    @else
                    <div class="profile-name">{{ $user->username }}</div>
                    @endif

                    <div class="register-name">{{ '@' . $user->username }}</div>
                </div>

                @if ( $user->user_desc )
                <p class="break-all">
                    {{ $user->user_desc }}
                </p>
                @endif

                <div class="register-date mb-3">
                    <p>Регистрация: {{ $user->created_at->diffForHumans() }}</p>
                </div>

            </div>

        </header>

        <div class="timeline">
            @forelse($tweets as $tweet)
                @include('inc.tweets')
            @empty
                <div class="row tweet">

                    <div class="col-12 ps-1">
                        <p class="break-all">Нет сообщений.</p>
                    </div>
                    <hr>
                </div>
            @endforelse
        </div>

        <div id="observer"></div>

        <div class="flex justify-center preloader">
            <img src="/images/preloader.gif" alt="Preloader image">
        </div>

    </div>
</x-app-layout>