    var $ = jQuery;
	
$( document ).ready( function(){
    /** übergebener Pfad zum Plugin **/
				var pdpfad = quick_strings.pluginpfad;
		
		/** Quickboard Menue laden **/
		$( 'body' ).append( '<div class="quickmenu uk-background-primary"></div>' );
		function makequickmenu(){
			var linkarray = {};
			$( '[id^=toplevel_page_]' ).each( function(){
				if( !$( this ).hasClass( 'wp-has-submenu' ) ){
     var icon = $( this ).find( '.wp-menu-image' ).attr( 'class' ).split( ' ' )[ 2 ];
					Object.assign( linkarray, { [ $( this ).find( '.wp-menu-name' ).text() ] : [ $( this ).find( '.wp-menu-name' ).text() + '#' + $( this ).find( '.wp-menu-name' ).text() + '#' + $( this ).find( 'a' ).attr( 'href' ) + '#' + icon ] } );
				}
			});
			
			$( '.wp-submenu-wrap' ).each( function(){
				var data = [];
				var gruppe = $( this ).find( '.wp-submenu-head' ).text();
    var icon = $( this ).closest( 'li' ).find( '.wp-menu-image' ).attr( 'class' ).split( ' ' )[ 2 ];
					Object.assign( linkarray, { [ gruppe ] : [] } );
					$( this ).find( 'a' ).each( function(){
						var link =  $( this ).attr( 'href' );
						var name = $( this ).text();
						if( link.indexOf( 'quickdashboard' ) == -1 && '' != name ){
							data.push( gruppe + '#' + name + '#' + link + '#' + icon );
							Object.assign( linkarray, { [ gruppe ] : data } );
						}
					})
			})

			$.post( pdpfad + 'quickmenu.php', { alllinks : JSON.stringify( linkarray ) }, function( result ){
				$( '.quickmenu' ).html( result );
			});
		}
		
		makequickmenu();
			
		/** verzögert anzeigen **/
		$( '#quickprotabs' ).fadeIn( 1000, 'linear' );
		
		$( '#wpwrap' ).css( 'background-color', $( 'body' ).css( 'background-color' ) );
		
		/** Editieren abbrechen **/
		$( '.quickabort, #buttondesigntab, .submodnav' ).on( 'click', function(){
			$( '#adminmenuwrap' ).show( 500 );
			$( '.quickmenu' ).fadeOut( 500, 'linear' );
			$( 'select[name="quickuser"]' ).prop( 'selectedIndex', 0 );
			$( 'select[name="editquickuser"]' ).prop( 'selectedIndex', 0 );
			$( 'select[name="copyquickuser"]' ).prop( 'selectedIndex', 0 );
			$( 'select[name="targetuser"]' ).prop( 'selectedIndex', 0 );
			$( '.editinfo' ).fadeOut( 500 );
			$( '[name=dashsubmit]' ).fadeOut( 500 );
			$( '[name=quickuserdelete]' ).fadeOut( 500 );
			$( '.quickabort' ).fadeOut( 500 );
			$( '#quicksort' ).html( '' );
			$( '.quickinfo' ).html( '' );
			$( '.buttonedit' ).hide();
		});
		
		/** Button design anzeigen 	**/
		$( '.reiter' ).on( 'click', function(){
		$( '.quickvorschau' ).fadeOut( 500 );
		$( '#quickvorschauedit' ).fadeIn( 500 );
		});
		
		/** Vorschau anzeigen 	**/
		$( '.showbutton' ).on( 'click', function(){
		$( '.quickvorschau' ).fadeIn( 500 );
				$( '#adminmenuwrap' ).fadeIn( 500 );
				$( '.quickmenu' ).fadeOut( 500 );
		});		
		
		/** Min Breite Admin-Menu **/
		$( 'select[name="quickuser"], select[name="copyquickuser"], select[name="editquickuser"]' ).on( 'change', function(){
			if( $( 'body' ).hasClass( 'folded' ) ){
				$( 'body' ).removeClass( 'folded' );
			}
		});
			
		/** nach editieren Auswahl anderer User **/
		$( 'select[name="quickuser"]' ).on( 'change', function(){
			$( '.quickvorschau' ).html( '' );
			$( '.quickinfo' ).html( '' );
			$( '.buttonedit' ).hide();
			makequickmenu();
			if( $( 'select[name="quickuser"]' ).val() != '' ){
				$( '#adminmenuwrap' ).fadeOut( 500 );
				$( '.quickmenu' ).fadeIn( 500 );
				$( '.quickabort' ).fadeIn( 500 );
				$( '[name="dashsubmit"]' ).fadeIn( 500 );
				$( 'select[name="editquickuser"]' ).prop( 'selectedIndex', 0 );
				$( 'select[name="copyquickuser"]' ).prop( 'selectedIndex', 0 );
				$( 'select[name="targetuser"]' ).prop( 'selectedIndex', 0 );
				$( '.editinfo' ).fadeOut( 500 );
				$( '.copysave' ).fadeOut( 500 );
				$( '.saveinfo' ).fadeIn( 500 );
			}
		});	
		
		/** User kopieren **/
		$( 'select[name="copyquickuser"]' ).on( 'change', function(){
			$( '#quicksort' ).sortable( 'destroy' );
			$( 'select[name="quickuser"]' ).prop( 'selectedIndex', 0 );
			$( '#adminmenuwrap' ).fadeIn( 500 );
			$( '.quickmenu' ).fadeOut( 500 );
			$( '.editinfo' ).fadeOut( 500 );
			$( '.saveinfo' ).fadeOut( 500 );
			$( '.quickvorschau' ).html( '' );
			if( '' != $( 'select[name="copyquickuser"]' ).val() ){
				var toedit = JSON.parse( $( '#quickproof' ).val() );
				var edarray = toedit[ $( 'select[name="copyquickuser"]' ).val() ];
					var divid = 1;
					edarray.forEach( ( value, index ) => {
						$( '.quickforjs' ).each( function(){
							if( $( this ).val().indexOf( '#' + value[ 2 ] + '#' ) != -1 ){
								$( this ).prop( 'checked', true );
								var dataid = $( this ).attr( 'id' );
								var boxid = 'box-' + dataid.split( '-' )[ 1 ];
						if( '' == value[ 3 ] ){ 
							var infotxt = value[ 0 ] + '<br>' + value[ 1 ]; 
						}
						else{ 
							var infotxt = value[ 3 ];
							$( document ).find( $( 'input[value="' + value[ 0 ] + '#' + value[ 1 ] + '#' + value[ 2 ] + '#' + '"]' ) ).val( value[ 0 ] + '#' + value[ 1 ] + '#' + value[ 2 ] + '#' + value[ 3 ] ); 
						}
						$( '.quickvorschau' ).append( '<div id="' + divid + '" title="' + quick_strings.draginfo + '" data-id="' + dataid + '" data-group="' + value[ 0 ] + '" class="qlinkwrap" ><a><span data-id="' + dataid + '" class="quickspanedit toedit" >' + infotxt + '</span></a><input id="' + boxid + '" type="checkbox" name="saves[]"  value="' + $( this ).val() + '" form="dashform" autocomplete="off" class="quicksavecheckbox" checked="checked"></div>' );
						divid++;
							}
							else{
								return;
							}
						});
					});
						$( '.qlinkwrap' ).css( 'cursor', 'default' );
			}
		});
		
		$( 'select[name="targetuser"]' ).on( 'change', function(){
			if( '' != $( 'select[name="copyquickuser"]' ).val() && '' != $( 'select[name="targetuser"]' ).val() ){
				$( '.quickinfo' ).html( '<span class="quickcopy">' +quick_strings.copy + " " + $( 'select[name="copyquickuser"] option:selected' ).text() + " " + quick_strings.to + " " + $( 'select[name="targetuser"] option:selected' ).text() + '</span>' );
				$( '.copysave' ).fadeIn( 500 );
				$( '[name="dashsubmit"]' ).fadeIn( 500 );
				$( '.quickabort' ).fadeIn( 500 );
			}
			else{
				$( '.copysave' ).fadeOut( 500 );
				return;
			}
		});
				
		/** Buttons zufügen **/
		var divid = 0;
		$( document ).on( 'change', 'input[id^="dashs"]', function(){
			var infoarr = $( this ).val().split( '#' );
			var dataid = $( this ).attr( 'id' );
			var boxid = 'box-' + dataid.split( '-' )[ 1 ];
			if( $( this ).is( ':checked' ) ){
				$( '.quickvorschau' ).append( 
				'<div id="' + divid + '" title="' + quick_strings.draginfo + '" data-id="' + dataid + '" data-group="' + infoarr[ 0 ] + '" class="qlinkwrap ui-sortable-handle" ><a><span class="dashicons ' + infoarr[ 4 ] + '"></span><br><span data-id="' + dataid + '" class="quickspanedit" >' + infoarr[ 0 ] + '<br>' + infoarr[ 1 ] + '</span></a><input id="' + boxid + '" type="checkbox" name="saves[]"  value="' + infoarr[ 0 ] + '#' + infoarr[ 1 ] + '#' + infoarr[ 2 ] + '#' + infoarr[ 3 ] + '#' + infoarr[ 4 ] + '" form="dashform" autocomplete="off" class="quicksavecheckbox" checked="checked"></div>' );
				divid++;
			}
			else{
				$( 'div[data-id=' + dataid + '], span[data-id=' + dataid + ']' ).remove();
				divid--;
			}
		});
		
		/** Eingabefeld Button-Text **/
		$( document ).on( 'click', '.quickspanedit', function(){
			if( $( '.quickspanedit' ).hasClass( 'quicktoedit' ) ){
				return;
			}
			else{
				$( this ).addClass( 'quicktoedit' );
				var pageY = event.pageY;
				var pageX = event.pageX; 
				$( '.buttonedit' ).fadeIn();
				$( '.buttonedit' ).css( { 'top' : ( pageY + 40 ) + 'px', 'left' : ( pageX - 200 ) + 'px' } );
				if( $( this ).hasClass( 'toedit' ) ){
					$( '#buttontextedit' ).val( $( this ).html().replace( /\<br>/g, '\n' ) );
					$( '#buttontextedit' ).focus();
				}
				
			}
		});

		/** Eingabe säubern von ungewollten Zeichen  **/
		function cleaninput( value ){
			strvalue = value.toString();
			if( strvalue.indexOf( '#' ) >= 0 ){
				strvalue = value.replace( '#', ' ' );
			}
				strvalue = strvalue.replace( /<\/?[^>]+(>|$)/gi, '' );
				strvalue = strvalue.replace( /\n/g, '<br />' );
			return strvalue;
		}
		
		/** Text auf den Button schreiben **/
		$( '#buttontextedit' ).on( 'keyup', function(){
			var newinput = cleaninput( $( this ).val() );
			$( '.quicktoedit' ).html( newinput );
		});
		
		/** speichern des Text und löschen der Werte **/
		$( '#quickcloseedit' ).on( 'click', function(){
			if( '' != $( '.quicktoedit' ).attr( 'data-id' ) ){
				var thetarget = $( '.quicktoedit' ).attr( 'data-id' ).split( '-' )[ 1 ];
				var oldvalue = $( '#dashs-' + thetarget ).val().split( '#' );
				var newvalue = oldvalue[ 0 ] + '#' + oldvalue[ 1 ] + '#' +  oldvalue[ 2 ] + '#' +  $( '#buttontextedit' ).val().replace( /\n/g, '<br />' ) + '#' +  oldvalue[ 4 ];
				$( '#box-' + thetarget ).val( newvalue );
				$( '#buttontextedit' ).val( '' );
			}
			$( '.quickspanedit' ).each( function(){
				$( this ).removeClass( 'quicktoedit' );
			});
			$( '.buttonedit' ).fadeOut();
		});
		
		/** nach editieren Auswahl auf keiner **/
		$( 'select[name="editquickuser"]' ).on( 'change', function(){
			$( 'select[name="quickuser"]' ).prop( 'selectedIndex', 0 );
			if( $( 'select[name="editquickuser"]' ).val() == '' ){
				$( '.buttonedit' ).hide();
				$( '.editinfo' ).fadeOut( 500 );
				$( '.saveinfo' ).fadeOut( 500 );
				$( '.copysave' ).fadeOut( 500 );
				$( '[name=quickuserdelete]' ).fadeOut( 500 );
				$( '.quickinfo' ).html( '' );
				$( '.quickvorschau' ).html( '' );
				$( '#adminmenuwrap' ).fadeIn( 500 );
				$( '.quickmenu' ).fadeOut( 500 );
				makequickmenu();
			}
		});
		
		/** editieren **/
		$( 'select[name="editquickuser"]' ).on( 'change', function(){
			makequickmenu();
			$( 'select[name="quickuser"]' ).prop( 'selectedIndex', 0 );
			$( 'select[name="copyquickuser"]' ).prop( 'selectedIndex', 0 );
			$( 'select[name="targetuser"]' ).prop( 'selectedIndex', 0 );
			$( '.quickvorschau' ).html( '' );
			$( '.quickinfo' ).html( '' );
			$( '.saveinfo' ).fadeOut( 500 );
			$( '.copysave' ).fadeOut( 500 );
			if( '' != $( this ).val() ){
				var toedit = JSON.parse( $( '#quickproof' ).val() );
				var edarray = toedit[ $( this ).val() ];
				$( '#adminmenuwrap' ).fadeOut( 500 );
				$( '.quickmenu' ).fadeIn( 500 );
				$( '.quickabort' ).fadeIn( 500 );
				$( '[name=quickuserdelete]' ).fadeIn( 500 );
				$( '.editinfo' ).fadeIn( 500, function(){
					var divid = 1;
					edarray.forEach( ( value, index ) => {
						$( '.quickforjs' ).each( function(){
							if( $( this ).val().indexOf( '#' + value[ 2 ] + '#' ) != -1 ){
								$( this ).prop( 'checked', true );
								var dataid = $( this ).attr( 'id' );
								var boxid = 'box-' + dataid.split( '-' )[ 1 ];
						if( '' == value[ 3 ] ){ 
							var infotxt = value[ 0 ] + '<br>' + value[ 1 ]; 
						}
						else{ 
							var infotxt = value[ 3 ];
							$( document ).find( $( 'input[value^="' + value[ 0 ] + '#' + value[ 1 ] + '#' + value[ 2 ] + '#' + '"]' ) ).val( value[ 0 ] + '#' + value[ 1 ] + '#' + value[ 2 ] + '#' + value[ 3 ]+ '#' + value[ 4 ] ); 
						}
						var newval = value[ 0 ] + '#' + value[ 1 ] + '#' + value[ 2 ] + '#' + value[ 3 ]+ '#' + value[ 4 ];
						$( '.quickvorschau' ).append( '<div id="' + index + '" title="' + quick_strings.draginfo + '" data-id="' + dataid + '" data-group="' + value[ 0 ] + '" class="qlinkwrap ui-sortable-handle" ><a><span class="dashicons ' + value[ 4 ] + '"></span><br><span data-id="' + dataid + '" class="quickspanedit toedit" >' + infotxt + '</span></a><input id="' + boxid + '" type="checkbox" name="saves[]"  value="' + newval + '" form="dashform" autocomplete="off" class="quicksavecheckbox" checked="checked"></div>' );
						divid++;
						if( divid == 6 ){ divid = 1; }
							}
							else{
								return;
							}
						});
					});
				});
			}
		});

		
		$( 'select[name="editquickuser"], select[name="quickuser"], select[name="copyquickuser"], select[name="targetuser"]' ).on( 'change', function(){
			if( '' == $( 'select[name="editquickuser"]' ).val() && '' == $( 'select[name="quickuser"]' ).val() && '' == $( 'select[name="copyquickuser"]' ).val() && '' == $( 'select[name="targetuser"]' ).val() ){
				$( '#adminmenuwrap' ).fadeIn( 500 );
				$( '.quickmenu' ).fadeOut( 500 );
			}
		});

		setTimeout( function(){ $( '#protabs' ).css( { 'display' : 'block' } );}, 500 );

		
		/** Hinweise entfernen **/
		$( '[class*=notice]' ).each( function(){
			$( this ).remove();
		});
		
});