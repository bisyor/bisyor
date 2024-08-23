@extends('layouts.app')
@section('title'){{ trans('messages.User account') }} @endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" />
    <link href="/css/cropper.min.css" rel="stylesheet"/>
    <style>
        .image_area {
            position: relative;
        }

        .img-container{
            overflow: hidden;
        }
        .img-container img {
            display: block;
            max-width: 100%;

        }

        .preview_cropper {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 20px;
            border-radius: 50%;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

    </style>
    <script>
        function amountCalc(new_key, new_value) {
            $.get('/set-session', {key: new_key, value: new_value}, function (result) {
            });
        }
    </script>

    @php
        $tab = 'detail';
        if(session('profile-settings') != null) $tab = session('profile-settings');
    @endphp

    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Settings') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8">
                    <div class="setting_c">
                        <ul class="nav tab_top_settings">
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'detail')" href="#ss0"
                                   class="{{ $tab=='detail' ? 'active show' : '' }}">
                                    {{ trans('messages.Contact details') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'email')" href="#ss1"
                                   class="{{ $tab=='email' ? 'active show' : '' }}">
                                    {{ trans('messages.Configure Email Notifications') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'sms')" href="#ss2"
                                   class="{{ $tab=='sms' ? 'active show' : '' }}">
                                    {{ trans('messages.Setting SMS notifications') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'password')" href="#ss3"
                                   class="{{ $tab=='password' ? 'active show' : '' }}">
                                    {{ trans('messages.Change Password') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'phone')" href="#ss4"
                                   class="{{ $tab=='phone' ? 'active show' : '' }}">
                                    {{ trans('messages.Change phone number') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'change-email')"
                                   href="#ss5" class="{{ $tab=='change-email' ? 'active show' : '' }}">
                                    {{ trans('messages.Change Email Address') }}
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" onclick="amountCalc('profile-settings', 'delete')" href="#ss6"
                                   class="{{ $tab=='delete' ? 'active show' : '' }}">
                                    {{ trans('messages.Delete your account') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="ss0" class="tab-pane fade {{ $tab=='detail' ? 'active show' : null }}">
                                @include('users.profile.contact-details', ['user' => $user])
                            </div>
                            <div id="ss1" class="tab-pane fade {{ $tab=='email' ? 'active show' : null }} ">
                                @include('users.profile.email-notifications', ['user' => $user])
                            </div>
                            <div id="ss2" class="tab-pane fade {{ $tab=='sms' ? 'active show' : null }} ">
                                @include('users.profile.sms-notifications', ['user' => $user])
                            </div>
                            <div id="ss3" class="tab-pane fade {{ $tab=='password' ? 'active show' : null }} ">
                                @include('users.profile.change-password', ['user' => $user])
                            </div>
                            <div id="ss4" class="tab-pane fade {{ $tab=='phone' ? 'active show' : null }} ">
                                @if (isset($verify_status))
                                @include('users.profile.verify_phone', ['user' => $user, 'verify_status' =>$verify_status, 'new_phone' => $new_phone, 'error_message' => $error_message])
                                @else
                                    @include('users.profile.change-phone', ['user' => $user])
                                @endif
                            </div>
                            <div id="ss5" class="tab-pane fade {{ $tab=='change-email' ? 'active show' : null }} ">
                                @include('users.profile.change-email', ['user' => $user])
                            </div>
                            <div id="ss6" class="tab-pane fade {{ $tab=='delete' ? 'active show' : null }} ">
                                @include('users.profile.delete-accaunt', ['user' => $user])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('users.profile.crop_modal')

@section('extra-js')
    @include('inc.yandex-map')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
    <script src="/js/cropper.min.js"></script>
    <script>
        /* Begin cropper*/


        $(document).ready(function(){

            const $modal = $('#modal');

            const image = document.getElementById('sample_image');

            let cropper;

            $('#teret').change(function(event){

                const files = event.target.files;
                const done = function(url){
                    image.src = url;
                    $modal.modal('show');
                    $('#teret').val(null);

                };
                let reader;
                if(files && files.length > 0)
                {
                    reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview:'.preview_cropper'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                let canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });
                canvas.toBlob(function(blob){
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        const base64data = reader.result;
                        $modal.modal('hide');
                        $('#preview').attr('src', base64data);
                        $('.image_change').attr('value', base64data);
                    };
                });
            });

        });

        /* End cropper*/

        // Set langage for datepicker
        $.fn.datepicker.dates['ru'] = {
            days: [{!! trans('messages.Days names') !!}],
            daysShort: [{!! trans('messages.Days names short') !!}],
            daysMin: [{!! trans('messages.Days names min') !!}],
            months: [{!! trans('messages.Month names') !!}],
            monthsShort: [{!! trans('messages.Month names short') !!}],
            today: "{{ trans('messages.Today') }}"
        };
        $("#birthday").datepicker ({
            autoclose: true,
            format: 'yyyy-mm-dd',
            zIndexOffset: 999,
            language: 'ru'
        });
        /*var map;
        var marker;
        var coordinate_x = $('#coordinate_x').val() * 1;//document.getElementById("coordinate_x").value; //$('#coordinate_x').val();
        var coordinate_y = $('#coordinate_y').val() * 1;//document.getElementById("coordinate_y").value; //$('#coordinate_y').val();
        //var myLatlng = new google.maps.LatLng(coordinate_x, coordinate_y);
        //var geocoder = new window.google.maps.Geocoder();
        //var infowindow = new google.maps.InfoWindow();
        function initialize() {
            geocoder = new google.maps.Geocoder();
            var mapOptions = {
                zoom: 7,
                //center: myLatlng,
                center: {lat: coordinate_x, lng: coordinate_y},
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                rotateControl: true,
                fullscreenControl: true,
            };

            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            marker = new google.maps.Marker({
                map: map,
                //position: myLatlng,
                position: {lat: coordinate_x, lng: coordinate_y},
                draggable: true
            });

            geocoder.geocode({'latLng': {lat: coordinate_x, lng: coordinate_y}}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('#coordinate_x,#coordinate_y').show();
                        $('#address').val(results[0].formatted_address);
                        $('#coordinate_x').val(marker.getPosition().lat());
                        $('#coordinate_y').val(marker.getPosition().lng());
                        //infowindow.setContent(results[0].formatted_address);
                        //infowindow.open(map, marker);
                    }
                }
            });

            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#coordinate_x').val(marker.getPosition().lat());
                            $('#coordinate_y').val(marker.getPosition().lng());
                        }
                    }
                });
            });

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                $('#address').val(place.formatted_address);
                $('#coordinate_x').val(place.geometry.location.lat());
                $('#coordinate_y').val(place.geometry.location.lng());
                map.setCenter(place.geometry.location);
                marker.setPosition(place.geometry.location);
            });
        }*/

        //google.maps.event.addDomListener(window, 'load', initialize);
    </script>

{{--    <script async defer--}}
{{--            src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.geo_maps_googleKey') }}&v=3.exp&language={{ app()->getLocale() }}&libraries=places&callback=initialize"></script>--}}
@stop
@endsection
