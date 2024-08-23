@php

$activeLang = [
    'image' => null,
    'name' => 'ru',
];
foreach($langs as $lang)
{
  if($lang->url == app()->getLocale()) {
      $activeLang = [
          'image' => $lang->getImage(),
          'name' => $lang->local,
      ];
      break;
  }
}

$currentRegion = trans('messages.Choose region');
$getGlobalRegionKeyword = App\Models\References\Additional::getGlobalRegionKeyword();
if($getGlobalRegionKeyword == '' || $getGlobalRegionKeyword == null) {
    $currentRegion = trans('messages.All Uzbekistan');
}
@endphp
<div class="mob_header">
    <div class="toggle_category">
        <img src="/images/category_icon.svg" alt="category_icon">
    </div>
    <div class="toggle-menu-mobile">
        <!-- <span></span>
        <span></span>
        <span></span> -->
        <img src="/images/cubes.svg" alt="category_icon">
    </div>
    <a href="{{ Route::currentRouteName() == 'create-item' ? 'javascript:void(0)' : route('create-item') }}" class="add_oby">
        <img src="/images/add_item.svg" alt="category_icon">
        <!-- {{ trans('messages.To add an advert') }} -->
    </a>
</div>
<header>
    <div class="hdr_top">
        <div class="container">
            <div class="hdr_top_main">
                <div class="hdr_top_left">
                    <div class="language dropdown_popup">
                        <a href="#"><img src="{{ $activeLang['image'] }}" alt="{{ $activeLang['name'] }}"><span>{{ $activeLang['name'] }}</span></a>
                        <div class="dropdown_popup_body">
                            @foreach($langs as $lang)
                                <a href="{{ route('setLocale', ['lang' => $lang->url, 'time' => time()] ) }}"><img src="{{ $lang->getImage() }}" alt="{{ $lang->local }}"><span>{{ $lang->local }}</span></a>
                            @endforeach
                        </div>
                    </div>
                    <div class="location">
                        <span>{{ trans('messages.Location') }}:</span>
                        <div class="location_drop_body dropdown_popup">
                            <div class="dropdown_popup_body">
                                <ul class="main-menu">
                                    <li>
                                        <a href="{{ route('global-region', ['key' => null, 'time' => time()]) }}">{{ trans('messages.All Uzbekistan') }}</a>
                                    </li>
                                    @foreach($additional->regDistricts() as $region)
                                        @php
                                            if($region['keyword'] == $getGlobalRegionKeyword ) $currentRegion = $region['name'];
                                            else {
                                                foreach($region['districtsList'] as $district){
                                                    if($district['keyword'] == $getGlobalRegionKeyword) {
                                                        $currentRegion = $district['name'];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li>
                                            <a href="{{ route('global-region', ['key' => $region['keyword'], 'time' => time() ]) }}">{{$region['name'] }}</a>
                                            <ul class="sub-menu">
                                                @foreach($region['districtsList'] as $district)
                                                    <li><a href="{{ route('global-region', ['key' => $district['keyword'], 'time' => time() ]) }}">{{$district['name'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <a href="#" class="select_region">
                                <img src="/images/navigation.svg" alt="navigation">
                                <span>
                                    {{ $currentRegion }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                @include('inc.top-right-menu', [])
            </div>
        </div>
    </div>
    <div class="hdr_bottom">
        <div class="container">
            <div class="hdr_bottom_main">
                <div class="hdr_bottom_main_left">
                    <a href="{{ Route::currentRouteName() == 'site-index' ? 'javascript:void(0)' : route('site-index') }}" class="logo">
                        <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
                    </a>
                    <span class="all_categories_btn"><img src="/images/category_icon.svg" alt="category_icon">{{ trans('messages.All categories') }}</span>
                    <form action="{{ route('site-search') }}" class="search_form_header" method="get">
                        <button type="submit"><img src="/images/search.svg" alt="search"></button>
                        <input type="text" name="query" id="text" required="" placeholder="{{ trans('messages.Search Ads') }}" value="{{ request()->input('query') }}">
                    </form>
                </div>
                <div class="hdr_bottom_main_right">
                    @if (Auth::guest())
                        <a href="{{ route('login-index') }}" class="enter_site">
                            <img src="/images/user_plus.svg" alt="user_plus">
                            <span>{{ trans('messages.Enter') }}</span>
                        </a>
                        @else
                            @include('inc.user-drop-menu', [ 'user' => \Auth::user() ])
                    @endif
                    @if (Auth::guest())
                        <a href="{{ Route::currentRouteName() == 'create-item' ? 'javascript:void(0)' : route('create-item') }}" class="add_ads">
                            <img src="/images/plus_circle.svg" alt="plus_circle">{{ trans('messages.To add an advert') }}
                        </a>
                    @elseif(Auth::user()->phone_verified)
                        <a href="{{ Route::currentRouteName() == 'create-item' ? 'javascript:void(0)' : route('create-item') }}" class="add_ads">
                            <img src="/images/plus_circle.svg" alt="plus_circle">{{ trans('messages.To add an advert') }}
                        </a>
                    @else
                        <a href="javascript:void(0)" class="add_ads"  id="calModal">
                            <img src="/images/plus_circle.svg" alt="plus_circle">{{ trans('messages.To add an advert') }}
                        </a>
                    @endif

                </div>                
            </div>
        </div>
    </div>

    <div class="category_bod">
        <div class="my_cag">
            <div class="container">
                <div class="category_bod_main">
                    <ul class="nav left_head_nav">
                        @foreach($headerCategories as $key => $first)
                        <li>
                            <a href="" class="{{ $key === 0 ? 'afert_block first_top_menu_item' : '' }}" >{{ $first['title'] }} </a>
                            <div class="inner_a" style="{{ $key === 0 ? 'display: block;' : '' }}">
                                <div class="row">
                                    @foreach($first['secondMenu'] as $second)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="inner_new_a_h4">
                                            <a href="{{ route('items-list', $second['keyword']) }}">{{ $second['title'] }} </a>
                                        </div>
                                        @if($second != null)
                                        <ul>
                                            @foreach($second['thirdMenu'] as $third)
                                            <li><a href="{{ route('items-list', $third['keyword']) }}">{{ $third['title'] }} </a></li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
@if(!isset($video))
    @include('layouts.video')
@endif
