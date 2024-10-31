<?php

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		
		/* eigene Scripte */
		wp_enqueue_style( 'jquery-ui-css',  plugins_url( '/css/jquery-ui.min.css', __FILE__ ), false, '', 'all' );
		wp_enqueue_style( 'basicpro-css',  plugins_url( '/css/basicpro.css', __FILE__ ), false, '', 'all' );
		wp_enqueue_style( 'quickboard-css',  plugins_url( '/css/quickboard.css', __FILE__ ), false, time(), 'all' );	
		wp_enqueue_script( 'quickpro-js', plugins_url( '/js/quickpro.js', __FILE__ ), array( 'jquery', 'wp-i18n' ), null, true );	
		wp_localize_script( 'quickpro-js', 'quick_strings', array( 
		'pluginpfad' => plugin_dir_url( __FILE__ ),
		'copy' => __( "Copy", "quickdashboard" ),
		'to' => __( "to", "quickdashboard" ),
		'alert' => __( "Please select a user first!", "quickdashboard" ),
		'draginfo' => __( "Drag and drop to sort", "quickdashboard" ),
		) );	
		
		global $menu;
		global $submenu;
		wp_enqueue_media();
		wp_enqueue_style( 'uikitcss', plugin_dir_url( __DIR__ ) . 'css/uikit.min.css', true, '3.6.3', 'all' );
		wp_register_script( 'quikitjs', plugin_dir_url( __DIR__ ) . 'js/uikit.min.js', array(), '3.6.3', true );
		wp_enqueue_script('quikitjs');
		wp_register_script( 'uikiticons', plugin_dir_url( __DIR__ ) . 'js/uikit-icons.min.js', array(), '3.6.3', true );
		wp_enqueue_script('uikiticons');
		
		/** re-arrange arrays so they start with 0 counting up 1 **/
		$orgmenu = array_values( $menu );
		
		/** sanitize alle $_POST variables **/
		$cleanedpost = [];
		if ( isset( $_POST ) ) {
			foreach( $_POST AS $key => $val ){
				if( is_array( $val ) ){
					foreach( $val AS $keyb => $valb ){
      $valx = str_replace( '<br />', '*', $valb );
						$newval[ $keyb ] = sanitize_text_field( $valx ); 
					}
						$cleanedpost[ $key ] = $newval;
				}
				else{
     	$valx = str_replace( '<br />', '*', $val );
						$cleanedpost[ $key ] = sanitize_text_field( $valx );
				}
			}
		}
        
		/** Module löschen **/
		if ( isset( $cleanedpost[ 'quickuserdelete' ] ) ) {
			$isuserset = get_option( 'custom_dash_setting_information' );
			if( !empty( $isuserset ) ){
				unset( $isuserset[ $cleanedpost[ 'editquickuser' ] ] );
				update_option( 'custom_dash_setting_information', $isuserset );
			}

			$isuser = get_option( 'quick_custom_userid' );
			if( !empty( $isuser ) ){
				$userkey = array_keys( $isuser, $cleanedpost[ 'editquickuser' ] );
				unset( $isuser[ $userkey[ 0 ] ] );
				update_option( 'quick_custom_userid', $isuser );
		   }
		}   

	/** hole gespeicherten Admin **/
	if ( !empty( get_option( 'quick_admin_userid' ) ) ) {
		$dashadmin = get_option( 'quick_admin_userid' );
	}
	
	$addon = '';
	if ( isset( $_POST[ 'dashdesignsave' ] ) ) {
        $addon = '#tabs-3';
    }
	if ( isset( $_POST[ 'dashsubmit' ] ) || isset( $_POST[ 'quickuseredit' ] ) ) {
        $addon = '#tabs-1';
    }
?>

<div class="wrap">
<form id="dashform" method="post" action="">
<?php wp_nonce_field( 'dashsubmit', 'dashproofone' ); ?>
</form>
<form id="dashdesign" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) .'?page=quickdashboard/quickdashboard.php' . $addon;?>">
<?php wp_nonce_field( 'dashdesignsave', 'dashprooftwo' ); ?>
</form>

