@php
    $notImportantStatus = 1;
    $div_id = $dynprop['id'] . '_' . $dynprop['category_id'];
    $from = 'd[' . $dynprop['data_field'] . ']';
    $checkbox = 'not_important_checkbox_' . $div_id;
    //dd($dynprop);
    $multi = $dynprop['categoriesDynpropsMultiDatas'];
    $text = trans('messages.Not important');
@endphp

@for($i = count($multi) - 1; $i > -1; $i--)
    @php
        if(isset($post['d'][$dynprop['data_field']]) && in_array( $multi[$i]['value'], $post['d'][$dynprop['data_field']] )) {
            if($text == trans('messages.Not important')) $text = $multi[$i]['name'];
            else $text .= ', ' . $multi[$i]['name'];
        }
    @endphp
@endfor 

<div class="filter-element">
    <span>
        <span class="filter-title-text">
            {{ $dynprop['title'] }} 
            @if($dynprop['description'] != '')
                ({!! $dynprop['description'] !!})
            @endif
        </span>
        <div id="{{ $div_id }}">{{ $text }}</div>
    </span>
    <div class="filter-element-popup">
        <div class="row">
            @for($i = count($multi) - 1; $i > -1; $i--)
                @php
                    if(isset($post['d'][$dynprop['data_field']]) && in_array( $multi[$i]['value'], $post['d'][$dynprop['data_field']] )) {
                        $checked = 'checked=""';
                        $notImportantStatus = 0;
                    }
                    else $checked = '';
                @endphp
                <div class="col-12">
                    <div class="filter-checkbox">
                        <input type="checkbox" 
                            data-name="{{ $multi[$i]['name'] }}" 
                            id="{{ $from }}[{{ $i }}]" 
                            name="{{ $from }}[]" 
                            value="{{ $multi[$i]['value'] }}" 
                            onclick="setCheckboxMultiple('{{ $div_id }}', '{{ $from }}')"
                            {{ $checked }}
                        >
                        <label for="{{ $from }}[{{ $i }}]">{{ $multi[$i]['name'] }}</label>
                    </div>
                </div>
            @endfor
            <div class="col-12" style="margin-top: 15px;">
                <div class="filter-checkbox">
                    <input type="checkbox" {{ $notImportantStatus ? 'checked=""' : '' }} id="{{ $checkbox }}" onclick="notImportantCheckbox('{{ $div_id }}', '{{ $checkbox }}', '{{ $from }}')">
                    <label for="{{ $checkbox }}">{{ trans('messages.Not important') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>