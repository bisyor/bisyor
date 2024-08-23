@php
    $div_id = $dynprop['id'] . '_' . $dynprop['category_id'];
    $checkbox = 'not_important_checkbox_' . $div_id;
    
    $from = 'd[' . $dynprop['data_field'] . '][f]';
    $to = 'd[' . $dynprop['data_field'] . '][t]';

    $text = trans('messages.Not important');
    if(isset($post['d_' . $dynprop['data_field'] . '_text'])) $text = $post['d_' . $dynprop['data_field'] . '_text'];

    if(isset($post['d'][$dynprop['data_field']]['f'])) $fromText = $post['d'][$dynprop['data_field']]['f'];
    else $fromText = '';

    if(isset($post['d'][$dynprop['data_field']]['t'])) $toText = $post['d'][$dynprop['data_field']]['t'];
    else $toText = '';
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
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.from') }}" name="{{ $from }}" value="{{ $fromText }}" onchange="changeDiapazoneParams('{{ $div_id }}', '{{ $from }}', '{{ $to }}' )">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.to') }}" name="{{ $to }}" value="{{ $toText }}" onchange="changeDiapazoneParams('{{ $div_id }}', '{{ $from }}', '{{ $to }}' )">
                </div>
            </div>
            <div class="col-12" style="margin-top: 15px;">
                <div class="form-group filter-checkbox">
                    <input type="checkbox" class="form-control" {{ $text == trans('messages.Not important') ? 'checked=""' : '' }} id="{{ $checkbox }}" onclick="notImportantCheckbox('{{ $div_id }}', '{{ $checkbox }}', '{{ $from }}', '{{ $to }}')">
                    <label class="form-check-label" for="{{ $checkbox }}">{{ trans('messages.Not important') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>