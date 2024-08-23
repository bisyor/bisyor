<script>
    /*var map;
        var marker;
        var coordinate_x = parseInt($('#coordinate_x').val()) * 1;
        var coordinate_y = parseInt($('#coordinate_y').val()) * 1;
        function initialize(){
            geocoder = new google.maps.Geocoder();
            var mapOptions = {
                zoom: 7,
                center : {lat : coordinate_x, lng : coordinate_y},
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
                position : {lat : coordinate_x, lng : coordinate_y},
                draggable: true
            });

            geocoder.geocode({'latLng': {lat : coordinate_x, lng : coordinate_y} }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('#coordinate_x,#coordinate_y').show();
                        $('#address').val(results[0].formatted_address);
                        $('#coordinate_x').val(marker.getPosition().lat());
                        $('#coordinate_y').val(marker.getPosition().lng());
                    }
                }
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
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
            google.maps.event.addListener(autocomplete, 'place_changed', function(){
                var place = autocomplete.getPlace();
                $('#address').val(place.formatted_address);
                $('#coordinate_x').val(place.geometry.location.lat());
                $('#coordinate_y').val(place.geometry.location.lng());
                map.setCenter(place.geometry.location);
                marker.setPosition(place.geometry.location);
            });
        }*/

    $("#file_inp").on('change', function (e) {
        $('.help-block').remove();
        const file = $('#file_inp')[0].files[0];
        const data = new FormData();
        const date = new Date();
        const filename = file.name;
        const date_int = date.getTime();
        const name = filename.split('.').shift();
        const ext = filename.split('.').pop();
        const file_size = Math.round((file.size / 1024));
        if (file_size <= 3072) {
            let new_name = 'bisyor_shop_' + date_int + '_' + name + '.' + ext;
            data.append('file', file);
            data.append('names', new_name);
            $('#temp_address').val(new_name);
            $.ajax({
                url: '{{ route("shops-upload-image") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                success: function (success) {
                    const img_site_name = '{{ config("app.imgSiteName") }}' + success;
                    $('.avatar').attr('style', 'background-image:url("' + img_site_name + '")');
                },
                error: function (success) {
                    alert("Error occur uploading image. Try again )");
                    $(".avatar").css('background-image', 'url(\'{{ config("app.noImage") }}\')');
                },
                cache: false,

                xhr: function () {
                    const myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        $(".avatar").css('background-image', "url('{{ config("app.zzImg") }}')");
                        return myXhr;
                    }
                }
            });
        } else {
            $('.avatar_right').append('<span class="help-block"><strong>{{ str_replace(':max', 3, trans('messages.This file big')) }}</strong></span>');
        }
    });

    $("#file_inp_cover").on('change', function (e) {
        $('.help-block').remove();
        const file = $('#file_inp_cover')[0].files[0];
        const data = new FormData();
        const date = new Date();
        const filename = file.name;
        const date_int = date.getTime();
        let name = filename.split('.').shift();
        const ext = filename.split('.').pop();
        const file_size = Math.round((file.size / 1024));
        if (file_size <= 3072) {
            let new_name = 'shop_cover_' + date_int + '_' + name + '.' + ext;
            data.append('file', file);
            data.append('names', new_name);
            $('#temp_address_cover').val(new_name);
            $.ajax({
                url: '{{ route("shops-upload-image") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (success) {
                    const img_site_name = '{{ config("app.imgSiteName") }}' + success;
                    $('.cover').attr('style', 'background-image:url("' + img_site_name + '")');
                },
                error: function (success) {
                    alert("Error occur uploading image. Try again )");
                    $(".cover").css('background-image', "url('{{ config("app.noImage") }}')");
                },
                cache: false,
                xhr: function () {
                    const myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        $(".cover").css('background-image', "url('{{ config("app.zzImg") }}')");
                        return myXhr;
                    }
                }
            });
        } else {
            $('.cover_right').append('<span class="help-block"><strong>{{ str_replace(':max', 3, trans('messages.This file big')) }}</strong></span>');
        }
    });


    const limit = {{ $settings->value }};
    $('span.add_some_contact').on('click', function () {
        let uu = $('.inpt_clones').length;

        $('.form-group.add_some').append('<div class="inpt_clones"><input type="tel" placeholder="+998xx-xx-xx-xx" name="phones[]" class="form-control" /><div class="clos_contact"></div></div>');

        if (limit <= uu + 1) $(this).hide();
        if (uu + 1 > 1) $('.inpt_clones').children('.clos_contact').show();
        $('.form-group.add_some input').mask("+998nn-nnn-nn-nn");
        $('.clos_contact').on('click', function () {
            $(this).parent().remove();
            uu = $('.inpt_clones').length;
            if (limit >= uu) $('.add_some_contact').show();
            if (uu == 1) $('.inpt_clones').children('.clos_contact').hide();
        });
    });

    $('.clos_contact').on('click', function () {
        $(this).parent().remove();
        uu = $('.inpt_clones').length;
        if (limit >= uu) $('.add_some_contact').show();
        if (uu == 1) $('.inpt_clones').children('.clos_contact').hide();
        if (uu + 1 > 1) $('.inpt_clones').children('.clos_contact').show();
    });
</script>
