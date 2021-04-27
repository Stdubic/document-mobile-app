const DEFAULT_LAT = -44.3833623;
const DEFAULT_LNG = 171.2402853;
var marker,
	map = null;

function mapResize() {
	if (!map) return;

	var has_pos = true;
	const name = document.getElementById('map_name').value.trim();
	var latitude = document.getElementById('map_latitude').value;
	var longitude = document.getElementById('map_longitude').value;

	if (latitude == '' || longitude == '') {
		latitude = DEFAULT_LAT;
		longitude = DEFAULT_LNG;
		has_pos = false;
	}

	latitude = parseFloat(latitude);
	longitude = parseFloat(longitude);

	google.maps.event.trigger(map, 'resize');
	map.setCenter({ lat: latitude, lng: longitude });
	if (has_pos) pinOnMap(marker, name, latitude, longitude);
}

function initMap() {
	map = new google.maps.Map(document.getElementById('map_container'), {
		center: { lat: DEFAULT_LAT, lng: DEFAULT_LNG },
		zoom: 13
	});

	marker = new google.maps.Marker({
		map: map,
		position: null,
		draggable: true
	});

	map.addListener('click', function(event) {
		const name = document.getElementById('map_name').value.trim();
		pinOnMap(marker, name, event.latLng.lat(), event.latLng.lng());
	});

	map.addListener('rightclick', function(event) {
		const name = document.getElementById('map_name').value.trim();
		pinOnMap(marker, name, event.latLng.lat(), event.latLng.lng());
	});

	marker.addListener('position_changed', function() {
		const latLng = marker.getPosition();
		document.getElementById('map_latitude').value = latLng.lat();
		document.getElementById('map_longitude').value = latLng.lng();
	});
}

function pinOnMap(curr_marker, title, latitude, longitude) {
	const latLng = new google.maps.LatLng({
		lat: parseFloat(latitude),
		lng: parseFloat(longitude)
	});

	curr_marker.setTitle(title);
	curr_marker.setPosition(latLng);
	curr_marker.setAnimation(google.maps.Animation.DROP);
}

function coordinateChange() {
	var latitude = document.getElementById('map_latitude').value;
	var longitude = document.getElementById('map_longitude').value;

	if (latitude == '' || longitude == '') return;

	const latLng = new google.maps.LatLng({
		lat: parseFloat(latitude),
		lng: parseFloat(longitude)
	});

	marker.setPosition(latLng);
}

function getLatLng(googleAPIKey) {
	var address = [
		document.getElementById('country').value.trim(),
		document.getElementById('city').value.trim(),
		document.getElementById('address').value.trim()
	];

	address = address.join('+');
	const url =
		'https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key=' + googleAPIKey;

	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState != 4 || xmlhttp.status != 200) return;

		const output = JSON.parse(xmlhttp.responseText);
		if (!output) {
			alert('Wrong JSON format!');
			return;
		}

		if (output.status != 'OK') {
			alert(
				'Position identification failed.\nStatus code: ' +
					output.status +
					'\nStatus message: ' +
					output.error_message
			);
			return;
		}

		const latLng = output.results[0].geometry.location;
		document.getElementById('map_latitude').value = latLng.lat;
		document.getElementById('map_longitude').value = latLng.lng;

		mapResize();
	};

	xmlhttp.open('GET', url, true);
	xmlhttp.send();
}
