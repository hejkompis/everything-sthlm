/* jQuery-funktioner */

var root = window.location.origin;

$(document).ready(function() {
	
	$(document).on('click', '[data-type="confirm"]', function() {

		var message = $(this).attr('data-message');

		if(!confirm(message)) {
			return false;
		}

	});

	$(function() {

		$( "#search-distance" ).slider({
			range: "min",
			min: 100,
			max: 10000,
			value: 10000,
			slide: function( event, ui ) {
				$( "#search-distance-input" ).val( ui.value );
				distance = distancePrinter(ui.value);
				$( "#search-distance-text" ).text( distance );
			}
		});

		$( "#search-distance-input" ).val( $( "#search-distance" ).slider( "value" ) );

	});

});

function distancePrinter(distance) {

	if(distance > 9999) {
		printed_distance = 'Ingen begränsning';
	}
	else if(distance < 10000 && distance > 999) {
		printed_distance = (distance / 1000).toFixed(1) + ' kilometer';
	}
	else {
		printed_distance = distance + ' meter';
	}

	console.log(distance);

	return printed_distance;

}