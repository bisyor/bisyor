<form action="{{ route('available.index', $shop->keyword) }}">
    <td></td>
    <td>
        <div class="form-group">
            <input type="text" name="product" value="{{ request('product') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="number" name="count" value="{{ request('count') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="number" name="price" value="{{ request('price') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <select name="type" class=" form-control">
                <option value disabled="" {{ !request('type') ? 'selected':'' }}>{{ trans('messages.Select') }}...
                </option>
                @foreach($type_parts as $key => $type)
                    <option {{ !$key == request('type') ?: 'selected' }} value="{{ $key }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td class="d-flex">
        <button type="submit" class="btn btn-primary mr-1">
            <i class="fa fa-search"></i>
        </button>
        <a href="{{ route('available.index', $shop->keyword) }}" class="btn btn-warning">
            <i class="fa fa-eraser"></i>
        </a>
    </td>
</form>
