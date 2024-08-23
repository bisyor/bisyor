@extends('layouts.app')
@section('title'){{ trans('messages.User bonus') }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Bonuses') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8 c_cabinet">
                    <ul class="nav tab_top_cabinet justify-content-between">
                        <li><a data-toggle="tab" class="active show" href="#bonus_lists">{{ trans('messages.Bonus lists') }}</a></li>
                        <li><a data-toggle="tab" class=""  href="#user_bonus_history">{{ trans('messages.Bonus history') }}</a></li>
                        <div class="d-flex">
                            <li><p>{{ trans('messages.In your bonus balance') }}: <b>{{ $user->getUserBonusBalance() }}</b></p></li>
                            <li><a href="{{ route('transfer-to-main', ['transfer' => 'bonus']) }}" class="btn btn-primary ml-2 text-white">{{ trans('messages.Transfer to main') }}</a></li>
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div id="bonus_lists" class="tab-pane fade active show">
                            <div class="pro_general">
                                <div class="score_main">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>№</th>
                                            <th width="10%">{{ trans('messages.Logo') }}</th>
                                            <th width="15%">{{ trans('messages.Title') }}</th>
                                            <th style="width: 40%">{{ trans('messages.Description') }}</th>
                                            <th width="15%">{{ trans('messages.Bonus value') }}</th>
                                            <th width="15%">{{ trans('messages.Actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bonuses as $bonus)
                                            <tr>
                                                <td>{{ $bonus->id }}</td>
                                                <td><img class="rounded" style="width: 50px; height: 50px" src="{{ $bonus->getImage() }}" alt="{{ $bonus->title }}"></td>
                                                <td>{{ $bonus->title }}</td>
                                                <td>{!! $bonus->description !!}</td>
                                                <td>{{ $bonus->bonus . " " . trans('messages.sum') }}</td>
                                                <td class="align-middle">
                                                    @if($bonus->getUserBonusInDay != null)
                                                        <p class="text-center">{{ trans('messages.You have received a bonus') }}</p>
                                                    @else
                                                        <a href="{{ route('profile.get-bonus', ['bonus' => $bonus]) }}"
                                                           class="btn btn-primary blue btn-sm">
                                                            {{ trans('messages.Get bonus') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="user_bonus_history" class="tab-pane fade">
                            <div class="pro_general">
                                <div class="score_main">
                                    @if(count($user_bonus_history_list_with_pagination) > 0)
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th style="width: 60%">{{ trans('messages.Bonus title') }}</th>
                                                <th style="width: 60%">{{ trans('messages.Description') }}</th>
                                                <th style="width: 15%">{{ trans('messages.Date') }}</th>
                                                <th style="width: 10%">{{ trans('messages.Bonus value') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user_bonus_history_list_with_pagination as $user_bonus_history)
                                                <tr>
                                                    <td>{{ $user_bonus_history->id }}</td>
                                                    <td>{{ $user_bonus_history->getBonus->title }}</td>
                                                    <td>{{ $user_bonus_history->getBonus->description }}</td>
                                                    <td>{{ $user_bonus_history->getDate() }}</td>
                                                    <td>{{ $user_bonus_history->summa . " " . trans('messages.sum') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="ml-3">
                                            {{ $user_bonus_history_list_with_pagination->links() }}
                                        </div>
                                    @else
                                        <table class="score table">
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th style="width: 60%">{{ trans('messages.Bonus title') }}</th>
                                                <th style="width: 15%">{{ trans('messages.Date') }}</th>
                                                <th style="width: 10%">{{ trans('messages.Summa') }}</th>
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
                </div>
            </div>
        </div>
    </section>
@endsection
