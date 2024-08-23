<script src="{{ asset('js/inputFilter.js') }}"></script>
@php
    use App\Models\Items\CategoriesDynprops;
@endphp
<input type="hidden" name="" id="max-count-images"
       value="{{ (isset($category) && isset($category->photos)) ? $category->photos : 5 }}">
<input type="hidden" name="for_req" hidden value='{!! json_encode($fields) !!}'>
@if($category)
    <!-- tip obyevleniya uchun -->
    @if ($category->seek == 1)
        <div class="form-group field-items-cat_type star-input">
            <label class="control-label" for="items-cat_type">{{ trans('messages.Type items') }} </label>
            <select id="items-cat_type" class="form-control js-select2 hide-search"
                    data-minimum-results-for-search="Infinity" aria-invalid="false"
                    onchange="$('#hidden-'+$(this).attr('id')).val($(this).val()); $(this).next().next('.help-block').html('')">
                <option value="" disabled selected>{{ trans("messages.Select") }}</option>
                <option
                    value="1">{{ ($category->type_offer_form != '') ? $category->type_offer_form : trans('messages.Offer') }}</option>
                <option
                    value="2">{{ ($category->type_seek_form != '') ? $category->type_seek_form : trans('messages.Seek') }}</option>
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
            <div class="form-group">
                <input type="text" id="items-f{{ $value->data_field }}" class="form-control"
                       onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));">
                @if($value->description)
                    <span class="input-group-addon">{{ $value->description }}</span>
                @endif
            </div>
            <div class="help-block"></div>
        @endif
    <!-- textarea uchun -->
        @if($value->type == CategoriesDynprops::TYPE2)
            <div class="form-group">
                <textarea id="items-f{{ $value->data_field }}" onchange="validated($(this));" class="form-control"
                          rows="8" aria-invalid="false"></textarea>
                <div class="help-block"></div>
            </div>
        @endif
    <!-- vibor da/net uchun -->
        @if($value->type == CategoriesDynprops::TYPE4)
            <div id="items-f{{ $value->data_field }}" role="radiogroup">
                <label for="items-f{{ $value->data_field }}"><input type="radio" name="items-f{{ $value->data_field }}"
                                                                    onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                                                    value="1"> Да</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="items-f{{ $value->data_field }}"><input type="radio" name="items-f{{ $value->data_field }}"
                                                                    onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                                                    value="0"> Нет</label>
                <div class="help-block"></div>
            </div>
        @endif
    <!-- vibor flag uchun -->
        @if($value->type == CategoriesDynprops::TYPE5)
            <div class="form-group field-items-f{{ $value->data_field }}>">
                <label class="checkbox">
                    <input type="checkbox" id="items-f{{ $value->data_field }}" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));" class="form-control">
                </label>
                <div class="help-block"></div>
            </div>
        @endif
    <!-- vipadayushiy spisok uchun -->
        @if($value->type == CategoriesDynprops::TYPE6)
            <div class="form-group">
                <select id="items-f{{ $value->data_field }}" class="form-control js-select2" aria-invalid="false" onchange="validated($(this));">
                    @php $variants = $value->getVariants(); @endphp
                    <option disabled selected>{{ trans("messages.Select") }}</option>
                    @foreach ($variants as $key => $variant)
                        <option value="{{ $variant->value }}">{{ $variant->name }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>
        @endif
    <!-- gruppa yedinichnim viborom uchun -->
        @if($value->type == CategoriesDynprops::TYPE8)
            <div id="items-f{{ $value->data_field }}" role="radiogroup" style="display: flow-root;">
                @php $variants = $value->getVariants('DESC'); @endphp
                @if($value->group_one_row_type8 == 0)
                    @foreach($variants as $key => $variant)
                        @if($variant->value == 0) @continue @endif
                        <label class="radio">
                            <input type="radio" name="items-f{{ $value->data_field }}"
                                   onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                   value="{{ $variant->value }}"> <span>{{ $variant->name }}</span>
                        </label>
                    @endforeach
                @else
                    @foreach ($variants as $key => $variant)
                        @if($variant->value == 0) @continue @endif
                        <label class="radio-inline">
                            <input type="radio" name="items-f{{ $value->data_field }}"
                                   onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())"
                                   value="{{ $variant->value }}"> <span>{{ $variant->name }}</span>
                        </label>
                    @endforeach
                @endif
                <div class="help-block"></div>
            </div>
        @endif
    <!-- gruppa mnogim viborom uchun -->
        @if($value->type == CategoriesDynprops::TYPE9)
            <div id="items-f{{ $value->data_field }}" role="checkboxgroup" style="display: flow-root;">
                @php $variants = $value->getVariants("DESC"); $k = 1; @endphp
                @if($value->group_one_row_type9 == 0)
                    <div class="checkleft">
                        @foreach ($variants as $key => $variant)
                            <label class="checkbox">
                                <input type="checkbox" data-id="items-f{{ $value->data_field }}" data-type="type9"
                                       data-name="{{ $variant->name }}" onchange="setCheckvalue($(this))"
                                       value="{{ $variant->value }}"><span> {{ $variant->name }} </span>
                            </label>
                            @if($k%3 == 0) </div>
                    <div class="checkleft"> @endif
                        @php $k++; @endphp
                        @endforeach
                    </div>
                @else
                    <div class="checkleft">
                        @foreach ($variants as $key => $variant)
                            <label class="checkbox">
                                <input type="checkbox" data-id="items-f{{ $value->data_field }}" data-type="type9"
                                       data-name="{{ $variant->name }}" onchange="setCheckvalue($(this))"
                                       value="{{ $variant->value }}"><span> {{ $variant->name }} </span>
                            </label>
                            @if($k%3 == 0) </div>
                    <div class="checkleft"> @endif
                        @php $k++; @endphp
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="help-block"></div>
        @endif

    <!-- vipadayushiy spisok uchun -->
        @if($value->type == CategoriesDynprops::TYPE10)
            <div class="input-group">
                <input type="text" id="items-f{{ $value->data_field }}" class="form-control float_number_input"
                       onchange="validated($(this));">
                @if($value->description)
                    <div class="input-group-append">
                        <span class="input-group-text">{!! $value->description !!}</span>
                    </div>
                @endif
            </div>
            <div class="help-block"></div>
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
            @endphp
            <div>
                <select id="items-f{{ $value->data_field }}" onchange="validated($(this));"
                        class="form-control js-select2" aria-invalid="false">
                    <option disabled selected>{{ trans("messages.Select") }}</option>
                    @for($i = (int)$start; $i <= (int)$end; $i+=(int)$step)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="help-block"></div>
        @endif
    </div>
