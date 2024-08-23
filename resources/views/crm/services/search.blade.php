<form action="{{ route('services.index', $shop->keyword) }}">
    <td></td>
    <td>
        <div class="form-group">
            <input type="text" name="name" value="{{ request('name') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="number" name="price" value="{{ request('price') }}" class="form-control">
        </div>
    </td>
    <td class="d-flex">
        <button type="submit" class="btn btn-primary mr-1">
            <i class="fa fa-search"></i>
        </button>
        <a href="{{ route('services.index', $shop->keyword) }}" class="btn btn-warning">
            <i class="fa fa-eraser"></i>
        </a>
    </td>
</form>
