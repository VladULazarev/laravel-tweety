
<x-app-layout>
<div class="col-lg-7 cont">
    <div class="timeline">

        @foreach ($users as $user)
        <div class="row tweet">

            <div class="col-lg-1">
                <a href="{{ $user->path() }}">
                    <img class="rounded-circle" src="{{ $user->avatar }}" alt="" width="50">
                </a>
            </div>

            <div class="col-lg-11 ps-4">

                <div class="flex justify-content-between items-center">
                    <div>
                        <a class="link-to-profile link-in-explore" href="{{ $user->path() }}">
                            {{ $user->username }}
                        </a>
                        <span class="block gray mb-1">{{ '@' . $user->username }}</span>
                    </div>

                    <div class="flex justify-end">
                        @if (auth()->user()->name != $user->name )
                            <x-follow-button :user="$user"></x-follow-button>
                        @endif
                    </div>
                </div>

                <div>
                    @if ( $user->user_desc )
                        <p class="break-all">
                            {{ $user->user_desc }}
                        </p>
                    @else
                        <p></p>
                    @endif
                </div>

            </div>
            <hr>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>
