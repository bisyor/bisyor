<section class="result_section">
    <form style="display: none;" action="{{ route('save-search-text') }}" method="post">
        @csrf
        <input type="hidden" name="text" value="{{ request()->input('query') }}">
        <button type="submit" id="save-search-text-button"></button>
    </form>
    <div class="saved_result_form">
        <p><img src="/images/save-file-option.svg" alt="">{{ trans('messages.Save the search result') }} :</p>
        <button onclick="$('#save-search-text-button').trigger('click')">{{ trans('messages.Save') }}</button>
        <a href="{{ Auth::check() ? route('items-favorites') : route('list-searched-text') }}">{{ trans('messages.View saved') }}</a>
    </div>
</section>