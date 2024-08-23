<div id="categories" class="form-group required">
    <label for="category" class="control-label">{{ trans('messages.Category') }}</label>
    <a href="#exampleModalCat"
       class="for_cat_list form-control @error('cat_id') is-invalid @enderror">{{ trans('messages.Select') }}...</a>
    <span class="help-block">@if ($errors->has('cat_id'))<strong>{{ $errors->first('cat_id') }}</strong> @endif</span>
</div>

<input id="items-cat_id" class="required" type="text" name="cat_id" value="{{ old('cat_id') }}" hidden="hidden">

<div style="display: none; cursor: auto;" id="exampleModalCat">
    <div id="content-modal"></div>
</div>

<div class="form-group required">
    <label for="description" class="control-label">{{ trans('messages.Details') }}</label>
    <textarea class="form-control counter_char count_max @error('description') is-invalid @enderror nativ-required"
              maxlength="4000" name="description">{{ old('description') }}</textarea>
    <p class="count_chars"><span>{{ 4000- strlen(old('description')) }}</span> {{ trans('messages.Characters left')}}
    </p>
    <div class="help-block">@if($errors->has('description'))<strong>{{ $errors->first('description') }}</strong> @endif
    </div>
</div>
@if(config('settings.general_announcement_period') == 1)
<div class="form-group">
    <label for="pub_date">{{ trans('messages.Publication Duration') }}</label>
    <div class="sr_mag">
        <select name="pub_date" class="js-select2" id="publicated_to" onchange="publicatedDate($(this))">
            <option value="1" {{ old('pub_date') == 1 ? 'selected':'' }}>1 {{ trans('messages.month') }}</option>
            <option value="3" {{ old('pub_date') == 3 ? 'selected':'' }}>3 {{ trans('messages.month') }}</option>
            <option value="6" {{ old('pub_date') == 6 ? 'selected':'' }}>6 {{ trans('messages.month') }}</option>
            <option value="12" {{ old('pub_date') == 12 ? 'selected':'' }}>12 {{ trans('messages.month') }}</option>
        </select>
        <div class="publicated_date">
            <b>{{ str_replace(":date", date("d.m.Y",  strtotime(" + ". (old('pub_date') ? old('pub_date') : 3) ."month", time())), trans('messages.To date')) }}</b>
        </div>
    </div>
</div>
@endif
<div id="additional-fields">
    @if(old('for_req'))
        @include('items.form.additional_fields_validate')
    @endif
</div>
<div class="form-group">
    <label for="video">{{ trans('messages.Link video')}}</label>
    <input type="text" name="video" class="form-control" value="{{ old('video') }}">
    <div class="help-block">
        @if ($errors->has('video'))
            <strong>{{ $errors->first('video') }}</strong>
        @endif
    </div>
</div>
<h4>{{ trans('messages.Photos') }}</h4>
<div class="ad_photos">
    <div class="ad_photos_top">
        <p>{{ trans('messages.Items photo') }}</p>
        <span><b class="count_imagae_1212">5</b> {{ trans('messages.Photos') }}</span>
    </div>
    <div class="ad_photos_main">
        <input type="hidden" name="photos" id="photo_conteyner" value="{{ old('photos') }}">
        <label>
            <input type="file" id="file_inp" multiple="" accept="image/*">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                <g>
                    <g>
                        <path
                            d="M5.75.25h4.5l1.373 1.5H14c.825 0 1.5.675 1.5 1.5v9c0 .825-.675 1.5-1.5 1.5H2c-.825 0-1.5-.675-1.5-1.5v-9c0-.825.675-1.5 1.5-1.5h2.377zM8 11.5c2.07 0 3.75-1.68 3.75-3.75C11.75 5.68 10.07 4 8 4 5.93 4 4.25 5.68 4.25 7.75c0 2.07 1.68 3.75 3.75 3.75zM5.6 7.75a2.4 2.4 0 1 1 4.8 0 2.4 2.4 0 0 1-4.8 0z"></path>
                    </g>
                </g>
            </svg>
            <span>{{ trans('messages.Load photo')}}</span>
        </label>
        @if (old('photos'))
            @php $photos = explode(",", old('photos')); @endphp
            @foreach ($photos as $value)
                <div class="galax" id="">
                    <div class="close_ad_photo" data-name="{{ $value }}"></div>
                    <img src="{{ config('app.trashPath').$value }}" alt="{{ $value }}">
                </div>
            @endforeach
        @endif
    </div>
    <div class="help-block"></div>
