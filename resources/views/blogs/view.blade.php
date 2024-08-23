@extends('layouts.app')
@section('title'){!! $seo['blog_post_title'] !!} @endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_post_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_post_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $blog['slug']:$lang->url.'/'.$blog['slug']) }}"/>
@endforeach
    <meta property="og:title" content="{!! $seo['blog_post_title'] !!}">
    <meta property="og:description" content="{!! $seo['blog_post_description'] !!}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{!! $seo['blog_post_site_name'] !!}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:type" content="website">
@endsection()
@section('content')
    <script>
        const favorites = localStorage.getItem('blog_favorites_{{$blog['id']}}}');
        if(favorites){
            const hearts = document.getElementsByClassName('blog_favorites_{{$blog['id']}}}');
            hearts.forEach((heart) => heart.classList.add('active'));

        }
        function sendParam() {
            $.ajax("{{ URL('/blogs/set-like/' . $blog['id']) }}", {
                type: 'GET',
            });
        }
        const setFavorites = (id) => {
            localStorage.setItem(`blog_favorites_${id}`, 1);
        }

        function copy(that) {
            var inp = document.createElement('input');
            document.body.appendChild(inp)
            inp.value = that.getAttribute("data-url")
            inp.select();
            document.execCommand('copy', false);
            inp.remove();
            alert("{{ trans('messages.Blogs shared text') }}");
        }
    </script>

    <section class="inner_blog">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('blogs-list') }}">{{ trans('messages.Blog') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('blogs-category', $category['key']) }}">{{ $category['name'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $blog['title'] }}</li>
                </ol>
            </nav>
            <div class="qled">
                <div class="qled_share">
                    <div class="favoruites_product {{ $blog['favorite'] ? 'active' : null }}" onclick="sendParam()">
                    </div>
                    <a data-url="{{ route('blogs-list', $blog['slug']) }}" id="clipboardDiv" onclick="copy(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13">
                            <g>
                                <g>
                                    <path d="M9.667 3.667V.333L15.5 6.167 9.667 12V8.583C5.5 8.583 2.583 9.917.5 12.833 1.333 8.667 3.833 4.5 9.667 3.667z"/>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="overasy">{{ $category['name'] }}</div>
                <h1>{{ $blog['title'] }}</h1>
                <div class="user_blog">
                    <img src="{{ $blog['userAvatar'] }}" alt="{{ $blog['userFio'] }}">
                    <div>
                        <span>{{ $blog['userFio'] }}</span>
                        <span class="dat">{{ $blog['date_cr'] }}</span>
                    </div>
                    <div class="info_cap">
                        <span><img src="/images/letter.svg" alt="letter">{{ $blog['msgCount'] }}</span>
                        <span><img src="/images/eye.svg" alt="eye">{{ $blog['view_count'] }}</span>
                    </div>
                </div>
                <h4>{!! $blog['short_text'] !!}</h4>
                <div class="blog_text">
                    <p>{!! $blog['text'] !!}</p>
                </div>

                @if ($user == null)
                    <h3>{{ trans('messages.Comments') }}</h3>
                    <div class="alert alert-warning">
                        @php
                            $text = trans('messages.No comment text');
                            $text = str_replace("{register_link}", route('register'), $text);
                            $text = str_replace("{auth_link}", route('login'), $text);
                            echo $text;
                        @endphp
                    </div>
                @else
                    <div class="comments">
                        <h3>{{ trans('messages.Comments') }}</h3>
                        @foreach($msgList as $msg)
                            <div class="item_comment">
                                <div class="top_item_comment">
                                    <img src="{{ $msg['userAvatar']}}" alt="Avatar">
                                    <div class="text">
                                        <h5>{{ $msg['userFio']}}</h5>
                                        @if($msg['userOnlineStatus'])
                                            <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                                        @else
                                            <div class="on_of">{{ trans('messages.Offline') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <p>{{ $msg['message']}}</p>
                                <div class="bottom_rep">
                                    <!-- <div class="repl">
                                        <img src="/images/reply.png" alt="reply" class="repl_tog">
                                        <div class=" dropdown_popup">
                                            <a href="#" class=""><span><i class="fas fa-ellipsis-h"></i></span></a>
                                            <div class="dropdown_popup_body">
                                                <a href="#"><span>Удалить</span></a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="likes">
                                        <div class="dislike">
                                            <a href="#" class="dislike">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                                  <g><g><path d="M9.5 6h2V0h-2zM3 0c-.415 0-.77.25-.92.61L.57 4.135A.988.988 0 0 0 .5 4.5v.955l.005.005L.5 5.5c0 .55.45 1 1 1h3.155L4.18 8.785l-.015.16c0 .205.085.395.22.53l.53.525L8.21 6.705c.18-.18.29-.43.29-.705V1c0-.55-.45-1-1-1z" /></g></g>
                                              </svg>
                                            </a>
                                            <span>4</span>
                                        </div>
                                        <div class="like">
                                            <a href="#" class="like">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                                    <g><g><path d="M11.5 4.5l-.005.04.005.005V5.5c0 .13-.025.25-.07.365L9.92 9.39A.993.993 0 0 1 9 10H4.5c-.55 0-1-.45-1-1V4c0-.275.11-.525.295-.705L7.085 0l.53.525c.135.135.22.325.22.53l-.015.16L7.345 3.5H10.5c.55 0 1 .45 1 1zM.5 10V4h2v6z" /></g></g>
                                                </svg>
                                            </a>
                                            <span>82</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        @endforeach

                        <div class="answer_letter">
                            <i class="fas fa-reply"></i>
                            <div class="inrepl">
                                <div class="answer_letter_name"></div>
                                <div class="answer_letter_some"></div>
                            </div>
                            <div class="close_let"><img src="/images/close.png" alt="close"></div>
                        </div>
                        <div class="self_kom">
                            <form action="{{ route('blogs-send-comment') }}" method="POST">
                                @csrf
                                <div class="top_item_comment">
                                    <img src="{{ $user->getAvatar() }}" alt="Avatar">
                                    <div class="text">
                                        <h5>{{ $user->getUserFio() }}</h5>
                                        @if($user->getOnlineStatus())
                                            <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                                        @else
                                            <div class="on_of">{{ trans('messages.Offline') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="blog_id" value="{{ $blog['id'] }}">
                                <textarea name="message" placeholder="{{ trans('messages.Comment') }}"></textarea>
                                <button type="submit" class="more_know blue">{{ trans('messages.Send') }}</button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
            @if(isset($banners['blog_view']))
                @if($banners['blog_view']['type'] == 1)
                    <div class="ariela">
                        <img src="{{ $banners['blog_view']['img'] }}" alt="{{ $banners['blog_view']['alt'] }}">
                        <div>
                            <h2>{{ $banners['blog_view']['title'] }}</h2>
                            <a href="{{ route('banner-item', $banners['blog_view']['id'] ) }}" target="_blank"
                               rel="nofollow" class="more_know blue">{{ trans('messages.Details') }}</a>
                        </div>
                    </div>
                @else
                    <div class="">
                        <br>
                        {!! $banners['blog_view']['type_data'] !!}
                    </div>
                @endif
            @endif
            <div class="blogs_product">
                @if(count($likePosts) > 0)
                    <div class="pre_top blog_tit aler">
                        <div class="title">{{ trans('messages.Similar topics') }}</div>
                        <!-- <a href="#">Посмотреть все</a> -->
                    </div>
                    <div class="row">
                    @foreach($likePosts as $post)
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('blogs-view', $post['slug'] ) }}" class="product_item width_blogs">
                                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                                <div class="product_text">
                                    <div class="span_blogs">
                                        <span>{{ $post['userFio'] }}</span>
                                        <div class="eye_bl">
                                            <svg data-name="Icons / Messages" xmlns="http://www.w3.org/2000/svg"
                                                 width="18" height="18" viewBox="0 0 18 18">
                                                <path id="_Icon_Color" data-name="🔹 Icon Color"
                                                      d="M8.25,11.25A8.8,8.8,0,0,1,3.205,9.672,8.877,8.877,0,0,1,0,5.625a8.864,8.864,0,0,1,16.5,0,8.877,8.877,0,0,1-3.205,4.047A8.8,8.8,0,0,1,8.25,11.25Zm0-9.375A3.75,3.75,0,1,0,12,5.625,3.754,3.754,0,0,0,8.25,1.875Zm0,6a2.25,2.25,0,1,1,2.25-2.25A2.253,2.253,0,0,1,8.25,7.875Z"
                                                      transform="translate(0.75 3.75)"/>
                                            </svg>
                                            <b>{{ $post['view_count'] }}</b>
                                        </div>
                                    </div>
                                    <h4>{{ $post['title'] }}</h4>
                                    <div class="arch">{!! $post['short_text'] !!}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        const awayLink = '{{ route('away', ['link' => '']) }}';
        const blogLink = document.querySelectorAll('.blog_text a');
        blogLink.forEach((link) => {
            link.href = awayLink + link.href;
            link.rel = 'nofollow';
        });
    </script>
@endsection
