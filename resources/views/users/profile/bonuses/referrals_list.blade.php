@extends('layouts.app')
@section('title'){{ trans('messages.User referrals list') }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.User referrals list') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8 c_cabinet">
                    <div class="score_main">
                        <div class="score_main_top">
                            <a class="insco">{{ trans('messages.Your referrals list') }}</a>
                            <div>
                                <p>{{ trans('messages.In your referral balance') }}: <b>{{ $user->getUserReferralBalance() }}</b></p>
                                <a href="{{ route('transfer-to-main', ['transfer' => 'referal']) }}" class="more_know blue">{{ trans('messages.Transfer to main') }}</a>
                            </div>
                        </div>
                        <div class="score_main_top row" >
                            <div class="col-md-3">
                                <p>{{ trans('messages.In your referral link') }}:</p>
                            </div>
                            <div class="col-md-6">
                                <input id="referral_link" readonly="" type="text" class="form-control" value="{{ route('register', ['ref' => auth()->user()->getAuthIdentifier()]) }}">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block"
                                onclick="copyToClipBoard()">{{ trans('messages.Copy link') }}</button>
                            </div>

                        </div>
                        @if(count($user_referrals) > 0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 10%">№</th>
                                    <th>{{ trans('messages.Full Name') }}</th>
                                    <th style="width: 16%">{{ trans('messages.Status') }}</th>
                                    <th style="width: 16%">{{ trans('messages.Date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user_referrals as $user_referral)
                                    <tr >
                                        <td>{{ $user_referral->id }}</td>
                                        <td>
                                            {{--<a href="{{ route('user-items', ['login' => $user_referral->getUserLogin()]) }}">
                                                {{ $user_referral->getUserFio() }}
                                            </a>--}}
                                            {{ $user_referral->getUserFio() }}
                                        </td>
                                        <td>
                                            @if($user_referral->status == \App\User::ACTIVE_USER)
                                                <span>{{ trans('messages.Active') }}</span>
                                            @else <span>{{ trans('messages.No active') }}</span> @endif
                                        </td>
                                        <td>{{ $user_referral->getRegistryDate() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="ml-3">
                                {{ $user_referrals->links() }}
                            </div>
                        @else
                            <table class="score table">
                                <thead>
                                <tr>
                                    <th style="width: 10%">№</th>
                                    <th>{{ trans('messages.Full Name') }}</th>
                                    <th style="width: 16%">{{ trans('messages.Status') }}</th>
                                    <th style="width: 16%">{{ trans('messages.Date') }}</th>
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
@section('extra-js')
    <script>
        function copyToClipBoard() {
            /* Get the text field */
            let copyText = document.getElementById("referral_link");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert("{{ trans('messages.Copied the referral link') }}: " + copyText.value);
        }
    </script>
@endsection
