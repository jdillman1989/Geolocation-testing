$(document).ready(function(){

	var display = $('.data-box');
	var inPlay = false;

	if (display) {
		var nwlat = display.data("nwlat"),
			nwlon = display.data("nwlon"),
			selat = display.data("selat"),
			selon = display.data("selon"),
			gameID = display.data("id");
		setInterval(function(){ getLocation(); }, 10000);
	}

	function getLocation() {
	    if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(showPosition, showError);
	    } else {
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
						console.log(response.responseText);
						display.html("<p>" + response.responseText + "</p>");
						inPlay = true;
					}
				});
			}
		}
		else{
			inPlay = false;
		}

		if (!inPlay) {
			display.html("<p>Please move into this game's play area.<br> " + coords + "</p>");
		}
	}

	// function showPosition(position) {
	// 	var coords = position.coords.latitude + ", " + position.coords.longitude;
	// 	var lat = parseFloat(position.coords.latitude);
	// 	var lon = parseFloat(position.coords.longitude);
	// 	var displayText = false;

	// 	for (var i = 0; i <= mapData.length-1; i++) {

	// 		if (lat < mapData[i].location.nw.lat && lat > mapData[i].location.se.lat && lon > mapData[i].location.nw.lon && lon < mapData[i].location.se.lon){
	// 			displayText = "<p>" + mapData[i].label + ": <br>" + coords + "</p>";
	// 		}
	// 	}

	// 	if (displayText) {
	// 		display.html(displayText);
	// 	}
	// 	else{
	// 		display.html("<p>No info for this location.<br> " + coords + "</p>");
	// 	}
	// }

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