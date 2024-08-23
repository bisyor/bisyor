<div id="show_phone_popup" class="close_black popup_moto" style="display: none; max-width: 500px">
    <p><span class="blue_text">«{{ $user->getUserFio() }}»</span></p>
    <div class="number_phone_popups">
        <a href="" class="to_numb"></a>
        <a href="javascript:void(0);" onclick="copyToClipboard()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="copy">
                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd" d="M4 14H5C5.55228 14 6 14.4477 6 15C6 15.5523 5.55228 16 5 16H4C2.34315 16 1 14.6569 1 13V4C1 2.34315 2.34315 1 4 1H13C14.6569 1 16 2.34315 16 4V5C16 5.55228 15.5523 6 15 6C14.4477 6 14 5.55228 14 5V4C14 3.44772 13.5523 3 13 3H4C3.44772 3 3 3.44772 3 4V13C3 13.5523 3.44772 14 4 14ZM11 8H20C21.6569 8 23 9.34315 23 11V20C23 21.6569 21.6569 23 20 23H11C9.34315 23 8 21.6569 8 20V11C8 9.34315 9.34315 8 11 8ZM11 10C10.4477 10 10 10.4477 10 11V20C10 20.5523 10.4477 21 11 21H20C20.5523 21 21 20.5523 21 20V11C21 10.4477 20.5523 10 20 10H11Z" fill="black" />
                    <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="1" y="1" width="22" height="22">
                        <path id="Combined Shape_2" fill-rule="evenodd" clip-rule="evenodd" d="M4 14H5C5.55228 14 6 14.4477 6 15C6 15.5523 5.55228 16 5 16H4C2.34315 16 1 14.6569 1 13V4C1 2.34315 2.34315 1 4 1H13C14.6569 1 16 2.34315 16 4V5C16 5.55228 15.5523 6 15 6C14.4477 6 14 5.55228 14 5V4C14 3.44772 13.5523 3 13 3H4C3.44772 3 3 3.44772 3 4V13C3 13.5523 3.44772 14 4 14ZM11 8H20C21.6569 8 23 9.34315 23 11V20C23 21.6569 21.6569 23 20 23H11C9.34315 23 8 21.6569 8 20V11C8 9.34315 9.34315 8 11 8ZM11 10C10.4477 10 10 10.4477 10 11V20C10 20.5523 10.4477 21 11 21H20C20.5523 21 21 20.5523 21 20V11C21 10.4477 20.5523 10 20 10H11Z" fill="white" />
                    </mask>
                    <g mask="url(#mask0)">
                        <g id="COLOR/ black">
                            <rect id="Rectangle" width="24" height="24" fill="black" fill-opacity="0" />
                        </g>
                    </g>
                </g>
            </svg>
        </a>
    </div>
    <div class="text-center">
        <p>@lang('messages.Remember you got the contact from Bisyor.')</p>
    </div>
    {{--<div class="openiun" id="open_openiun_block">
        <img src="{{ asset('images/openiun.png') }}" alt="Send form">
        <span class="blue_text">@lang('messages.What are your thoughts on developing a Bisyar project?')</span>
    </div>
    <form action="{{ route('contact-offer-store') }}" method="POST" class="popup_moto_form" id="form_op" style="display: none;">
        <div class="form-group">
            <textarea required name="message" placeholder="@lang('messages.Comment')"></textarea>
        </div>
        <button type="submit" class="more_know blue" --}}{{--data-fancybox data-src="#show_phone_popup_thanks"--}}{{-->@lang('messages.Send')</button>
    </form>--}}
</div>

<div id="show_phone_popup_thanks" class="close_black popup_moto" style="display: none; max-width: 500px">
    <p><span class="blue_text">««{{ $user->getUserFio() }}»»</span>・ @lang('messages.manager')</p>
    <div class="number_phone_popups">
        <a href="" class="to_numb"></a>
        <a href="javascript:void(0);" onclick="copyToClipboard()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="copy">
                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd" d="M4 14H5C5.55228 14 6 14.4477 6 15C6 15.5523 5.55228 16 5 16H4C2.34315 16 1 14.6569 1 13V4C1 2.34315 2.34315 1 4 1H13C14.6569 1 16 2.34315 16 4V5C16 5.55228 15.5523 6 15 6C14.4477 6 14 5.55228 14 5V4C14 3.44772 13.5523 3 13 3H4C3.44772 3 3 3.44772 3 4V13C3 13.5523 3.44772 14 4 14ZM11 8H20C21.6569 8 23 9.34315 23 11V20C23 21.6569 21.6569 23 20 23H11C9.34315 23 8 21.6569 8 20V11C8 9.34315 9.34315 8 11 8ZM11 10C10.4477 10 10 10.4477 10 11V20C10 20.5523 10.4477 21 11 21H20C20.5523 21 21 20.5523 21 20V11C21 10.4477 20.5523 10 20 10H11Z" fill="black" />
                    <g mask="url(#mask0)">
                        <g id="COLOR/ black">
                            <rect id="Rectangle" width="24" height="24" fill="black" fill-opacity="0" />
                        </g>
                    </g>
                </g>
            </svg>
        </a>
    </div>
    <div class="text-center">
        <p>@lang('messages.Remember you got the contact from Bisyor.')</p>
    </div>
    <div class="than text-center">
        <img src="{{ asset('images/thanks.png') }}" alt="Thanks">
        <h3>@lang('messages.Thank you for your feedback')</h3>
    </div>
</div>

<div id="applications_form_thanks" class="close_black popup_moto" style="display: none; max-width: 500px">
    <div class="number_phone_popups">
        <a href="" class="to_numb"></a>
    </div>
    <div class="than text-center">
        <img src="{{ asset('images/thanks.png') }}" alt="Thanks">
        <h3>Buyurtmangiz uchun rahmat! <br>Tez orada siz bilan bog'lanamiz :)</h3>
    </div>
</div>
