var showing_map = false;
var map;

function show_profile_desc() {
    document.getElementById('profile_map').style.display = 'none';
    document.getElementById('profile_desc').style.display = '';
    showing_map = false;
}

function show_profile_map(address, cityInfo) {
    if (showing_map) return;

    showing_map = true;
    document.getElementById('profile_desc').style.display = 'none';
    document.getElementById('profile_map').style.display = '';
    map = map || new google.maps.Map(document.getElementById("gmap"), {zoom: 6});

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({ 'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location, 6); //the second parameter is the zoom
            var icon = {
                url: '/images/gmaps_static_heart.gif',
                // This marker is 20 pixels wide by 32 pixels tall.
                size: new google.maps.Size(23, 21),
                // The origin for this image is 0,0.
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at 0,32.
                anchor: new google.maps.Point(11, 10)
            };

            var marker = new google.maps.Marker({
                map: map,
                icon: icon,
                position: results[0].geometry.location
            });

            if (cityInfo) {
                var label_content = '<div style="min-width: 100px; min-height: 20px">' + cityInfo + '</div>';
                var infowindow = new google.maps.InfoWindow({
                    content: label_content,
                    maxWidth: 200
                });
                infowindow.open(map, marker);
            }
        }
    });
}