<?php

	/* Links speichern */
 if ( isset( $cleanedpost[ 'dashsubmit' ]  ) && wp_verify_nonce( $_POST[ 'dashproofone' ], 'dashsubmit' ) ) {
  $newarr = [];
		$suche = [ 'Ü','ü','Ö','ö', 'Ä', 'ä', 'ß', '*'  ];
		$ersatz = [ '&Uuml;','&uuml;','&Ouml;','&uuml;', '&Auml;', '&auml;', 'ss', '<br />' ];
		if( empty( $cleanedpost[ 'copyquickuser' ] ) ){
			if( isset( $cleanedpost[ 'quickuser' ] ) && !empty( $cleanedpost[ 'quickuser' ] )  ){
				$userid = $cleanedpost[ 'quickuser' ];
			}
				if ( isset( $cleanedpost[ 'saves' ] ) ) {
					foreach( $cleanedpost[ 'saves' ] AS $keyb => $valb ){
						$subarr = explode( '#', $valb );
						$subpart = [ 
																		str_replace( $suche, $ersatz, $subarr[ 0 ] ), 
																		str_replace( $suche, $ersatz, $subarr[ 1 ] ) ,
																		str_replace( $suche, $ersatz, $subarr[ 2 ] ) ,
																		str_replace( $suche, $ersatz, $subarr[ 3 ] ) ,
																		str_replace( $suche, $ersatz, $subarr[ 4 ] ) 
																	];
							$newarr[ $keyb ] =  $subpart;
					}
				}
		
				$new_arr = [];
				$old_arr = get_option( 'custom_dash_setting_information' );
					foreach( $newarr AS $key => $value ){
						$new_arr[] = $value;
					}
              
						if( !empty( $old_arr ) ){
								$old_arr[ $userid ] = $new_arr;
						}
						else{
								$old_arr = array( $userid => $new_arr );
						}

					update_option( 'custom_dash_setting_information', $old_arr );
                    
						$old_user = get_option( 'quick_custom_userid' );
						array_push( $old_user, $userid );
					 update_option( 'quick_custom_userid', $old_user );
		}
	}
	
	/* Änderung speichern */
if ( isset( $cleanedpost[ 'quickuseredit' ]  ) && wp_verify_nonce( $_POST[ 'dashproofone' ], 'dashsubmit' ) ) {
		$newarr = [];
			$suche = [ 'Ü','ü','Ö','ö', 'Ä', 'ä', 'ß', '*' ];
			$ersatz = [ '&Uuml;','&uuml;','&Ouml;','&uuml;', '&Auml;', '&auml;', 'ss', '<br />' ];
		if( empty( $cleanedpost[ 'copyquickuser' ] ) ){
			if( isset( $cleanedpost[ 'editquickuser' ] ) && !empty( $cleanedpost[ 'editquickuser' ] )  ){
				$userid = $cleanedpost[ 'editquickuser' ];
				if ( isset( $cleanedpost[ 'saves' ] ) ) { 
					foreach( $cleanedpost[ 'saves' ] AS $keyb => $valb ){
						$subarr = explode( '#', $valb );
						$subpart = [ 
                        str_replace( $suche, $ersatz, $subarr[ 0 ] ) ,
                        $subarr[ 1 ] ,
                        str_replace( $suche, $ersatz, $subarr[ 2 ] ) ,
                        str_replace( $suche, $ersatz, $subarr[ 3 ] ) ,
                        str_replace( $suche, $ersatz, $subarr[ 4 ] ) ];
							$newarr[ $keyb ] =  $subpart;
					}
				}
		
				$new_arr = [] ;
					foreach( $newarr AS $keys => $value ){
						$new_arr[] = $value;
					}
                    $old_arr = get_option( 'custom_dash_setting_information' );
                    
                    foreach( $old_arr AS $key => $val ){
                        if( $key == $userid ){
                            $old_arr[ $userid ] = $new_arr;
                        }
                    }
                    
					update_option( 'custom_dash_setting_information', $old_arr );
			}
		}
	}

	$dashsetting = '';
 if ( !empty( get_option( 'custom_dash_setting_information' ) ) ) {
   $dashsetting = get_option( 'custom_dash_setting_information' );
 }

	$dashusers = [];
	if ( !empty( get_option( 'quick_custom_userid' ) ) ) {
		$dashusers = get_option( 'quick_custom_userid' );
	}
	
	function quickboardpro_get_user( $dashusers, $dashadmin, $edit ){
		$optfeld = '';
		$alluser = get_users();
		if( 0 == $edit ){
			foreach( $alluser AS $key => $val ){
				if(  $val -> data -> ID != $dashadmin && $val -> data -> ID != get_current_user_id() ){
					if(in_array(  $val -> data -> ID , $dashusers )){
						$optfeld .= '<option value="' . $val -> data -> ID . '" style="color:red" disabled>' . $val -> data -> user_login . ' - ' . __( "This user got settings", "quickdashboard" ) . '!</option>';
					}
					else{
						$optfeld .= '<option value="' . $val -> data -> ID . '">' . $val -> data -> user_login . '</option>';
					}
				}
			}
		}
		if( 1 == $edit ){
			foreach( $alluser AS $key => $val ){
				if(  $val -> data -> ID != $dashadmin && in_array( $val -> data -> ID, $dashusers ) && $val -> data -> ID != get_current_user_id() ){
					$optfeld .= '<option value="' . $val -> data -> ID . '">' . $val -> data -> user_login . '</option>';
				}
			}
		}
		return $optfeld;
	}
 
?>
<input type="hidden" id="quickproof" value='<?php echo json_encode( $dashsetting, JSON_HEX_TAG ); ?>' />
<?php 

    include_once 'html.php';

?>

</div><!-- Ende wrap -->
