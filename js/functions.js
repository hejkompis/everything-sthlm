/* jQuery-funktioner */

var root = window.location.origin;

$(document).ready(function() {
	
	$(document).on('click', '[data-type="confirm"]', function() {

		var message = $(this).attr('data-message');

		if(!confirm(message)) {
			return false;
		}

	});

});