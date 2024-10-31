<?php 

	
	echo '<div class="wtf-cdash-wrapper" id="wtf-cdash-wrapper">';

  $showlink = '';
		if( !empty( $dashsetting ) ){
			for( $i = 0; $i < count( $dashsetting[ $activeuserid ] ); $i++ ){
				$linktarget =  $dashsetting[ $activeuserid ][ $i ][ 2 ];
				if( '' == $dashsetting[ $activeuserid ][ $i ][ 3 ] ){
					$linkname = $dashsetting[ $activeuserid ][ $i ][ 0 ] . '<br>' . $dashsetting[ $activeuserid ][ $i ][ 1 ];
				}
				else{
					$linkname = $dashsetting[ $activeuserid ][ $i ][ 3 ];
				}
				
				$ucornot = $dashdesign[ 'fontconverting' ] ?? 0;
				
				$showlink .= '<div class="qlinkwrap" id="butt-' . $i . '" ><a href="' . $linktarget . '" class="qlinktext" ><span class="dashicons ' . $dashsetting[ $activeuserid ][ $i ][ 4 ] . '"></span><br>' . $linkname . '</a></div>';
   }
		}

  echo  $showlink;

					echo '</div>';
				
        ?>
	