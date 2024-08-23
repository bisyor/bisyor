@php
    $extra = unserialize($dynprop['extra']);
    $div_id = $dynprop['id'] . '_' . $dynprop['category_id'];
    $checkbox = 'not_important_checkbox_' . $div_id;
    $checkboxesName = 'd[' . $dynprop['data_field'] . '][r]';
    
    $from = 'd[' . $dynprop['data_field'] . '][f]';
    $to = 'd[' . $dynprop['data_field'] . '][t]';

    $text = trans('messages.Not important');
    if(isset($post['d_' . $dynprop['data_field'] . '_text'])) $text = $post['d_' . $dynprop['data_field'] . '_text'];
    foreach($extra['search_ranges'] as $ranges)
    {
        $checkboxText = '';
        if($ranges['from'] != '' && $ranges['to'] != '') $checkboxText = $ranges['from'] . '...' . $ranges['to'];
        else {
            if($ranges['from'] == '') $checkboxText = '< ' .$ranges['to'];
            if($ranges['to'] == '') $checkboxText = '> ' . $ranges['from'];
        }
        if(isset($post['d'][$dynprop['data_field']]['r']) && in_array( $ranges['id'], $post['d'][$dynprop['data_field']]['r'] )) {
            if($text == trans('messages.Not important')) {
                $text = '';
                $text .= $checkboxText;
            }
            else $text .= ', ' . $checkboxText;
        }
    }

    if(isset($post['d'][$dynprop['data_field']]['f'])) $fromText = $post['d'][$dynprop['data_field']]['f'];
    else $fromText = '';

    if(isset($post['d'][$dynprop['data_field']]['t'])) $toText = $post['d'][$dynprop['data_field']]['t'];
    else $toText = '';
@endphp
<div class="filter-element">
    <span>
        <span class="filter-title-text">
            {{ $dynprop['title'] }} 
        </span>
        <div id="{{ $div_id }}">{{ $text }}</div>
    </span>
    <div class="filter-element-popup">
        <div class="row">
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.from') }}" name="{{ $from }}" value="{{ $fromText }}" onchange="inputWithCheckboxes('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $checkboxesName }}')">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.to') }}" name="{{ $to }}" value="{{ $toText }}" onchange="inputWithCheckboxes('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $checkboxesName }}')">
                </div>
            </div>
            <div class="col-12" style="margin-top: 15px;">
                @foreach($extra['search_ranges'] as $ranges)
                    @php
                        $checkboxText = '';
                        if($ranges['from'] != '' && $ranges['to'] != '') $checkboxText = $ranges['from'] . '...' . $ranges['to'];
                        else {
                            if($ranges['from'] == '') $checkboxText = '< ' .$ranges['to'];
                            if($ranges['to'] == '') $checkboxText = '> ' . $ranges['from'];
                        }
                        if(isset($post['d'][$dynprop['data_field']]['r']) && in_array( $ranges['id'], $post['d'][$dynprop['data_field']]['r'] )) {
                            $checked = 'checked=""';
                        }
                        else $checked = '';
                    @endphp
                    <div class="filter-checkbox">
                        <input type="checkbox" 
                            data-name="{{ $checkboxText }}" 
                            id="ranges_{{ $dynprop['id'] }}_{{ $ranges['id'] }}" 
                            name="{{ $checkboxesName }}[]" 
                            value="{{ $ranges['id'] }}" 
                            onclick="inputWithCheckboxes('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $checkboxesName }}')"
                            {{ $checked }}
                        >
                        <label for="ranges_{{ $dynprop['id'] }}_{{ $ranges['id'] }}">{{ $checkboxText }}</label>
                    </div>
                @endforeach
            </div>

            <div class="col-12" style="margin-top: 15px;">
                <div class="filter-checkbox">
                    <input type="checkbox" {{ $text == trans('messages.Not important') ? 'checked=""' : '' }} id="{{ $checkbox }}" onclick="notImportantCheckbox('{{ $div_id }}', '{{ $checkbox }}', '{{ $from }}', '{{ $to }}', '{{ $checkboxesName }}' )">
                    <label class="form-check-label" for="{{ $checkbox }}">{{ trans('messages.Not important') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>