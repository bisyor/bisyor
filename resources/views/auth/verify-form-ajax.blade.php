<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <form action="#" method="POST" class="registr niked" id="confirm-sms">
                @csrf
                <!-- <a href="javascript:void(0);" class="logo_reg">
                    <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}"
                         alt="{{ Config::get('settings.logo') }}">
                </a> -->
                <h1>{{ trans('messages.SMS configuration') }}</h1>
                <p class="number_sms">{!! $text !!}</p>
                <div class="form-group">
                    <input type="text" name="sms_code" id="sms_code" value="" class="form-control" placeholder="{{ trans('messages.SMS code') }}" required>
                    <span class="help-block">
                        <strong style="color: red;"></strong>
                    </span>
                </div>
                <div class="change_numbers">
                    <a href="javascript:void(0);" onclick="retryVerify();">{{ trans('messages.Send new code') }}</a>
                </div>
                <button class="more_know blue" type="submit">{{ trans('messages.Confirm action') }}</button>
            </form>
        </div>
    </div>
</div>
