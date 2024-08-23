@php($cat = request()->input('category'))
<div class="bg-white border pl-3 pr-3 mb-4 rounded">
    <form action="" id="search_items" class="niked row align-items-center pt-3" method="get">
        <input type="hidden" name="a_t" value="{{ $active_tab }}">
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="{{ trans('messages.Title') }}"
                       value="{{ request()->input('title') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <select name="category" id="category" class="js-select2"
                        data-minimum-results-for-search="Infinity" data-width="250">
                    <option value="all" {{ $cat == 'all' | $cat == null ? 'selected':'' }}>{{ trans('messages.All categories') }}</option>

                    @foreach ($category_list as $category)
                        <option {{ $category['id']== $cat ? 'selected':'' }}
                                value="{{ $category['id'] }}">{{ $category['title'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <button class="more_know blue">{{ trans('messages.Search') }}</button>
            </div>
        </div>
    </form>
</div>
