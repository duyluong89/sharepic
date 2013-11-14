function load_map(map){
    var layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
    var vector = new OpenLayers.Layer.Vector('vector');
    map.addLayers([layer, vector]);

    add_marker(map, '-0.1279688', '51.5077286', 'Trang');
}

function add_marker(map, lat, lon, gps) {
    var lonLat = new OpenLayers.LonLat(lat, lon);
    lonLat.transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
    );

    var zoom = 15;
    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
    marker = new OpenLayers.Marker(lonLat);
    marker.events.register('click', marker, function(evt) {
        //display_info(gps);
    });
    markers.addMarker(marker);
    map.setCenter (lonLat, zoom);
}

function add_linestring(map,point_array) {
	var style = {
            strokeColor: 'black',
            strokeOpacity: 1,
            strokeWidth: 4
    };
	//
    var count = point_array.length;
    var center = (count - count%2)/2;
    if(point_array[center][0] != 'color')
	{
    	var lat = point_array[center][0];
        var lon = point_array[center][1];
	}
    else
	{
    	var lat = point_array[center + 1][0];
        var lon = point_array[center + 1][1];
	}
    var lineLayer = new OpenLayers.Layer.Vector('Polyline');
    
    for (var i = 0; i < count; i++) {
        pos = point_array[i];
        if(pos[0] == 'color' || i == (count - 1))
    	{
        	if(pos[0] == 'color' && i > 0)
    		{
        		pos2 = point_array[i + 1];
        		polyline.push(new OpenLayers.Geometry.Point(pos2[0],pos2[1]));
    		}
        	if(i == (count - 1))
        		polyline.push(new OpenLayers.Geometry.Point(pos[0],pos[1]));
        	
        	var line = new OpenLayers.Geometry.LineString(polyline);
            line = line.transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
            lineFeature = new OpenLayers.Feature.Vector(line, null, style);
            lineLayer.addFeatures([lineFeature]);
            
            map.addLayer(lineLayer);
    	}
        if(pos[0] == 'color')
    	{
            style = {
                strokeColor: pos[1],
                strokeOpacity: 1,
                strokeWidth: 4
            };            
            var polyline = new Array();
    	}
        else
    	{
        	if(i < (count - 1))
        		polyline.push(new OpenLayers.Geometry.Point(pos[0],pos[1]));
    	}
    };
    
    var zoom = 15;
    var lonLat = new OpenLayers.LonLat(lat, lon);
    lonLat.transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
    );
    map.setCenter (lonLat, zoom);
}