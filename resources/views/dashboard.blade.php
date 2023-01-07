<x-app-layout>

    <div class="row">

        <div class="col-lg-2">
            @include('inc.left-side-bar')
        </div>

        <div class="col-lg-7 cont">

            @include('inc.publish-message-panel')

            <div class="timeline">
            @foreach($tweets as $tweet)
                @include('inc.tweets')
            @endforeach
            </div>

        </div>

        <div class="col-lg-3">
            @include('inc.right-side-bar')
        </div>

    </div>
</x-app-layout>
