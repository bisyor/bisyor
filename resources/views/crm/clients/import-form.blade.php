<div id="import_form" class="close_black popup_moto" style="display: none; max-width: 500px">
    <p class="text-center border-0">@lang('messages.Fill in the customer base via Excel')</p>
    <div class="text-center">
        <p>@lang('messages.Click the download button below to download the Excel spreadsheet sample')</p>
    </div>
    <div>
        <img src="images/openiun.png" alt="">
        <span class="blue_text">@lang('messages.Example'): </span>
        <a href="{{ route('clients.example-import', $shop->keyword) }}"
           class="btn btn-warning mr-1">{{ trans('messages.Download') }}</a>
    </div>
    <form action="{{ route('clients.import', ['keyword' => $shop->keyword]) }}"
          class="popup_moto_form" id="form_op" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" name="file">
        </div>
        <button type="submit" class="more_know blue">@lang('messages.Upload')</button>
    </form>
</div>
