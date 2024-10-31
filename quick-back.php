<?php
	require_once( ABSPATH . 'wp-load.php' );
	require_once( ABSPATH . 'wp-admin/admin.php' );
	require_once( ABSPATH . 'wp-admin/admin-header.php' );

	function quickboardpro_remove_footer_admin() {
		echo '';
	}
	 
	remove_filter( 'update_footer', 'core_update_footer' ); 
	add_filter( 'admin_footer_text', 'quickboardpro_remove_footer_admin');
	wp_enqueue_style( 'basicpro-css',  plugins_url( 'admin/css/basicpro.css', __FILE__ ), false, '', 'all' );
	wp_enqueue_style( 'quickboard-css',  plugins_url( 'admin/css/quickboard.css', __FILE__ ) );	
	
	$dasdesign = [];
	$dashsetting = [];
	
	if ( !empty( get_option( 'custom_dash_setting_information' ) ) ) {
		$dashsetting = get_option( 'custom_dash_setting_information' );
	}
	
?>
<div class="wrap about-wrap">
<?php
$activeuserid = get_current_user_id(); 
#	if(!empty($dashsetting)){
			function multi_array_search( $search_for, $search_in ) {
							if( '' != $search_in ){
						foreach ( $search_in as $element ) {
							if ( ( $element === $search_for ) || ( is_array( $element ) && multi_array_search( $search_for, $element ) ) ){
									return true;
							}
						}
							}
							return false;
			}
			if( multi_array_search( "edit.php", $dashsetting[$activeuserid] ) ){
				$comments_count = wp_count_comments();
				if( $comments_count->moderated > 0 ){
					echo '<div class="notice notice-info quickalert is-dismissible"><p>' . __( 'New comments', 'quickdashboardpro' ) . ': ' . $comments_count->moderated . '</p></div>';
				}
			}

    include "buttons.php"; 
#	}
?>

</div>