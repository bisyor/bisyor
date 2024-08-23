@php
    $div_id = 'price';
    $from = 'price_f';
    $to = 'price_t';
    $checkbox = 'not_important_checkbox_' . $div_id;
    $price_c = 'price_c';
@endphp
<div class="filter-element">
    <span>
        <span class="filter-title-text">
            {{ trans('messages.Price') }}
        </span>
        <div id="{{ $div_id }}">{{ $post['price_text'] }}</div>
    </span>
    <div class="filter-element-popup">
        <div class="row">
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.from') }}" name="{{ $from }}" value="{{ $post[$from] }}" onchange="changeRangeParams('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $price_c }}' )">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group filter-input">
                    <input type="number" class="form-control" placeholder="{{ trans('messages.to') }}" name="{{ $to }}" value="{{ $post[$to] }}" onchange="changeRangeParams('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $price_c }}' )">
                </div>
            </div>
            <div class="col-12" style="margin-top: 15px;">
                <div class="form-group filter-select">
                    <select class="form-control" name="{{ $price_c }}" onchange="changeRangeParams('{{ $div_id }}', '{{ $from }}', '{{ $to }}', '{{ $price_c }}' )">
                        @foreach($currencies as $cur)
                            <option value="{{ $cur['id'] }}" {{ $post[$price_c] == $cur['id'] ? 'selected' : '' }} >
                                {{ $cur['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12" style="margin-top: 15px;">
                <div class="form-group filter-checkbox">
                    <input type="checkbox" class="form-control" {{ $post['price_text'] == trans('messages.Not important') ? 'checked=""' : '' }} id="{{ $checkbox }}" onclick="notImportantCheckbox('{{ $div_id }}', '{{ $checkbox }}', '{{ $from }}', '{{ $to }}')">
                    <label class="form-check-label" for="{{ $checkbox }}">{{ trans('messages.Not important') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
