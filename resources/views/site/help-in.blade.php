@extends('layouts.help')
@section('title'){!! $seo['helps_category_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_category_description'] !!}">
	<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_category_keyword'] !!}">
	<link rel="canonical" href="{{ url()->full() }}"/>
@foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
@endsection

@section('content')

<section class="helping">
    <div class="container">
      	<nav aria-label="breadcrumb" class="my_nav">
        	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('help') }}">{{ trans('messages.Help') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category['name'] }}</li>
            </ol>
            <h1 class="title">{{ $category['name'] }}</h1>
      	</nav>
      	<div class="help_tab">
		    <div class="help_tab_left">
		        <ul class="nav">
		            @foreach($categories as $help)
                        <li><a href="{{ route('help-in', $help['id']) }}" class="{{ $help['id'] == $categoryId ? 'active' : '' }}" >{{ $help['name'] }}</a></li>
                    @endforeach
		        </ul>
		        <div class="tab_bottom_help">
                    <a href="tel:{{ Config::get('settings.phone') }}" class="tel_help">{{ Config::get('settings.phone') }}</a>
                    <a href="{{ route('help') }}" class="support_services">{{ trans('messages.Support') }}</a>
                </div>
		    </div>
	        <div class="tab-content for_business">
		        <div id="ges0" class="tab-pane show active">
		        	<h3>{{ $category['name'] }}</h3>
		        	<ul class="links_hel nav">
		        		@php $i=0; @endphp
		        		@foreach($category['helps'] as $help)
			        		<li><a data-toggle="tab" href="#help_{{ $help['id'] }}" class="{{ ++$i == 1 ? 'active' : '' }}">{{ $help['name'] }}</a></li>
			        	@endforeach
		        	</ul>
		        	<div class="tab-content pickwork">
		        		@php $i=0; @endphp
		        		@foreach($category['helps'] as $help)
			        		<div id="help_{{ $help['id'] }}" class="tab-pane {{ ++$i == 1 ? 'show active' : '' }} ">
			        			<p>{{ $help['text'] }}</p>
				                <div class="helpful">
				                  	<h5>{{ trans('messages.Article helpful') }}</h5>
				                  	<div>
					                    <a href="javascript:void(0)" id="like" data-url="{{ route('help-usefull', ['id' => $help['id'], 'type' => 'yes']) }}" onclick="copy(this)" class="more_know blue">
					                    	<svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
			                                    <g><g><path d="M11.5 4.5l-.005.04.005.005V5.5c0 .13-.025.25-.07.365L9.92 9.39A.993.993 0 0 1 9 10H4.5c-.55 0-1-.45-1-1V4c0-.275.11-.525.295-.705L7.085 0l.53.525c.135.135.22.325.22.53l-.015.16L7.345 3.5H10.5c.55 0 1 .45 1 1zM.5 10V4h2v6z" /></g></g>
			                                </svg>{{ trans('messages.Yes') }}
			                                ({{ $help['usefull_count'] }})
			                            </a>
					                    <a href="javascript:void(0)" id="dislike" data-url="{{ route('help-usefull', ['id' => $help['id'], 'type' => 'no']) }}" onclick="copy(this)" class="tra_link">
					                    	<svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
			                                    <g><g><path d="M9.5 6h2V0h-2zM3 0c-.415 0-.77.25-.92.61L.57 4.135A.988.988 0 0 0 .5 4.5v.955l.005.005L.5 5.5c0 .55.45 1 1 1h3.155L4.18 8.785l-.015.16c0 .205.085.395.22.53l.53.525L8.21 6.705c.18-.18.29-.43.29-.705V1c0-.55-.45-1-1-1z" /></g></g>
			                                </svg>{{ trans('messages.No') }}
			                                ({{ $help['nousefull_count'] }})
			                            </a>
				                  	</div>
				                </div>
			        		</div>
			        	@endforeach
		        	</div>
		        </div>
        	</div>
      	</div>
    </div>
</section>
@endsection
@section('extra-js')
    <script>
        function copy(that){
            let dislike = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><g><g><path d="M9.5 6h2V0h-2zM3 0c-.415 0-.77.25-.92.61L.57 4.135A.988.988 0 0 0 .5 4.5v.955l.005.005L.5 5.5c0 .55.45 1 1 1h3.155L4.18 8.785l-.015.16c0 .205.085.395.22.53l.53.525L8.21 6.705c.18-.18.29-.43.29-.705V1c0-.55-.45-1-1-1z" /></g></g></svg>{{ trans("messages.No") }}';
            let like = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><g><g><path d="M11.5 4.5l-.005.04.005.005V5.5c0 .13-.025.25-.07.365L9.92 9.39A.993.993 0 0 1 9 10H4.5c-.55 0-1-.45-1-1V4c0-.275.11-.525.295-.705L7.085 0l.53.525c.135.135.22.325.22.53l-.015.16L7.345 3.5H10.5c.55 0 1 .45 1 1zM.5 10V4h2v6z" /></g></g></svg>{{ trans("messages.Yes") }}';
            var url = that.getAttribute("data-url");
            $.ajax(url, { type: 'GET', success: function(success){
                    $('#like').html(like + ' (' + success.like + ')');
                    $('#dislike').html(dislike + ' (' + success.dislike + ')');
                } });
        }
    </script>
@endsection
