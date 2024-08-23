<form action="{{ route('site-search') }}" method="GET" class="filtered_recket niked" autocomplete="off">
    <input type="hidden" name="query" value="{{ $keyword }}">
    <div class="sorted_recket filter_rubrica">
        <div class="agre_rocket">
            <div class="agree_ser">
                <input type="checkbox" id="bt1" name="search_from_desc" {{ $post['search_from_desc'] == 1 ? 'checked=""' : "" }} value="1" style="display: none;">
                <label for="bt1">Искать в тексте объявлений</label>
            </div>
            <div class="agree_ser">
                <input type="checkbox" id="only_photo" {{ $post['only_photo'] == 1 ? 'checked=""' : "" }} name="only_photo" value="1" style="display: none;">
                <label for="only_photo">{{ trans('messages.Only with photo') }}</label>
            </div>
            <div class="sort">
                <input type="hidden" name="sorting" id="sorting" value="{{ $post['sorting'] }}">
                <span>{{ trans('messages.Sorting') }} : </span>
                <div class=" dropdown_popup">
                    <a href="#">
                        <span id="sorting-span">
                            @php
                                if($post['sorting'] == 'new') echo trans('messages.The newest');
                                if($post['sorting'] == 'price_asc') echo trans('messages.From cheap to expensive');
                                if($post['sorting'] == 'price_desc') echo trans('messages.From expensive to cheap');
                            @endphp
                        </span>
                    </a>
                    <div class="dropdown_popup_body">
                        <a data-text="{{ trans('messages.The newest') }}" data-value="new" onclick="changeSortStatus(this, 'sorting-span', 'sorting')">
                            <span>{{ trans('messages.The newest') }}</span>
                        </a>
                        <a data-text="{{ trans('messages.From cheap to expensive') }}" data-value="price_asc" onclick="changeSortStatus(this, 'sorting-span', 'sorting')">
                            <span>{{ trans('messages.From cheap to expensive') }}</span>
                        </a>
                        <a data-text="{{ trans('messages.From expensive to cheap') }}" data-value="price_desc" onclick="changeSortStatus(this, 'sorting-span', 'sorting')">
                            <span>{{ trans('messages.From expensive to cheap') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-items">
        @include('items.dynprop-types.price', ['currencies' => $currencies, 'post' => $post])
    </div>
    <div class="filter-button">
        <button type="submit" class="btn btn-success">{{ trans('messages.Search') }}</button>
    </div>
</form>