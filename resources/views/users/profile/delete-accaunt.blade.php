<form action="{{ route('delete-accaunt') }}" method="post" autocomplete="off" class="niked change_pass">
    @csrf
    <p class="acc_title">{{ trans('messages.Delete account') }}</p>
    <div class="form-group">
        <label for="current_password">{{ trans('messages.Current Password') }}*</label>
        <input type="password" id="current_password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required="">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <button class="more_know remove_ac">{{ trans('messages.Delete your account') }}</button>
</form>