<?php
	
		/** number generator **/
		$GLOBALS[ 'addproof' ] = [ 11 ];	
		function make_an_id(){
			$adder = ( count( $GLOBALS[ 'addproof' ] ) + 11 );
				$GLOBALS[ 'addproof' ][] = $adder;
					return $adder;
		}
		
	if ( isset( $_POST[ 'alllinks' ] ) ) {
		$menuliste = '<ul>';
			$links = json_decode( $_POST[ 'alllinks' ] );
				foreach( $links AS $key => $val ){
					$menuliste .= '<li class="menukat">' . 
												trim( preg_replace( '/[0-9]+/', '', $key ) ) . 
											'</li>';
					for( $i = 0; $i < count( $val ); $i++ ){
						$value = explode( '#', $val[ $i ] ); 
							$forid = make_an_id();
							$menuliste .= '<li><label for="dashs-' . $forid . '" class="clabel" data-id="' . 
								$value[ 0 ] .
								'"><input type="checkbox" name="dashs[]" id="dashs-' . $forid . '" value="' . 
								preg_replace( '/[0-9]+/', '', $value[ 0 ] ) . '#' .
								preg_replace( '/[0-9]+/', '', $value[ 1 ] ) . '#' .
								preg_replace( "/&#[a-z0-9]+;/i", '', strip_tags( $value[ 2 ] ) ) . '##' .
								$value[ 3 ] . 
								'" form="dashform" autocomplete="off" class="quickforjs">' . 
								preg_replace( '/[0-9]+/', '', $value[ 1 ] ) .
								'<span class="checkmark"></span></label></li>';
					}
				}
		$menuliste .= '</ul>';
		echo $menuliste;
    }



