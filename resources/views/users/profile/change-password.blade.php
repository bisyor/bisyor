<form action="{{ route('change-password') }}" method="post" autocomplete="off" class="niked change_pass">
    @csrf
    <div class="form-group">
        <label for="#">{{ trans('messages.Current Password') }}*</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required="">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="#">{{ trans('messages.New Password') }}*</label>
        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" value="{{ old('new_password') }}" required="">
        @if ($errors->has('new_password'))
            <span class="help-block">
                <strong>{{ $errors->first('new_password') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="#">{{ trans('messages.New password retry') }}*</label>
        <input type="password" name="retry_password" class="form-control @error('retry_password') is-invalid @enderror" value="{{ old('retry_password') }}" required="">
        @if ($errors->has('retry_password'))
            <span class="help-block">
                <strong>{{ $errors->first('retry_password') }}</strong>
            </span>
        @endif
    </div>
    <button class="more_know blue">{{ trans('messages.Save') }}</button>
</form>