@php
    $cat_id = $model->cat_id;
    if(old('cat_id') != null) $cat_id = old('cat_id');
@endphp
<input id="items-cat_id" class="required" type="hidden" name="cat_id" value="{{ $cat_id }}">
<div style="display: none; cursor: auto;" id="exampleModalCat">
    <div id="content-modal"></div>
</div>
@php
    $description = $model->description;
    if(old('description') != null) $description = old('description');
@endphp
<div class="form-group required">
    <label for="description" class="control-label">{{ trans('messages.Details') }}</label>
    <textarea
        class="form-control count_max counter_char @error('description') is-invalid @enderror nativ-required"
        maxlength="4000" name="description">{{ $description }}</textarea>
    <p class="count_chars">
        <span>{{ 4000- strlen($description) }}</span> {{ trans('messages.Characters left')}}</p>
    <div class="help-block">@if($errors->has('description'))
            <strong>{{ $errors->first('description') }}</strong> @endif</div>
</div>
@php
    $publicated_period = $model->publicated_period;
    $srok = date("d.m.Y", strtotime($model->publicated_to));
    if(old('pub_date') != null) {
      $publicated_period = old('pub_date');
      $srok = date("d.m.Y",  strtotime(" + ". (old('pub_date') ? old('pub_date') : 3) ."month", time()));
    }
@endphp
@if(config('settings.general_announcement_period') == 1)
    <div class="form-group">
        <label for="pub_date">{{ trans('messages.Publication Duration') }}</label>
        <div class="sr_mag">
            <select name="pub_date" class="js-select2" id="publicated_to"
                    onchange="publicatedDate($(this))">
                <option value="1" {{ $publicated_period == 1 ? 'selected':'' }}>
                    1 {{ trans('messages.month') }}</option>
                <option value="3" {{ $publicated_period == 3 ? 'selected':'' }}>
                    3 {{ trans('messages.month') }}</option>
                <option value="6" {{ $publicated_period == 6 ? 'selected':'' }}>
                    6 {{ trans('messages.month') }}</option>
                <option value="12" {{ $publicated_period == 12 ? 'selected':'' }}>
                    12 {{ trans('messages.month') }}</option>
            </select>
            <div class="publicated_date">
                <b>{{ str_replace(":date", $srok, trans('messages.To date')) }}</b>
            </div>
        </div>
    </div>
@endif
<div id="additional-fields">
    @include('items.form.additional_fields_update')
</div>
@php
    $video = $model->video;
    if(old('video') != null) $video = old('video');
@endphp
<div class="form-group">
    <label for="video">{{ trans('messages.Link video')}}</label>
    <input type="text" name="video" class="form-control" value="{{ $video }}">
    <div class="help-block">
        @if ($errors->has('video'))
            <strong>{{ $errors->first('video') }}</strong>
        @endif
    </div>
</div>
@php
    $path = config('app.itemsPath');
    $class = 'close_ad_photo_old';
    if(old('photos') != null) {
        $photos = [];
        $temp = explode(",", old('photos'));
        $container = explode(",", $container);
        $trash_path = config('app.trashPath');
        foreach ( $temp as $key => $value) {
            if(in_array($value, $container))
            $photos[] = [ 'filename' => $value, 'image_m' => $path.$value ];
            else
                $photos[] = [ 'filename' => $value, 'image_m' => $trash_path.$value ];
        }
        $container = old('photos');
        $class = 'close_ad_photo';
    }else{
        $temp = $photos;
        $photos = [];
        foreach ( $temp as $key => $value) {
            $photos[] = [ 'filename' => $value['filename'], 'image_m' => $path.$value['image_m'] ];
        }
    }
@endphp
<h4>{{ trans('messages.Photos') }}</h4>
<div class="ad_photos">
    <div class="ad_photos_top">
        <p>{{ trans('messages.Items photo') }}</p>
        <span><b
                class="count_imagae_1212">{{ (isset($category) && isset($category->photos)) ? $category->photos : 5 }}</b> {{ trans('messages.Photos') }}</span>
    </div>
    <div class="ad_photos_main">
        <input type="hidden" name="photos" id="photo_conteyner" value="{{ $container }}">
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
        @if ($photos)
            @foreach ($photos as $value)
                <div class="galax" id="{{ str_replace(".", "", $value['filename']) }}">
                    <div class="rotate_ad_photo" data-name="{{ $value['filename'] }}"></div>
                    <div class="{{ $class }}" data-name="{{ $value['filename'] }}"></div>
                    <img src="{{ $value['image_m'] }}" alt="{{ $value['image_m'] }}">
                </div>
            @endforeach
        @endif
    </div>
    <div class="help-block"></div>
