<form action="{{ route('profile-change-settings') }}" method="post" autocomplete="off" enctype="multipart/form-data"
      class="contact_det_in_data">
    @csrf
    <div class="in_data">
        <img src="{{ $user->getAvatar() }}" alt="Avatar" class="fead" id="preview"/>
        <label for="teret">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                <g>
                    <g>
                        <path
                            d="M5.75.25h4.5l1.373 1.5H14c.825 0 1.5.675 1.5 1.5v9c0 .825-.675 1.5-1.5 1.5H2c-.825 0-1.5-.675-1.5-1.5v-9c0-.825.675-1.5 1.5-1.5h2.377zM8 11.5c2.07 0 3.75-1.68 3.75-3.75C11.75 5.68 10.07 4 8 4 5.93 4 4.25 5.68 4.25 7.75c0 2.07 1.68 3.75 3.75 3.75zM5.6 7.75a2.4 2.4 0 1 1 4.8 0 2.4 2.4 0 0 1-4.8 0z"/>
                    </g>
                </g>
            </svg>
        </label>
        <input class="choose" type="file" name="profile_image" accept="image/*" id="teret">
        <input type="hidden" name="image_change" class="image_change">
    </div>
    <div class="right_main_set niked">
        <div class="form-group">
            <label for="#">{{ trans('messages.Your id') }}: <span>{{$user->id}}</span></label>
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.Full Name') }}*</label>
            <input type="text" class="form-control" required="" name="fio" value="{{ $user->fio }}"
                   placeholder="{{ trans('messages.Full Name') }}">
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.Date birthday') }}</label>
            <input type="text" class="form-control" required="" id="birthday" name="birthday"
                   value="{{ $user->birthday }}"
                   placeholder="{{ trans('messages.Date birthday') }}">
            @error('birthday')
            <div class="help-block">
                <strong>{{ str_replace('birthday', trans('messages.Date birthday'), $message) }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.Sex') }}</label>
            <select name="sex" class="js-select2" data-minimum-results-for-search="Infinity">
                <option disabled {{ !$user->sex ?: "selected" }}>{{ trans('messages.Select your sex') }}</option>
                <option {{ $user->sex == 1 ? "selected" : "" }} value="1">{{trans('messages.Man')}}</option>
                <option {{ $user->sex == 2 ? "selected" : "" }} value="2">{{trans('messages.Woman')}}</option>
            </select>
        </div>
        <div class="form-group add_some">
            <label for="#">{{ trans('messages.Contacts') }}</label>
            @if(!empty($user->phones))
                @php $i = 0; @endphp
                @foreach( json_decode($user->phones) as $phone)
                    @if(++$i == 1)
                        <input type="text" name="phones[]" value="{{ $phone }}" placeholder="+998xx-xx-xx-xx"
                               class="form-control">
                        <span class="add_some_cl">{{ trans('messages.+ another phone') }}</span>
                    @else
                        <div class="inpt_clones">
                            <input type="text" name="phones[]" value="{{ $phone }}" placeholder="+998xx-xx-xx-xx"
                                   class="form-control">
                            <div class="clos"></div>
                        </div>
                    @endif
                @endforeach
            @else
                <input type="text" name="phones[]" placeholder="+998xx-xx-xx-xx" class="form-control">
                <span class="add_some_cl">{{ trans('messages.+ another phone') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.Telegram') }}</label>
            <input type="text" class="form-control" name="telegram" value="{{ $user->telegram }}" placeholder="@">
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.City') }}</label>
            <select name="district_id" class="js-select2" id="district_id">
                <option disabled @if(!$user->district_id) selected @endif>{{ trans('messages.Select') }}</option>
                @foreach($additional->regDistricts() as $region)
                    <optgroup label="{{ $region['name'] }}">
                        @foreach($region['districtsList'] as $district)
                            <option
                                value="{{ $district['id'] }}" {{ $user->district_id == $district['id'] ? 'selected=' : '' }} >{{ $district['name'] }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="#">{{ trans('messages.The exact address') }}</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}"
                   placeholder="{{ trans('messages.Address') }}">
        </div>
        <input type="hidden" id="coordinate_x" name="coordinate_x" value="{{ $user->coordinate_x }}"/>
        <input type="hidden" id="coordinate_y" name="coordinate_y" value="{{ $user->coordinate_y }}"/>
        <div id="map"></div>
        <button class="more_know blue">{{ trans('messages.Save') }}</button>
    </div>
</form>
