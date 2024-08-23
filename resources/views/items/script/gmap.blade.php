<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.geo_maps_googleKey') }}&v=3.exp&language={{ app()->getLocale() }}&libraries=places&callback=initialize"></script>
<script>
    var map;
    var marker;
    var coordinate_x = ($("#items-coordinate_x").val()) ? parseFloat($("#items-coordinate_x").val()) : 41.2995;
    var coordinate_y = ($("#items-coordinate_y").val()) ? parseFloat($("#items-coordinate_y").val()) : 69.2401;
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
                        $('#items-address').val(results[0].formatted_address);
                        $('#items-coordinate_x').val(marker.getPosition().lat());
                        $('#items-coordinate_y').val(marker.getPosition().lng());
                    }
                }
            });
        });

        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
        google.maps.event.addListener(autocomplete, 'place_changed', function(){
            var place = autocomplete.getPlace();
            $('#items-address').val(place.formatted_address);
            $('#items-coordinate_x').val(place.geometry.location.lat());
            $('#items-coordinate_y').val(place.geometry.location.lng());
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
        });
    }
</script>
