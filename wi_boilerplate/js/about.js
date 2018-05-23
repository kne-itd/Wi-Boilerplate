$(document).ready(function () {
    var adr = $('#address').text();
    var zip = $('#zip').text();
    var city = $('#city').text();
    var address = adr + ',' + zip + ' ' + city;
                    
    var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function (results, status) {
	if (status == google.maps.GeocoderStatus.OK) {
	    if (results[0]) {
		initMap(results[0].geometry.location.lat(), results[0].geometry.location.lng());
	    } else {
		error('Google fandt intet resultat');
	    }
	} else {
	    error('Fejl i Geocoding pga.: ' + status);
	}
    });
});

// output lat and long
function initMap(lat, lng) {

    var map;
    var center = new google.maps.LatLng(lat, lng);
    var myOptions = {
	zoom: 9,
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	center: center
    }

    map = new google.maps.Map(document.getElementById("map"), myOptions);
    var marker = new google.maps.Marker({
	position: center,
	map: map
    });
}
 
function error(msg) {
        alert(msg);
}