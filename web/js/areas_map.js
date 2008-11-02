var static_markers = new Array();

function init_area_map()
{
    if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("areas_map"), { size: new GSize(420,360) } );
        geocoder = new GClientGeocoder();
        
        geocoder.getLatLng(
            country,
            function(point) {
                if (point) {
                    map.setCenter(point, 3);
                    var prIcon = new GIcon(G_DEFAULT_ICON);
                    prIcon.shadow = false;
                    prIcon.image = "/images/gmaps_heart.gif";
                    prIcon.iconSize = new GSize(23,21);
                    prIcon.iconAnchor = new GPoint(11, 10); //center the icon over the city
                    g_marker = new GMarker(point, prIcon);
                }
            }
        );
    }
}

function show_area(area)
{
    if (GBrowserIsCompatible()) {
        address = country + ', ' + area;
        
        geocoder.getLatLng(
            address,
            function(point) {
                if (point) {
                    if( map.getZoom() != 5 ) //full country view
                    {
                        map.setCenter(point, 5);
                    } else {  //already zoomed 
                        map.panTo(point);
                    }
                    map.addOverlay(g_marker);
                    g_marker.setLatLng(point);
                }
            }
        );
    }
}
/*
function changeMarker(oChk, area)
{
    if (GBrowserIsCompatible()) {
        address = country + ', ' + area;
        
        geocoder.getLatLng(
            address,
            function(point) {
                if (point) {
                    if( map.getZoom() != 5 ) //full country view
                    {
                        map.setCenter(point, 5);
                    } else {  //already zoomed 
                        map.panTo(point);
                    }
                    if( oChk.checked )
                    {
	                    var prIcon = new GIcon(G_DEFAULT_ICON);
	                    prIcon.shadow = false;
	                    prIcon.image = "/images/gmaps_static_heart.gif";
	                    prIcon.iconSize = new GSize(23,21);
	                    prIcon.iconAnchor = new GPoint(11, 10); //center the icon over the city
	                    static_markers[oChk.value] = new GMarker(point, prIcon);
	                    map.addOverlay(static_markers[oChk.value]);
	                    static_markers[oChk.value].setLatLng(point);
	                 } else {
	                   map.removeOverlay(static_markers[oChk.value]);
	                 }
                }
            }
        );
    }
}
*/