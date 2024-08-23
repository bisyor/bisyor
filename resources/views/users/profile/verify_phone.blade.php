<form action="{{ route('change-phone-verify') }}" method="post" autocomplete="off" class="niked change_pass">
    @csrf
    <div class="form-group">
        <label for="#">{{ trans('messages.For changed number, need confirm sms code') }}</label>
        <p class="number_sms">{!! str_replace('{phone_number}', '<b> ' . $new_phone . ' </b>', trans('messages.Send message to phone')) !!}</p>
        <input type="hidden" name="new_phone" value="{{$new_phone}}">
        <input type="text" name="sms_code" class="form-control @error('sms_code') is-invalid @enderror"
               value="{{ old('sms_code') }}" placeholder="{{ trans('messages.SMS code') }}">
        @if ($error_message)
            <span class="help-block">
                <strong>{{ $error_message }}</strong>
            </span>
        @endif
    </div>
    <button class="more_know blue">{{ trans('messages.Save') }}</button>
</form>
