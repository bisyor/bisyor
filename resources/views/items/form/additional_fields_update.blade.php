@php
    use App\Models\Items\CategoriesDynprops;
    if(old('for_req')){
      $category = \App\Models\Items\Categories::find(old('cat_id'));
      $category->getPriceSett($langs);
      $fields = $category->getAdditionalFields();
    }
@endphp
<input type="hidden" name="" id="max-count-images"
       value="{{ (isset($category) && isset($category->photos)) ? $category->photos : 5 }}">
<input type="hidden" name="for_req" value="{{ json_encode($fields) }}">
@if($category)
    <!-- tip obyevleniya uchun -->
    @if ($category->seek == 1)
        @php
            $owner_type = $model->owner_type;
            $cat_type = $model->cat_type;
        @endphp
        <div class="form-group field-items-cat_type star-input">
            <label class="control-label" for="items-cat_type">{{ trans('messages.Type items') }}</label>
            <select id="items-cat_type" class="form-control js-select2 hide-search"
                    data-minimum-results-for-search="Infinity" aria-invalid="false"
                    onchange="$('#hidden-'+$(this).attr('id')).val($(this).val()); $(this).next().next('.help-block').html('')">
                <option value="" disabled selected>{{ trans("messages.Select") }}</option>
                <option
                    value="1" {{ $cat_type == 1 ? 'selected' : '' }}>{{ ($category->type_offer_form != '') ? $category->type_offer_form : trans('messages.Offer') }}</option>
                <option
                    value="2" {{ $cat_type == 2 ? 'selected' : '' }}>{{ ($category->type_seek_form != '') ? $category->type_seek_form : trans('messages.Seek') }}</option>
            </select>
            <div class="help-block"></div>
        </div>
    @endif
