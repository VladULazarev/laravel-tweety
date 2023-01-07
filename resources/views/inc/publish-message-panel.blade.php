<div class="message">

    <form method="POST" action="{{ route('store-tweet') }}">
        @csrf

        <textarea class="form-control"
            name="body"
            id="body"
            maxlength="255"
            placeholder="Ваше сообщение..."
            required autocomplete="off"></textarea>

        <hr>

        <footer>
            <img class="rounded-circle"
                src="{{ auth()->user()->avatar }}"
                alt="Your avatar">
            <button class="btn-blue shadow-sm" type="submit">Твитнуть</button>
        </footer>

        @error('body')
            <span class="laravel-alert">{{ $errors->first('body') }}</span>
        @enderror
    </form>
</div>