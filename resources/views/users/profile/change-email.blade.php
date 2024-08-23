<form action="{{ route('change-email') }}" method="post" autocomplete="off" class="niked change_pass">
    @csrf
    <div class="form-group">
        <label for="#">{{ trans('messages.your_email') }}: <span>{{$user->email ?: trans('messages.email_empty')}}</span></label>
    </div>
    <div class="form-group">
        <label for="#">@lang('messages.New E-mail')*</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}">
        @error ('email')
        <span class="help-block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="#">@lang('messages.Password')*</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               value="{{ old('password') }}">
        @error ('password')
        <span class="help-block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <button class="more_know blue">@lang('messages.Save')</button>
</form>
