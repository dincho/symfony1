var static_markers = new Array();
var areas_map;
var g_marker;
var geocoder;

function init_area_map() {
    areas_map = new google.maps.Map(document.getElementById("areas_map"), {zoom: 3});
    geocoder = new google.maps.Geocoder();

    geocoder.geocode({ 'address': country}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            areas_map.setCenter(results[0].geometry.location, 3); //the second parameter is the zoom
            var icon = {
                url: '/images/heart.gif',
                // This marker is 20 pixels wide by 32 pixels tall.
                size: new google.maps.Size(23, 21),
                // The origin for this image is 0,0.
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at 0,32.
                anchor: new google.maps.Point(11, 10)
            };

            g_marker = new google.maps.Marker({
                icon: icon,
                position: results[0].geometry.location
            });
        }
    });
}

function show_area(area) {
    var address = country + ', ' + area;

    geocoder.geocode({ 'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var point = results[0].geometry.location;
            areas_map.setCenter(point, 3); //the second parameter is the zoom

            if (areas_map.getZoom() != 5) //full country view
            {
                areas_map.setCenter(point, 5);
            } else {  //already zoomed 
                areas_map.panTo(point);
            }
            g_marker.setMap(areas_map);
            g_marker.setPosition(point);
        }
    });
}
