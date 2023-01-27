<div class="row tweet {{ $tweet->id }}" data-value="{{ $tweet->id }}">

    <div class="col-lg-1">
        <a href="{{ route('user-profile', $tweet->user) }}">
            <img class="rounded-circle"
             src="{{ $tweet->user->avatar }}"
             alt="{{ $tweet->user->username }}'s avatar"
             width="50">
        </a>
    </div>

    <div class="col-lg-11 ps-4 relative">

        <div>
            <a class="link-to-profile" href="{{ route('user-profile', $tweet->user) }}">
                {{ $tweet->user->username }}
            </a>
            <span class="gray">{{ '@' . $tweet->user->username }}</span>
            <span class="gray">· </span><span class="gray">Сегодня {{ $tweet->created_at->toTimeString() }}</span>
        </div>

        <p class="break-all">
            {{ $tweet->body }}
        </p>

        @if ( $tweet->user->name == auth()->user()->name )
        <div class="tweet-dots rounded-circle" title="Ещё">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <g><path d="M3 12c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9 2c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm7 0c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
            </g></svg>
        </div>

        <div class="delete-tweet" data-value="{{ $tweet->id }}">Удалить</div>
        @endif

    </div>
    <hr>
</div>