</div>
@php
    $district_id = $model->district_id;
    if(old('district_id') != null) $district_id = old('district_id');
@endphp
<h4>{{ trans('messages.Location') }}</h4>
<div class="form-group required">
    <label for="district_id" class="control-label">{{ trans('messages.City') }}</label>
    <select name="district_id"
            class="js-select2 form-control required @error('district_id') is-invalid @enderror nativ-required"
            id="district_id" onchange="validated($(this))">
        @foreach($regDistricts as $region)
            <optgroup label="{{ $region['name'] }}">
                @foreach($region['districtsList'] as $district)
                    <option
                        {{ ($district_id == $district['id']) ? 'selected':'' }} value="{{ $district['id'] }}">{{ $district['name'] }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <div class="help-block">@if ($errors->has('district_id'))
            <strong>{{ $errors->first('district_id') }}</strong> @endif</div>
</div>
@php
    $name = $model->name;
    if(old('name') != null) $name = old('name');
@endphp
<h4>{{ trans('messages.Contact details') }}</h4>
<div class="form-group required">
    <label for="name" class="control-label">{{ trans('messages.Your name') }}</label>
    <input type="text" name="name" value="{{ $user->name ? $user->name: $name }}"
           class="form-control nativ-required @error('name')is-invalid @enderror">
    <div class="help-block">@if ($errors->has('name'))
            <strong>{{ $errors->first('district_id') }}</strong> @endif</div>
</div>
@php
    $unserialize = unserialize($model->phones);
    if($unserialize != false) $phones_contayner = array_column($unserialize, 'v');
    else $phones_contayner = null;
    if(old('phones') != null) $phones_contayner = old('phones');
    $count = 1;
@endphp
<div class="form-group add_some" data-quantity-input="5">
    <label for="phones">{{ trans('messages.Contacts') }}</label>
    @if($phones_contayner)
        @foreach($phones_contayner as $value)
            <div class="inpt_clones">
                <input type="text" name="phones[]" class="form-control sirt" placeholder=""
                       value="{{ $value }}">
                <div class="clos_contact" {{ $count == 1 ? 'style=display:none;' : '' }}></div>
            </div>
            @php $count++; @endphp
        @endforeach
    @else
        <div class="inpt_clones">
            <input type="text" name="phones[]" class="form-control sirt"
                   placeholder="+998XX-XXX-XX-XX">
            <div class="clos_contact" style="display: none;"></div>
        </div>
    @endif

    <span
        class="add_some_contact" {{ $count >= $settings->value ? 'style=display:none;' : '' }}>{{ trans('messages.+ another phone') }}</span>
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
            echo '<input type="hidden" data-id="'.$value.'" name="'.$value.'" id="hidden-items-'.$value.'" value="'.(old($value) ? old($value) : $model->{$value}).'">';
        }
        $k = 1;
        while ($k < $dynamic_fields_based_category_setting_count) {
            $value = 'f'.$k;
            $k++;
            echo '<input type="hidden" data-id="'.$value.'" name="'.$value.'" id="hidden-items-'.$value.'" value="'.(old($value) ? old($value) : $model->{$value}).'">';
        }
    @endphp
</div>
<input type="hidden" id="category_list" name="category_list"
       value='{{ ($category_list ? $category_list : old('category_list')) }}'>
<a href="{{ url()->previous() }}" class="btn btn-danger" style="float: left;
    padding-left: 60px;
    padding-right: 60px;
    line-height: 35px;
    color: #fff;
    border-radius: 4px;
    height: 48px;
    display: block;
    margin-top: 24px;">{{ trans('messages.Back') }}</a>
<button type="submit" class="more_know prevent-button"><span
        class="spinner fa fa-spinner fa-spin text-white"></span> {{ trans('messages.Save') }}</button>
