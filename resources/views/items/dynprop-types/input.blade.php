@php
    $div_id = $dynprop['id'] . '_' . $dynprop['category_id'];
    $checkbox = 'not_important_checkbox_' . $div_id;
    $from = 'd[' . $dynprop['data_field'] . '][f]';
    $text = trans('messages.Not important');

    if(isset($post['d'][$dynprop['data_field']]['f'])) {
        $fromText = $post['d'][$dynprop['data_field']]['f'];
        $text = $fromText;
    }
    else $fromText = '';

@endphp
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
            <div class="col-12">
                <div class="form-group filter-input">
                    <input type="text" class="form-control" placeholder="{{ trans('messages.Write') }}" name="{{ $from }}" value="{{ $fromText }}" onchange="changeDiapazoneParams('{{ $div_id }}', '{{ $from }}' )">
                </div>
            </div>
            <div class="col-12" style="margin-top: 15px;">
                <div class="filter-checkbox">
                    <input type="checkbox" {{ $text == trans('messages.Not important') ? 'checked=""' : '' }} id="{{ $checkbox }}" onclick="notImportantCheckbox('{{ $div_id }}', '{{ $checkbox }}', '{{ $from }}')">
                    <label class="form-check-label" for="{{ $checkbox }}">{{ trans('messages.Not important') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>