@endforeach

@if ($category)
    <!-- Sena uchun -->
    @if($category->price == 1)
        <div class="form-group">
            <label>{{ isset($category->price_title['ru']) && $category->price_title['ru'] != '' ?$category->price_title['ru'] : 'Цена' }}</label>
            <input type="hidden" name="" id="items-price_ex" value="0">
            @if($category->is_exchange == 1)
                <div style="height: 30px;">
                    <input type="radio" id="radio-price-2" data-type="category-price"
                           onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())"
                           name="radio1" onchange="" value="2">
                    <label for="radio-price-2">
                        <span  style="font-size:13px;">{{ trans('messages.Exchange') }}</span>
                    </label>
                </div>
            @endif
            @if($category->is_free == 1)
                <div style="height: 30px;">
                    <input type="radio" id="radio-price-4" data-type="category-price"
                           onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())"
                           name="radio1" onchange="" value="4">
                    <label for="radio-price-4">
                        <span style="font-size:13px;">{{ trans('messages.Free') }}</span>
                    </label>
                </div>
            @endif
            @if($category->is_deal == 1)
                <div style="height: 30px;">
                    <input type="radio" id="radio-price-8" data-type="category-price"
                           onclick="$('#items-price_ex').val($(this).val()); onPrice($(this).val())"
                           name="radio1" onchange="" value="8">
                    <label for="radio-price-8">
                        <span style="font-size:13px;">{{ trans('messages.Negotiated') }}</span>
                    </label>
                </div>
            @endif
            <div>
                @php $display = $category->is_deal == 1 || $category->is_free == 1 || $category->is_exchange == 1; @endphp
                @if($display)
                    <input type="radio" id="radio-price-0" data-type="category-price" name="radio1"
                           onclick="val = parseInt($('#items-price_ex').val()); if(value%2 == 1){$('#items-price_ex').val(1);}else{$('#items-price_ex').val(0);} onPrice($(this).val())" onchange="" value="0" checked>
                    <label for="radio-price-0" style="margin-right: 10px;">
                        <span style="font-size:13px;">{{ trans('messages.Price') }}</span>
                    </label>
                @endif
                <div class="form-group price_content" style="display: flex">
                    <input type="" id="items-price" class="form-control"
                           onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                           style="width: 40%; margin-right: 5px"
                           placeholder="{{ $category->price_diapazone ? trans('messages.from') : ''}}">
                    @if ($category->price_diapazone)
                        <input type="" id="items-price_end" class="form-control"
                               onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())"
                               style="width: 40%; margin-right: 5px" placeholder="{{ trans('messages.to') }}">
                    @endif
                    <select onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())" id="items-currency_id" class="js-select2" style="width: 30%; margin-right: 5px; margin-left: 5px">
                        @foreach ($currenies as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @if($category->mod_check == 1)
                        <label style="width: 30%; margin-left: 15px; margin-top: 15px;">
                            <input type="checkbox" id="price-ex-checkbox"
                                   onchange="if($(this).prop('checked')){value = parseInt($('#items-price_ex').val()) + 1;}else{value = parseInt($('#items-price_ex').val()) - 1;}$('#items-price_ex').val(value);" value="1">
                            <span style="font-size:13px;">{{ ($category->mod_title['ru'] == '') ? trans("messages.Price negotiating is possible") : $category->mod_title['ru'] }}</span>
                        </label>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- adress uchun -->
    @if($category->address)
        <div class="form-group">
            <label for="shops-address">{{ trans('messages.The exact address') }}</label>
            <div class="input-group">
                <input type="text" class="form-control" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())" id="items-address" placeholder="{{ trans('messages.Enter address') }}">
            </div>
            <input type="hidden" id="items-coordinate_x" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
            <input type="hidden" id="items-coordinate_y" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
            <div id="map" style="height: 350px;width: 100%;margin-top:10px;position: relative;"></div>
            <div id="marker"></div>
        </div>
    @endif
@endif
@if ($category && $category->address)
    @include('items.script.ymap ')
@endif

@include('items.script.add_js')

