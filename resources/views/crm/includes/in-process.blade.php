@extends('layouts.app')
@section('title'){{ trans('messages.Crm ') }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <div class="row pb-3">
                <div class="col-xl-12 col-md-12 c_cabinet">
                    <div class="free_score">
                        <img src="/images/free_score.png" alt="In Process">
                        <p>{{ trans('messages.In process') }}</p>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">@lang('messages.Back')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
