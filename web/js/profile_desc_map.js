var showing_map = false;

function show_profile_desc()
{
    document.getElementById('profile_map').style.display = 'none';
    document.getElementById('profile_desc').style.display = '';
    GUnload();
    showing_map = false;
}

function show_profile_map(address, cityInfo)
{
  if( showing_map ) return;
  
    if (GBrowserIsCompatible()) {
      showing_map = true;
        document.getElementById('profile_desc').style.display = 'none';
        document.getElementById('profile_map').style.display = '';      
        var map = new GMap2(document.getElementById("gmap"), { size: new GSize(320,320) } );
        var geocoder = new GClientGeocoder();
      
        geocoder.getLatLng(
            address,
            function(point) {
                if (point) {
                    map.setCenter(point, 6); //the second parameter is the zoom
                    var prIcon = new GIcon(G_DEFAULT_ICON);
                    prIcon.shadow = false;
                    prIcon.image = "/images/gmaps_static_heart.gif";
                    prIcon.iconSize = new GSize(23,21);
                    prIcon.iconAnchor = new GPoint(11, 10); //center the icon over the city
                    //redIcon3.infoWindowAnchor = new GPoint(6,0);
      
                    var marker = new GMarker(point, prIcon);
                    map.addOverlay(marker);
          
                    if( cityInfo )
                    {
                      var label_content = '<div style="padding: 0px 0px 8px 8px; background: url(/images/point_bottom_left.png) no-repeat bottom left;"><div style="background-color: black; padding: 5px; width: 100px">'+ cityInfo + '<\/div><\/div>';
                      var label = new ELabel(point, label_content, null, null, 80, true);
                      map.addOverlay(label);
                    }
                }
            }
        );
    }
}