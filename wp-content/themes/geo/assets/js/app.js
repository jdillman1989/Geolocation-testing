$(document).ready(function(){

	var display = $('.data-box');
	var inPlay = false;
	var locationData = {};

	if (display) {
		var nwlatRaw = display.data("nwlat"),
			nwlonRaw = display.data("nwlon"),
			selatRaw = display.data("selat"),
			selonRaw = display.data("selon"),
			gameID = display.data("id");

		var nwlat = parseFloat(nwlatRaw),
			nwlon = parseFloat(nwlonRaw),
			selat = parseFloat(selatRaw),
			selon = parseFloat(selonRaw);

		setInterval(function(){ getLocation(); }, 10000);
	}

	function getLocation() {
	    if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError);
	    }
	    else {
	        display.html("<p>Geolocation is not supported by this browser.</p>");
	    }
	}

	function showPosition(position) {
		var coords = position.coords.latitude + ", " + position.coords.longitude;
		var lat = parseFloat(position.coords.latitude);
		var lon = parseFloat(position.coords.longitude);

		if (lat < nwlat && lat > selat && lon > nwlon && lon < selon){

			if (!inPlay) {

				display.html("<p>Loading game data...</p>");
				$.ajax({
					type: 'POST',
					url: '/wp-admin/admin-ajax.php?action=play_area',
					data: {data:gameID},
					complete: function(response) {
						locationData = JSON.parse(response.responseText);
						setInterval(function(){
							navigator.geolocation.getCurrentPosition(watchLocations, showError);
						}, 2000);
					}
				});
				inPlay = true;
			}
		}
		else{
			inPlay = false;
		}

		if (!inPlay) {
			display.html("<p>Please move into this game's play area.<br> " + coords + "</p>");
		}
	}

	function watchLocations(position) {
		var lat = parseFloat(position.coords.latitude);
		var lon = parseFloat(position.coords.longitude);

		for (var i = 0; i <= locationData.coords.length-1; i++) {

			if (lat < locationData.coords[i].nw.lat && lat > locationData.coords[i].se.lat && lon > locationData.coords[i].nw.lon && lon < locationData.coords[i].se.lon){
				
				for (var n = 0; n <= locationData.data[locationData.coords[i].xref].length-1; n++) {
					
					if (locationData.data[locationData.coords[i].xref][n].coords == i) {
						display.html("<p>" + locationData.data[locationData.coords[i].xref][n].description + "</p>");
					}
				}
			}
		}
	}

	function showError(error) {
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            display.html("<p>User denied the request for Geolocation.</p>");
	            break;
	        case error.POSITION_UNAVAILABLE:
	            display.html("<p>Location information is unavailable.</p>");
	            break;
	        case error.TIMEOUT:
	            display.html("<p>The request to get user location timed out.</p>");
	            break;
	        case error.UNKNOWN_ERROR:
	            display.html("<p>An unknown error occurred.</p>");
	            break;
	    }
	}

	/**
	* is One Point within Another
	* @param point {Object} {latitude: Number, longitude: Number}
	* @param interest {Object} {latitude: Number, longitude: Number}
	* @param kms {Number}
	* @returns {boolean}
	*/

	// function withinRadius(point, interest, kms) {
	// 	'use strict';
	// 	let R = 6371;
	// 	let deg2rad = (n) => { return Math.tan(n * (Math.PI/180)) };

	// 	let dLat = deg2rad(interest.latitude - point.latitude);
	// 	let dLon = deg2rad(interest.longitude - point.longitude);

	// 	let a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(deg2rad(point.latitude)) * Math.cos(deg2rad(interest.latitude)) * Math.sin(dLon/2) * Math.sin(dLon/2);
	// 	let c = 2 * Math.asin(Math.sqrt(a));
	// 	let d = R * c;

	// 	return (d <= kms);
	// }
});