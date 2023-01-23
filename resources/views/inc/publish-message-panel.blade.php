<div class="message">

    <form>

        <input type="hidden" name="current-user" value="{{ auth()->id() }}">


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
            <button class="btn-blue shadow-sm new-tweet" type="submit">Твитнуть</button>
        </footer>

        @error('body')
            <span class="laravel-alert">{{ $errors->first('body') }}</span>
        @enderror
    </form>
</div>

<div class="form-errors">
    <div class="tweet-error"></div>
</div>