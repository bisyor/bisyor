<form action="{{ route('clients.index', $shop->keyword) }}">
    <td></td>
    <td>
        <div class="form-group">
            <input type="text" name="company_name" value="{{ request('company_name') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" name="fio" value="{{ request('fio') }}" class="form-control">
        </div>
    </td>
    <td>
        <div class="form-group">
            <select name="type" class=" form-control">
                <option value disabled="" {{ !request('type') ? 'selected':'' }}>{{ trans('messages.Select') }}...
                </option>
                @foreach($client_types as $key => $client_type)
                    <option {{ $key != request('type') ?: 'selected' }} value="{{ $key }}">{{ $client_type }}</option>
                @endforeach
            </select>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" name="phone" value="{{ request('phone') }}" class="form-control">
        </div>
    </td>
    <td class="d-flex">
        <button type="submit" class="btn btn-primary mr-1">
            <i class="fa fa-search"></i>
        </button>
        <a href="{{ route('clients.index', $shop->keyword) }}" class="btn btn-warning">
            <i class="fa fa-eraser"></i>
        </a>
    </td>
</form>
