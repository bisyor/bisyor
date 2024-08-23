<p><b>@foreach($category as $cat) {{ $cat." / " }} @endforeach :</b></p>
<div class="form-group">
    <label for="">{{ trans('messages.Item Limit') }}</label>
    <div class="sr_mag">
        <select name="limitbuy" class="js-select2" data-minimum-results-for-search="Infinity" onchange="$('.price-summa b').html($(this).find(':selected').data('price'))">
            @foreach($limitPack as $limit)
                <option value="{{ $limit['id'] }}" data-price="{{ $limit['price'] }}">{{ $limit['items']." ".trans('messages.Ads') }}</option>
            @endforeach
        </select>
        <div class="price-summa">
            <span>{{ trans('messages.Total payable') }}: <b>{{ $limitPack[1]['price'] }}</b> {{ trans('messages.sum') }}</span>
        </div>
    </div>
</div>
