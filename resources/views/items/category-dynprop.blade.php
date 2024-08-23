<form action="{{ $actionFilterRoute }}" method="GET" class="filtered_recket niked" autocomplete="off">
    @include('items.dynprop-types.head-elements', ['currencies' => $currencies, 'post' => $post])
    <div class="filter-items">
        @include('items.dynprop-types.price', ['currencies' => $currencies, 'post' => $post])

        @foreach($dynpropSearch as $dynprop)

            @if($dynprop['type'] == 11)
                @include('items.dynprop-types.input-number-range', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 10)
                @include('items.dynprop-types.input-number-range-with-checkbox', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 9)
                @include('items.dynprop-types.input-checkboxes', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 8)
                @include('items.dynprop-types.input-checkboxes', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 6)
                @include('items.dynprop-types.input-checkboxes', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 5)
                @include('items.dynprop-types.input-checkboxes', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 4)
                @include('items.dynprop-types.input-checkboxes', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 2)
                @include('items.dynprop-types.input', ['dynprop' => $dynprop, 'post' => $post])
            @endif

            @if($dynprop['type'] == 1)
                @include('items.dynprop-types.input', ['dynprop' => $dynprop, 'post' => $post])
            @endif

        @endforeach
    </div>
    <div class="filter-button">
        <button type="submit" class="btn btn-success">{{ trans('messages.Search') }}</button>
    </div>
</form>