@endif
@foreach ($fields as $key => $value)
    <div class="form-group field-items-f{{ $value->data_field }} {{ ($value->req == 1) ? 'required' : '' }}">
        <label class="control-label" for="items-f{{ $value->data_field }}">{!! $value->title !!}</label>
        <!-- textinput uchun -->
        @if($value->type == CategoriesDynprops::TYPE1)
            @php
                $ftype1 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype1 = old("f$value->data_field");
            @endphp
            <div class="form-group">
                <input type="text" id="items-f{{ $value->data_field }}" value="{{ $ftype1 }}"
                       class="form-control @error("f$value->data_field") is-invalid @enderror"
                       onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));">
                @if($value->description)
                    <span class="input-group-addon">{{ $value->description }}</span>
                @endif
            </div>
            <div class="help-block">@if ($errors->has("f$value->data_field"))
                    <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
            </div>
        @endif
    <!-- textarea uchun -->
        @if($value->type == CategoriesDynprops::TYPE2)
            @php
                $ftype2 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype2 = old("f$value->data_field");
            @endphp
            <div class="form-group">
                <textarea id="items-f{{ $value->data_field }}" value="{{ $ftype2 }}" onchange="validated($(this));"
                          class="form-control @error("f$value->data_field") is-invalid @enderror" rows="8"
                          aria-invalid="false"></textarea>
            </div>
            <div class="help-block">@if ($errors->has("f$value->data_field"))
                    <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
            </div>
        @endif
    <!-- vibor da/net uchun -->
        @if($value->type == CategoriesDynprops::TYPE4)
            @php
                $ftype4 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype4 = old("f$value->data_field");
            @endphp
            <div id="items-f{{ $value->data_field }}" role="radiogroup">
                <label><input type="radio" {{ $ftype4 ==1 ? 'checked' : '' }} name="items-f{{ $value->data_field }}"
                              onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                              value="1"> {{ trans('messages.Yes') }}</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="radio" {{ $ftype4 == 0 ? 'checked' : '' }} name="items-f{{ $value->data_field }}"
                              onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                              value="0"> {{ trans('messages.No') }}</label>
                <div class="help-block">@if ($errors->has("f".$value->data_field))
                        <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
                </div>
            </div>
        @endif
    <!-- vibor flag uchun -->
        @if($value->type == CategoriesDynprops::TYPE5)
            @php
                $ftype5 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype5 = old("f$value->data_field");
            @endphp
            <div class="form-group field-items-f{{ $value->data_field }}>">
                <label class="checkbox">
                    <input type="checkbox" value="{{ $ftype5 }}"
                           {{ $ftype5 ? 'checked' : '' }} id="items-f{{ $value->data_field }}"
                           onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));"
                           class="form-control @error("f".$value->data_field) is-invalid @enderror">
                </label>
                <div class="help-block">@if ($errors->has("f".$value->data_field))
                        <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
                </div>
            </div>
        @endif
    <!-- vipadayushiy spisok uchun -->
        @if($value->type == CategoriesDynprops::TYPE6)
            @php
                $ftype6 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype6 = old("f$value->data_field");
            @endphp
            <div class="form-group">
                <select id="items-f{{ $value->data_field }}" class="form-control js-select2" aria-invalid="false"
                        onchange="validated($(this));" value="{{ $ftype6 }}">
                    @php $variants = $value->getVariants(); @endphp
                    <option disabled selected>{{ trans("messages.Select") }}</option>
                    @foreach ($variants as $key => $variant)
                        <option
                            value="{{ $variant->value }}" {{ $ftype6 == $variant->value ? 'selected' : '' }}>{{ $variant->name }}</option>
                    @endforeach
                </select>
                <div class="help-block">@if ($errors->has("f$value->data_field")) <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif</div>
            </div>
        @endif
    <!-- gruppa yedinichnim viborom uchun -->
        @if($value->type == CategoriesDynprops::TYPE8)
            @php
                $ftype8 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype8 = old("f$value->data_field");
            @endphp
            <div id="items-f{{ $value->data_field }}" role="radiogroup" style="display: flow-root;">
                @php $variants = $value->getVariants('DESC'); @endphp
                @if($value->group_one_row_type8 == 0)
                    @foreach($variants as $key => $variant)
                        @if($variant->value == 0) @continue @endif
                        <label class="radio">
                            <input type="radio" name="items-f{{ $value->data_field }}"
                                   onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                   value="{{ $variant->value }}" {{ $ftype8 == $variant->value ? 'checked' : '' }}>
                            <span>{{ $variant->name }}</span>
                        </label>
                    @endforeach
                @else
                    @foreach ($variants as $key => $variant)
                        @if($variant->value == 0) @continue @endif
                        <label class="radio-inline">
                            <input type="radio" name="items-f{{ $value->data_field }}"
                                   {{ $ftype8 == $variant->value ? 'checked' : '' }} onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                   value="{{ $variant->value }}"> <span>{{ $variant->name }}</span>
                        </label>
                    @endforeach
                @endif
                <div class="help-block">@if ($errors->has("f$value->data_field"))
                        <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
                </div>
            </div>
        @endif
    <!-- gruppa mnogim viborom uchun -->
        @if($value->type == CategoriesDynprops::TYPE9)
            @php
                $ftype9 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype9 = old("f$value->data_field");
            @endphp
            <div id="items-f{{ $value->data_field }}" role="checkboxgroup" style="display: flow-root;">
                @php $variants = $value->getVariants('DESC'); $k = 1;  $check = ''; @endphp
                @if($value->group_one_row_type9 == 0)
                    <div class="checkleft">
                        @foreach ($variants as $key => $variant)
                            @php
                                if($ftype9 >= $variant->value){
                                    $ftype9 -= $variant->value;
                                    $check = "checked";
                                }else{
                                    $check = "";
                                }
                            @endphp
                            <label class="checkbox">
                                <input type="checkbox" data-id="items-f{{ $value->data_field }}" data-type="type9"
                                       data-name="{{ $variant->name }}" onchange="setCheckvalue($(this))"
                                       value="{{ $variant->value }}" {{ $check}}><span> {{ $variant->name }} </span>
                            </label>
                            @if($k%3 == 0) </div>
                    <div class="checkleft"> @endif
                        @php $k++; @endphp
                        @endforeach
                    </div>
                @else
                    @foreach ($variants as $key => $variant)
                        @php
                            if($ftype9 >= $variant->value){
                                $ftype9 -= $variant->value;
                                $check = "checked";
                            }else{
                                $check = "";
                            }
                        @endphp
                        <div class="checkleft">
                            @foreach ($variants as $key => $variant)
                                @php
                                    if($ftype9 >= $variant->value){
                                        $ftype9 -= $variant->value;
                                        $check = "checked";
                                    }else{
                                        $check = "";
                                    }
                                @endphp
                                <label class="checkbox">
                                    <input type="checkbox" data-id="items-f{{ $value->data_field }}" data-type="type9"
                                           data-name="{{ $variant->name }}" onchange="setCheckvalue($(this))"
                                           value="{{ $variant->value }}" {{ $check}}><span> {{ $variant->name }} </span>
                                </label>
                                @if($k%3 == 0) </div>
                        <div class="checkleft"> @endif
                            @php $k++; @endphp
                            @endforeach
                        </div>
                    @endforeach
                @endif
                <div class="help-block">@if ($errors->has("f$value->data_field"))
                        <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
                </div>
            </div>
        @endif

    <!-- vipadayushiy spisok uchun -->
        @if($value->type == CategoriesDynprops::TYPE10)
            @php
                $ftype10 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype10 = old("f$value->data_field");
            @endphp
            <div class="input-group">
                <input type="text" id="items-f{{ $value->data_field }}"
                       class="form-control float_number_input @error("f$value->data_field") is-invalid @enderror"
                       onchange="validated($(this));" value="{{ $ftype10 }}">
                @if($value->description)
                    <div class="input-group-append">
                        <span class="input-group-text">{!! $value->description !!}</span>
                    </div>
                @endif
                <div class="help-block">@if ($errors->has("f$value->data_field"))
                        <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
                </div>
            </div>
        @endif

    <!-- vipadayushiy spisok uchun -->
        @if ($value->type == CategoriesDynprops::TYPE11)
            @php
                $arr = unserialize($value->extra);
                $start = 0;
                $end = 0;
                if($arr['start'] > $arr['end']){
                    $start = $arr['end'];
                    $end = $arr['start'];
                }else{
                    $start = $arr['start'];
                    $end = $arr['end'];
                }
                $step = $arr['step'];
                $ftype11 = $model->{"f$value->data_field"};
                if(old("f$value->data_field") != null) $ftype11 = old("f$value->data_field");
            @endphp
            <div>
                <select id="items-f{{ $value->data_field }}" onchange="validated($(this));"
                        class="form-control js-select2" aria-invalid="false">
                    <option disabled selected>{{ trans("messages.Select") }}</option>
                    @for($i = (int)$start; $i <= (int)$end; $i+=(int)$step)
                        <option value="{{ $i }}" {{ $ftype11 == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="help-block">@if ($errors->has("f$value->data_field"))
                    <strong>{{ str_replace("f$value->data_field", $value->title, $errors->first("f$value->data_field")) }}</strong> @endif
            </div>
        @endif
    </div>
@endforeach

@if ($category)
    <!-- Sena uchun -->
    @php
        $price = $model->price;
        $price_end = $model->price_end;
        $price_ex = $model->price_ex;
        $currency_id = $model->currency_id;
        if(old("price") != null) $price = old("price");
        if(old("price_end") != null) $price_end = old("price_end");
        if(old('price_ex') != null) $price_ex = old("price_ex");
        if(old('currency_id') != null) $currency_id = old("currency_id");
    @endphp
    @if($category->price == 1)
        <div class="form-group">
            <label>{{ isset($category->price_title['ru']) && $category->price_title['ru'] != '' ?$category->price_title['ru'] : trans('messages.Price') }}</label>
            <input type="hidden" name="" id="items-price_ex" value="{{ $price_ex }}">
            @if($category->is_exchange == 1)
                <div style="height: 30px;">
                    <input type="radio" {{ $price_ex == 2 ? 'checked':'' }}  id="radio-price-2"
                           data-type="category-price" onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())" name="radio1"
                           onchange="" value="2">
                    <label for="radio-price-2">
                        <span style="font-size:13px;">{{ trans('messages.Exchange') }}</span>
                    </label>
                </div>
            @endif
            @if($category->is_free == 1)
                <div style="height: 30px;">
                    <input type="radio" {{ $price_ex == 4 ? 'checked':'' }}  id="radio-price-4"
                           data-type="category-price" onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())"
                           name="radio1" onchange="" value="4">
                    <label for="radio-price-4">
                        <span style="font-size:13px;">{{ trans('messages.Free') }}</span>
                    </label>
                </div>
            @endif
            @if($category->is_deal == 1)
                <div style="height: 30px;">
                    <input type="radio" id="radio-price-8"
                           {{ $price_ex == 8 ? 'checked':'' }} data-type="category-price"
                           onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())" name="radio1" onchange="" value="8">
                    <label for="radio-price-8">
                        <span  style="font-size:13px;">{{ trans('messages.Negotiated') }}</span>
                    </label>
                </div>
            @endif
            <div class="">
                @php $display = $category->is_deal == 1 || $category->is_free == 1 || $category->is_exchange == 1; @endphp
                @if($display)
                    <input type="radio" id="radio-price-0"
                           {{ $price_ex == 0 || $price_ex == 1? 'checked':'' }} data-type="category-price" name="radio1"
                           onclick="val = parseInt($('#items-price_ex').val()); if(value%2 === 1){
                               $('#items-price_ex').val(1);
                           }else{$('#items-price_ex').val(0);} onPrice($(this).val())" onchange="" value="0">
                    <label for="radio-price-0" style="margin-right: 10px;">
                        <span  style="font-size:13px;">{{ trans('messages.Price') }}</span>
                    </label>
                @endif
                <div class="form-group price_content" style="display: {{ $price_ex > 1  ? 'none': 'flex' }}">
                    <input type="text" id="items-price" class="form-control"
                           onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                           style="width: 40%; margin-right: 5px" value="{{ $price }}"
                           placeholder="{{ $category->price_diapazone ? trans('messages.from') : ''}}">
                    @if ($category->price_diapazone)
                        <input type="text" id="items-price_end" class="form-control"
                               onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                               style="width: 40%; margin-right: 5px" placeholder="{{ trans('messages.to') }}"
                        value="{{ $price_end }}">
                    @endif
                    <select onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())" id="items-currency_id"
                            class="js-select2" style="width: 30%; margin-right: 5px; margin-left: 5px">
                        @foreach ($currenies as $key => $value)
                            <option
                                value="{{ $key }}" {{ $currency_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @if($category->mod_check == 1)
                        <label style="width: 30%; margin-left: 15px; margin-top: 15px;">
                            <input type="checkbox" id="price-ex-checkbox"
                                   onchange="if($(this).prop('checked')){value = parseInt($('#items-price_ex').val()) + 1;}else{value = parseInt($('#items-price_ex').val()) - 1;}$('#items-price_ex').val(value);"
                                   {{ $price_ex == 1 ? 'checked' : '' }} value="1">
                            <span
                                style="font-size:13px;">{{ ($category->mod_title['ru'] == '') ? trans("messages.Price negotiating is possible") : $category->mod_title['ru'] }}</span>
                        </label>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif
@if($category)
    <!-- adress uchun -->
    @if($category->address)
        @php
            $address = $model->address;
            $coordinate_x = $model->coordinate_x;
            $coordinate_y = $model->coordinate_y;
            if(old('address') != null) $address = old("address");
            $coordinate_y = $model->coordinate_y;
            if(old('coordinate_y') != null) $coordinate_y = old("coordinate_y");
            $coordinate_y = $model->coordinate_y;
            if(old('coordinate_y') != null) $coordinate_y = old("coordinate_y");
        @endphp
        <div class="form-group">
            <label for="shops-address">{{ trans('messages.Address') }}</label>
            <div class="input-group">
                <input type="text" class="form-control" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                       id="items-address" placeholder="{{ trans('messages.Enter address')}}" value="{{ $address }}">
            </div>
            <input type="hidden" id="items-coordinate_x" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                   value="{{ $coordinate_x }}">
            <input type="hidden" id="items-coordinate_y" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                   value="{{ $coordinate_y }}">
            <div id="map" style="height: 350px;width: 100%;margin-top:10px;position: relative;"></div>
            <div id="marker"></div>
        </div>
    @endif
@endif

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/items.js') }}?10"></script>
<script src="{{ asset('js/inputFilter.js') }}"></script>
@if ($category && $category->address)
    @include('items.script.ymap')
@endif
@include('items.script.add_js')

