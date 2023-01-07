<!-- Home -->
<x-app-layout>

    <div class="col-lg-7 cont">

        @include('inc.publish-message-panel')

        <div class="timeline">
            @forelse ($tweets as $tweet)
                @include('inc.tweets')
            @empty
                Сообщений нет.
            @endforelse
        </div>

        <div id="observer"></div>

        <div class="flex justify-center preloader">
            <img src="/images/preloader.gif" alt="Preloader image">
        </div>

    </div>

</x-app-layout>
