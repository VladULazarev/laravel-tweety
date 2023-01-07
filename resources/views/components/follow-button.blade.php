<form method="POST" action="{{ route('follow', $user->username) }}">
    @csrf

    @if ( auth()->user()->following($user) )
        <button type="submit" class="follow-btn shadow-sm">
            <span>Читаю</span>
        </button>
    @else
        <button type="submit" class="btn-white shadow-sm">
            <span>Читать</span>
        </button>
    @endif
</form>