</div>
<h4>{{ trans('messages.Location') }}</h4>
<div class="form-group required">
    <label for="district_id" class="control-label">{{ trans('messages.City') }}</label>
    <select name="district_id"
            class="js-select2 form-control required @error('district_id') is-invalid @enderror nativ-required"
            id="district_id">
        <option value disabled="" {{ !old('district_id') ? 'selected':'' }}>{{ trans('messages.Select') }}...</option>
        @foreach($regDistricts as $region)
            <optgroup label="{{ $region['name'] }}">
                @foreach($region['districtsList'] as $district)
                    @php
                        $selected = '';
                        if(old('district_id') != null) {
                            if(old('district_id') == $district['id']) $selected = 'selected';
                        }
                        else {
                            if($user->district_id == $district['id']) $selected = 'selected';
                        }

                    @endphp
                    <option {{ $selected }} value="{{ $district['id'] }}">{{ $district['name'] }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <div class="help-block">@if ($errors->has('district_id'))<strong>{{ $errors->first('district_id') }}</strong> @endif
    </div>
</div>
<h4>{{ trans('messages.Contact details') }}</h4>
<div class="form-group required">
    <label for="name" class="control-label">{{ trans('messages.Your name') }}</label>
    <input type="text" name="name" value="{{ $user->fio ? $user->fio : old('name') }}"
           class="form-control nativ-required @error('name')is-invalid @enderror">
    <div class="help-block">@if ($errors->has('name'))<strong>{{ $errors->first('district_id') }}</strong> @endif</div>
</div>
<div class="form-group add_some" data-quantity-input="5">
    <label for="phones">{{ trans('messages.Contacts') }}</label>
    @if(old('phones'))
        @php $count = 1; @endphp
        @foreach(old('phones') as $value)
            <div class="inpt_clones">
                <input type="text" name="phones[]" class="form-control sirt" placeholder="" value="{{ $value }}">
                <div class="clos_contact" {{ $count == 1 ? 'style="display:none;"' : '' }}></div>
            </div>
            @php $count++; @endphp
        @endforeach
    @else
        @if ($user->phones)
            @php $phones = json_decode($user->phones); $count = 1; @endphp
            @foreach ($phones as $value)
                <div class="inpt_clones">
                    <input type="text" name="phones[]" class="form-control sirt" placeholder="" value="{{ $value }}">
                    <div class="clos_contact" {{ $count == 1 ? 'style=display:none;' : '' }}></div>
                </div>
                @php $count++; @endphp
            @endforeach
        @else
            <div class="inpt_clones">
                <input type="text" name="phones[]" class="form-control sirt" placeholder="+998xx-xxx-xx-xx">
                <div class="clos_contact" style="display: none;"></div>
            </div>
        @endif
    @endif

    <span class="add_some_contact">{{ trans('messages.+ another phone') }}</span>
</div>
<div id="hidden-additional-fields">
    @php
        $dynamic_fields_based_category = [
            'owner_type',
            'cat_type',
            'coordinate_x',
            'coordinate_y',
            'price',
            'price_search',
            'currency_id',
            'address',
            'price_ex',
            'price_end'
        ];
        $dynamic_fields_based_category_setting_count = 25;
        foreach ($dynamic_fields_based_category as $key => $value) {
            echo '<input type="hidden" data-id="'.$value.'" name="'.$value.'" id="hidden-items-'.$value.'" value="'.old($value).'">';
        }
        $k = 1;
        while ($k < $dynamic_fields_based_category_setting_count) {
            $value = 'f'.$k;
            $k++;
            echo '<input type="hidden" data-id="'.$value.'" name="'.$value.'" id="hidden-items-'.$value.'" value="'.old($value).'">';
        }
    @endphp
</div>
<div class="limit-list mt-5">
    {{--    @if($errors->has('limitbalance'))--}}
    {{--        @include('items.form.limitList')--}}
    {{--    @endif--}}
</div>
<input type="hidden" id="category_list" name="category_list"
       value='{{ ($category_list ? $category_list : old('category_list')) }}'>
<button type="submit" class="more_know prevent-button"><span
        class="spinner fa fa-spinner fa-spin text-white"></span> {{ trans('messages.Submit Items') }}</button>
