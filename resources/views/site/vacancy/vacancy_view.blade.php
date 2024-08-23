@extends('layouts.app')
@section('title'){!! $seo['mtitle'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['mdescription'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['mkeywords'] !!}">
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}"
              href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}"/>
    @endforeach
    <link rel="canonical" href="{{ url()->full() }}"/>
@endsection

@section('content')

{{--    <section class="vacancy_bc shadow_bc" style="background-image: url(/images/vacan_bc.jpg);">
        <div class="container">
            <h1>Дизайн</h1>
        </div>
    </section>--}}
    <section class="inner_vacant">
        <div class="container">
            <a href="{{ route('vacancy-list', ['id' => $vacancy['category']['parent_id']]) }}" class="back_vacant_specify"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><g><g><path d="M12 5a.667.667 0 0 1-.667.667H2.276l2.862 2.862a.667.667 0 1 1-.943.942l-4-4a.665.665 0 0 1 0-.942l4-4a.667.667 0 1 1 .943.942L2.276 4.333h9.057c.369 0 .667.299.667.667z"></path></g></g></svg>Вернуться к выбору специальностей</a>
            <div class="wrapper_inner_vacant">
                <h5>{{ $vacancy['title'] }}</h5>
                <p class="after_in_vac_title">{{ trans('messages.Price') }} : {{ $vacancy['price'] . " " . $vacancy['currency']['name'] }}</p>
                <p style="line-height: 28px">
                    {!! $vacancy['description'] !!}
                </p>
                <hr>
            </div>
            @include('site.vacancy.send_vacancy')
        </div>
    </section>

@endsection
@section('extra-js')
    <script>
        $('#file_i').on('change', function (event) {
            const files = event.target.files;
            const fileName = files[0].name;
            $('#fileNameArea').html('<div class="alert alert-success alert-dismissable custom-success-box" id="alert_note" style="margin: 15px;"><strong> ' + fileName +  '</strong></div>');
        });
    </script>
@endsection
