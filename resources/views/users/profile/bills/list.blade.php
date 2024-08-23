@extends('layouts.app')
@section('title'){{ trans('messages.Score') }} @endsection
@section('content')

 <section class="cabinet">
    <div class="container">
	    <nav aria-label="breadcrumb" class="my_nav">
	        <ol class="breadcrumb">
	        	<li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Score') }}</li>
	        </ol>
	    </nav>
    	<div class="row pb-3">
    	  	@include('users.left_sidebar', ['user' => $user])
    	  	<div class="col-xl-9 col-md-8 ">
    	    	<div class="score_main">
	    	      	<div class="score_main_top">
	    	        	<a class="insco">{{ trans('messages.Operations history') }}</a>
	    	        	<div>
	    	        		<p>{{ trans('messages.In your account') }}: <b>{{ $user->getUserBalance() }}</b></p>
	    	        		<a href="{{ route('bills-replenish') }}" class="more_know blue">{{ trans('messages.Replenish account') }}</a>
	    	      		</div>
	    	      	</div>
	    	      	@if(count($bills) > 0)
			            <table class="table">
			            	<thead>
			                	<tr>
			                  		<th>№</th>
			                  		<th width="15%">{{ trans('messages.Date') }}</th>
			                  		<th>{{ trans('messages.Description') }}</th>
			                  		<th width="10%">{{ trans('messages.Amount') }}</th>
			                  		<th>{{ trans('messages.Status') }}</th>
			                  		<th width="15%">{{ trans('messages.Type') }}</th>
			                	</tr>
			              	</thead>
			              	<tbody>
			              		@foreach($bills as $bill)
                                    <tr {{--class="{{ $bill['trClass'] }}"--}}>
                                        <td>{{ $bill['id'] }}</td>
                                        <td>{{ $bill['date_pay'] }}</td>
                                        <td>{!! $bill['description'] !!}</td>
                                        <td>{{ $bill['amount'] }}</td>
                                        <td>{{ $bill['statusDesc'] }}</td>
                                        <td>{{ $bill['typeDesc'] }}</td>
                                    </tr>
			                	@endforeach
			              	</tbody>
			            </table>
                        <div class="ml-3">
                            {{ $bills->links() }}
                        </div>
			            	@else
				            <table class="score table">
				              	<thead>
				                	<tr>
				                  		<th>№</th>
				                  		<th>{{ trans('messages.Date') }}</th>
				                  		<th>{{ trans('messages.Description') }}</th>
				                  		<th>{{ trans('messages.Amount') }}</th>
				                  		<th>{{ trans('messages.Status') }}</th>
				                  		<th>{{ trans('messages.Type') }}</th>
				                	</tr>
				              	</thead>
				            </table>
				            <div class="free_score">
				              	<img src="/images/free_score.png" alt="No datas">
				              	<p>{{ trans('messages.No datas') }}</p>
				            </div>
	    	      	@endif
	    	    </div>
    	 	</div>
    	</div>
    </div>
</section>
@endsection
