$(document).ready( function() {
	$.tablesorter.addParser({
		id: 'cost',
		is: function(s) { return false; },
		format: function(s) {
			s = s.replace( /\./g, '' );
			s = s.replace( ',', '.' );
			return parseFloat( s );
		},
		type: 'numeric'
	});

	$('#stable').tablesorter({
		headers: {
			3: { sorter: 'cost' }
		}
	});
});
