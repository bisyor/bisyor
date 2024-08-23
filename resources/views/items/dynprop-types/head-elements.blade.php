<div class="sorted_recket filter_rubrica">
    <div class="agre_rocket">
        <!-- <div class="agree_ser">
            <input type="checkbox" id="bt1" style="display: none;">
            <label for="bt1">Искать в тексте объявлений</label>
        </div> -->
        <div class="agree_ser">
            <input type="checkbox" id="only_photo" {{ $post['only_photo'] == 1 ? 'checked=""' : "" }} name="only_photo" value="1" style="display: none;">
            <label for="only_photo">{{ trans('messages.Only with photo') }}</label>
        </div>
        @if($currentCategory['owner_search'])
            <div class="agree_ser">
                <input type="checkbox" id="owner_private_search" {{ $post['owner_private_search'] == 1 ? 'checked=""' : "" }} name="owner_private_search" value="1" style="display: none;">
                <label for="owner_private_search">{{ $currentCategory['owner_private_search'] }}</label>
            </div>
        @endif
        @if($currentCategory['owner_search_business'])
            <div class="agree_ser">
                <input type="checkbox" id="owner_business_search" {{ $post['owner_business_search'] == 1 ? 'checked=""' : "" }} name="owner_business_search" value="1" style="display: none;">
                <label for="owner_business_search">{{ $currentCategory['owner_business_search'] }}</label>
            </div>
        @endif
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
