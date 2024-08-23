<form action="{{ route('change-phone') }}" method="post" autocomplete="off" class="niked change_pass">
    @csrf
    <div class="form-group">
        <label for="#">{{ trans('messages.Current Phone') }}*</label>
        <input type="tel" name="phone"
               class="form-control tel_uz @error('phone') is-invalid @enderror"
               value="{{ old('phone') != null ? old('phone') : $user->phone }}" {{ $user->phone ? "disabled=''":""}} placeholder="+998xx-xx-xx-xx">
        {!! $user->phone ? "<input type='hidden' name='phone' value=". $user->phone .">": '' !!}
    @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="#">{{ trans('messages.New Phone') }}*</label>
        <input type="tel" name="new_phone" class="form-control tel_uz @error('new_phone') is-invalid @enderror"
               value="{{ old('new_phone') }}" placeholder="+998xx-xx-xx-xx">
        @if ($errors->has('new_phone'))
            <span class="help-block">
                <strong>{{ $errors->first('new_phone') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="#">{{ trans('messages.Password') }}*</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               value="{{ old('password') }}">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <button class="more_know blue">{{ trans('messages.Save') }}</button>
</form>
