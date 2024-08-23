<form action="{{ route('profile-change-settings') }}" method="post" autocomplete="off">
    @csrf
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Newsletter Bisyor.uz') }}</p>
        <input type="checkbox" id="switch" name="email_news_alert" {{ $user->email_news_alert ? 'checked=""' : '' }} />
        <label for="switch">Toggle</label>
    </div>
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications of new posts') }}</p>
        <input type="checkbox" id="switch2" name="email_message_alert" {{ $user->email_message_alert ? 'checked=""' : '' }} />
        <label for="switch2">Toggle</label>
    </div>
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications commentary on ads') }}</p>
        <input type="checkbox" id="switch3" name="email_comment_alert" {{ $user->email_comment_alert ? 'checked=""' : '' }} />
        <label for="switch3">Toggle</label>
    </div>
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications of price changes') }}</p>
        <input type="checkbox" id="switch4" name="email_fav_ads_price_alert" {{ $user->email_fav_ads_price_alert ? 'checked=""' : '' }} />
        <label for="switch4">Toggle</label>
    </div>
    <button class="more_know blue">{{ trans('messages.Save') }}</button>
</form>