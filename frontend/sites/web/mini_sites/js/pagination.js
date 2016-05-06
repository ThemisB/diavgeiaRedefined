var pagination = { thema: [], type: [], signer: [] };
var pagination_limit = 10;
var pagination_buttons_reg = /btn_type_(\w+)_(\w+)/;
var site_url = '';

function init_pagination( ) {
	for ( var type in pagination ) {
		pagination[ type ][ 'from' ] = 0;
		pagination[ type ][ 'limit' ] = pagination_limit;
		toggle_pagination( type );
	}
}

function toggle_pagination( type ) {
	var index = type;
	var status_prev = ( pagination[ index ][ 'from' ] > 0 );
	var status_next = ( pagination[ index ][ 'from' ] + 
						pagination[ index ][ 'limit' ] 
						< pagination[ index ][ 'total' ] );
	$( '#btn_type_' + type + '_prev').attr( 'disabled', !status_prev );
	$( '#btn_type_' + type + '_next').attr( 'disabled', !status_next );
}

function ajax_pagination( type, mode ) {
	var url = site_url;
	url += '/get_items.php';
	var id = '#div_per_' + type;
	var index = type;
	var from = pagination[ index ][ 'from' ];
	var limit = pagination_limit;
	if ( mode == 'next' ) from += limit;
	else if ( mode == 'prev' ) from -= limit;
	else return;
	if ( from < 0 ) return;
	$.get( url, 
		   { type: type, from: from, limit: limit }, 
		   function( data ) {
				//$(id).html( data.html );
				$(id).fadeOut( 'fast', function() { 
					$(id).html( data.html );
					$(id).fadeIn( 'fast' );
				} );
				pagination[ index ][ 'from' ] = parseInt( data.pagination.from );
				pagination[ index ][ 'limit' ] = parseInt( data.pagination.limit );
				pagination[ index ][ 'total' ] = parseInt( data.pagination.total );
				toggle_pagination( type );
				equalize_height();
		   },
		   'json'
		);
		   
}

// Make all lists equal height
function equalize_height() {
	return;
	var max_height = 0;
	$('.per_type_list').each( function() {
		max_height = Math.max( max_height, $(this).height() );
	} );
	$('.per_type_list').each( function() {
		$(this).height( max_height );
	} );
}

$(document).ready(function() {
	init_pagination();
	$('.pagination_button').click( function( evt ) {
		var match = pagination_buttons_reg.exec( this.id );	
		if ( match.length != 3 ) return;
		ajax_pagination( match[ 1 ], match[ 2 ] );
	});
	equalize_height();

	var search_image = 'url(' + site_url + '/images/search.png' + ')';
	$('#global_search_btn').css( 'background-image', search_image );

	//$('.preview').fancybox({'type':'image'});
});
