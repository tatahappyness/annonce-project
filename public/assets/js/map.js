// Initialize and add the map
function initMap() {

    //AJAX GET GEOLOCATION IN SERVEUR
    jQuery.ajax({
        type : 'GET',
        url : '/pro/get-lat-log-ajax',
        contentType : false,
        processData : false
                        
        }).done(function(response) {
        
            // The map, centered at Uluru
            var uluru = new google.maps.LatLng(parseFloat(response.lat), parseFloat(response.log));
            //The options
            var mapOptions = {
                zoom: 8,
                center: uluru,
                mapTypeId: google.maps.MapTypeId.HYBRID
                };

                var map = new google.maps.Map(
                    document.getElementById('map'), mapOptions);
                // The marker, positioned at Uluru
                var marker = new google.maps.Marker({position: uluru, map: map});

                //circle prespection
                var cityCircle = new google.maps.Circle({
                    strokeColor: '#00BFFF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#87CEFA',
                    fillOpacity: 0.35,
                    map: map,
                    center: uluru,
                    radius: parseInt(response.km) * 1000 //km to in meter
                });
                cityCircle.bindTo('center', marker, 'position');
                //info window
                var contentString = '<div style="z-index: 2;"><p style="font-size: 1em !important;">Téléphone: ' + response.phone + '</p><p style="font-size: 1em !important;">Email: ' + response.email + '</p><p style="font-size: 1em !important;">Code postal: ' + response.zipcode + '</p><p style="font-size: 1em !important;">Ville: ' + response.city + '</p></div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                    });
                //add listener on google map
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                    });
                //street view
                // var panorama = new google.maps.StreetViewPanorama(
                //         document.getElementById('pano'), {
                //         position: uluru,
                //         pov: {
                //             heading: 34,
                //             pitch: 10
                //         }
                //     });
                // map.setStreetView(panorama);
            
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });

}
initMap();