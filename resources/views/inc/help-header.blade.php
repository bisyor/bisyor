<header>
    <div class="container">
        <div class="helping_header">
            <a href="{{ route('site-index') }}">
                <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="Logo">
            </a>
            <a href="{{ 'javascript:void(0)' }}" class="help_center">{{ trans('messages.Help center') }}</a>
            <form action="{{ route('help-search') }}" class="search_form_header" method="GET">
                <input type="text" name="q" required="" 
                placeholder="{{ trans('messages.Search') }}" value = "{{ old('q') }}">
                <button type="submit"><img src="/images/search.svg" alt="search"></button>
            </form>
        </div>
    </div>
</header>