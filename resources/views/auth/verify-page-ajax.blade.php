<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden;">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <form method="POST" id="confirmForm" class="registr niked">
                    {{ csrf_field() }}
                    <h1>{{ trans('messages.SMS configuration') }}</h1>
                    <strong class="text-danger">{{ trans('messages.Confirm your phone number') }}</strong>
                    <p>{!! $text !!}</p>
                    <div class="form-group">
                        @if ($phone)
                            <input type="hidden" name="phone" value="not_new_phone_number">
                        @else
                        <input type="tel" name="phone" class="form-control tel_uz" required value="" placeholder="{{ trans('messages.Phone number') }}" placeholder="+998xx-xx-xx-xx">
                        @endif
                        <span class="help-block">
                            <strong id="phone-error"></strong>
                        </span>
                    </div>
                    <button type="submit" id="sendCode" class="more_know blue" >
                        {{ trans('messages.Send') }}
                    </button>
                </form>
        </div>
    </div>
</div>
<script>
    $('.tel_uz').mask("+998nn-nnn-nn-nn");
</script>
