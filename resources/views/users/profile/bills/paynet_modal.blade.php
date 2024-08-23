<div id="show_paynet_code" class="close_black popup_moto" style="display: none; max-width: 500px">
    <div class="than text-center">
        <img src="{{ asset('images/paynet_big.jpg') }}" alt="Paynet">
        <h3>@lang('messages.Your paynet code')</h3>
    </div>
    <div class="text-center">
        <p>@lang('messages.You can top up your Bisyor account from paynet outlets. You need to show your ID number and payment amount!')</p>
    </div>
    <div class="number_phone_popups flex-column border-0">
        <p class="text-secondary">@lang('messages.Your id')</p>
        <a href="javascript:void(0);" class="to_numb">{{ $user->id }}</a>
    </div>
    <div class="text-center ">
        <p>@lang('messages.Paynet services center')</p>
    </div>
</div>
