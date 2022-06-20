window.locate = (callback = initMap) => {
    navigator.geolocation.getCurrentPosition(function(position) {
        callback(position);
    });
}
window.initMap = (position) => {
    let myLatLng = customizeLatLng(position);
    let map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:myLatLng,
        zoom:10,
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        draggable: true
    });
    var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
    google.maps.event.addListener(searchBox,'places_changed', function() {
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for(i=0; i < places.length; i++){
            place = places[i];
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location); //set marker position new...
        }
        map.fitBounds(bounds);
        map.setZoom(5);
    });
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'latLng': marker.getPosition()
    });
    google.maps.event.addListener(marker,'position_changed',function() {
       document.getElementById("latitude").value = marker.getPosition().lat();
       document.getElementById("longitude").value = marker.getPosition().lng();

    });
    document.getElementById("searchLatLng").addEventListener("click", () => {
        geocodeLatLng(geocoder, google, marker, map);
    });
}

const geocodeLatLng = (geocoder, google, marker, map) => {
    let latitude = parseFloat(document.getElementById("latitude").value);
    let longitude = parseFloat(document.getElementById("longitude").value);
    if (latitude && longitude) {
        let latLng = {'lat':latitude, 'lng': longitude}
        geocoder.geocode({
        'latLng': latLng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var bounds = new google.maps.LatLngBounds();
                    bounds.extend(latLng);
                    marker.setPosition(latLng)
                    map.fitBounds(bounds);
                    map.setZoom(10);
                }
            }
        });
    }
}

window.locateView = () => {
    locate(initMapView);
}

window.initMapView = (position) => {
    let myLatLng = customizeLatLng(position);
    let map = new google.maps.Map(document.getElementById('map-canvas'), {
        center:myLatLng,
        zoom:10,
    });
    let marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        draggable: false
    });
    console.log(marker);
}

const customizeLatLng = (position) => {
    let lat = document.getElementById("latitude").value ?
    parseFloat(document.getElementById("latitude").value) : position.coords.latitude;
    let lng = document.getElementById("longitude").value ?
    parseFloat(document.getElementById("longitude").value) : position.coords.longitude;
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;

    return {
        lat: lat,
        lng: lng
    }
}
