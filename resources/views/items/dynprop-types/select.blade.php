@php
    // ishlatilishi nomalum
    $type = 6;
    $div_id = $dynprop['id'] . '_' . $dynprop['category_id'];
    $from = 'd_' . $type;
    $checkbox = 'not_important_checkbox_' . $div_id;
    //dd($dynprop);
    $multi = $dynprop['categoriesDynpropsMultiDatas'];
@endphp
<div class="filter-element">
    <span>
        <span class="filter-title-text">
            {{ $dynprop['title'] }} 
            @if($dynprop['description'] != '')
                ({!! $dynprop['description'] !!})
            @endif
        </span>
        <div id="{{ $div_id }}">{{ $post['d_6_text'] }}</div>
    </span>
    <div class="filter-element-popup">
        <div class="form-group">
            <select name="{{ $from }}" id="{{ $from }}" class="select22" data-placeholder="{{ $dynprop['title'] }}" onchange="getSelectText('#{{ $from }}', '{{ $div_id }}')" >
                <option value=""></option>
                @for($i = count($multi) - 1; $i > 0; $i--)
                    <option value="{{ $multi[$i]['value'] }}">{{ $multi[$i]['name'] }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>