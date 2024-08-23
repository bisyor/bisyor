@extends('layouts.app')
@section('title'){{ trans('messages.Score') }} @endsection
@section('content')


<section class="cabinet">
    <div class="container">
      	<nav aria-label="breadcrumb" class="my_nav">
        	<ol class="breadcrumb">
          		<li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Replenish account') }}</li>
        	</ol>
      	</nav>
      	<div class="row pb-3">
        	@include('users.left_sidebar', ['user' => $user])
	        <div class="col-xl-9 col-md-8">
	            <form class="op_marc score_main my_ind_e" action="{{ route('bills-payment') }}" method="post">
                    @csrf
	            	<a class="insco">{{ trans('messages.Replenish account') }}</a>
	              	<h3>{{ trans('messages.Select a Payment Method') }}</h3>
	              	<div class="radio_mag innermag">
	                	<input type="radio" name="payment_method" id="m1er" checked="" value="m1er">
	                	<label for="m1er"><img src="/images/payme.png" alt="payme"></label>
	                	<input type="radio" name="payment_method" id="m2sev" value="m2sev">
	                	<label for="m2sev"><img src="/images/click.png" alt="click"></label>
	                	<label for="" data-fancybox="" data-src="#show_paynet_code" data-options='{"touch" : false}'><img src="{{ asset('images/paynet.jpg') }}" alt="click"></label>
	              	</div>
	              	<h3>{{ trans('messages.Replenish sum') }}</h3>
	              	<div class="niked">
	                	<div class="form-group">
	                  		<label for="#">{{ trans('messages.Amount') }}</label>
                            <div class="much_fund">
                                <input name="amount" type="text" class="form-control" value="{{ old('amount') }}">
                                <button type="submit" name="type" class="more_know blue" value="pay">{{ trans('messages.Proceed') }}</button>
                            </div>
                            <div class="help-block mt-3"></div>
	                	</div>
                        <div class="form-group">
                            <label for="promo">{{ trans('messages.Promotional code') }}</label>
                            <div class="much_fund">
                                <input name="promo" type="text" class="form-control" value="{{ old('promo') }}">
                                <button type="submit" name="type" class="more_know" value="promo">{{ trans('messages.Proceed') }}</button>
                            </div>
                            <div class="help-block mt-3">@if($errors->has('promo')) <strong>{{ $errors->first('promo') }}</strong>@endif</div>
                        </div>
	              	</div>
	            </form>
	        </div>
      	</div>
    </div>
</section>
@include('users.profile.bills.paynet_modal')
@endsection
@section('extra-js')
    <script src="{{ asset('js/inputFilter.js') }}"></script>
    <script src="{{ asset('js/items.js') }}"></script>
    <script>
        $('input[name=amount]').inputFilter(function (value) {
            return /^[\d ]*$/.test(value);
        });
        $('input[name=amount]').on({
            keyup: function () {
                formatCurrency($(this));
            }
        });
        $('input[name=amount]').on('change', function(e){
            var amount = $(this).val().replace(/\s/g, '');

            if(amount < 1000){
                $(this).parent().next().html('<strong>{{ trans("messages.Minimal summa")}}</strong>');
            }
            if(amount > 10000000){
                $(this).parent().next().html('<strong>{{ trans("messages.Maximal summa")}}</strong>');
            }
        });
        $('form button').click(function(ev){
            var validate = true;
            var amount = $('input[name=amount]').val().replace(/\s/g, '');
            if($(this).val() == 'pay'){
                if(amount < 1000){
                    validate = false;
                    $('input[name=amount]').parent().next().html('<strong>{{ trans("messages.Minimal summa")}}</strong>');
                }
                if(amount > 10000000){
                    validate = false;
                    $('input[name=amount]').parent().next().html('<strong>{{ trans("messages.Maximal summa")}}</strong>');
                }
                const pm = $('input[name=payment_method]');
                var check = false;
                for(const p of pm){
                    if(p.checked){
                        check = true;
                        break;
                    }
                }
                if(!check){
                    validate = false;
                    $('.error').html('<div class="alert alert-danger">Payment method not selected!</div>');
                    $('.alert').fadeOut(3000, function(){
                        $(this).children().remove();
                    })
                }
            }else{
                if(!$('input[name=promo]').val()){
                    $('input[name=promo]').parent().next().html('<strong>{{ trans("messages.Text entry required")}}</strong>');
                    validate = false;
                }
            }
            if(validate) return e.preventDefault();
        });
    </script>
@endsection
