<form action="{{ route('profile-change-settings') }}" method="post" autocomplete="off">
    @csrf
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications of new posts') }}</p>
        <input type="checkbox" id="switchev" name="sms_news_alert" {{ $user->sms_news_alert ? 'checked=""' : '' }} />
        <label for="switchev">Toggle</label>
    </div>
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications commentary on ads') }}</p>
        <input type="checkbox" id="switchasc" name="sms_comment_alert" {{ $user->sms_comment_alert ? 'checked=""' : '' }} />
        <label for="switchasc">Toggle</label>
    </div>
    <div class="form-group checkbox_style">
        <p>{{ trans('messages.Notifications of price changes') }}</p>
        <input type="checkbox" id="switcha" name="sms_fav_ads_price_alert" {{ $user->sms_fav_ads_price_alert ? 'checked=""' : '' }} />
        <label for="switcha">Toggle</label>
    </div>
    <button class="more_know blue">{{ trans('messages.Save') }}</button>
</form>