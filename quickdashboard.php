<?php
/**
 * Plugin Name: Quickdashboard
 * Description: Quickdashboard enables a custom wp-admin dashboard for certain users.
 * Plugin URI:  https://qanva.tech/quickdashboard
 * Version:   		1.1.0
 * Author:      qanva.tech, ukischkel
 * Author URI:  https://qanva.tech/
 * Text Domain: quickdashboard
 * Domain Path: languages
*/
if ( ! defined( 'ABSPATH' ) ) exit; 

    $headerDescription = __( 'Quickdashboard enables a custom wp-admin dashboard for certain users.', 'quickdashboard' );
    $jsonDescription = __( 'Quickdashboard enables a custom dashboard. User will get a special dashboard when accessing the wp-admin area. From there they only can access the setting pages which are allowed. These rules are configured by an admin.', 'quickdashboard' );

	add_action( 'plugins_loaded', 'lade_sprachdatei_fuer_quick' );

		function lade_sprachdatei_fuer_quick() {
			$pfad = dirname( plugin_basename(__FILE__) ) . '/languages/';
			load_plugin_textdomain( 'quickdashboard', false, $pfad );
		} 
	
	### Konstanten für updater und communicater.php ###
	
	define( 'QUICKBOARDPLUGIN', 'quickdashboard' );
	define( 'QUICKBOARDPLUGINNAME', 'Quickdashboard' ); 
	define( 'QUICKBOARD', basename( __FILE__ ) );
	define( 'QUICKBOARDFOLDER',  plugin_basename(__FILE__) );
	define( 'QUICKBOARDPLUGINURL', plugin_dir_url( __FILE__ ) );
	define( 'QUICKBOARDVERSION', '1.1.0' );
	

	add_action( 'admin_init', 'quickboard_additional_custom_styles' );
	add_action( 'admin_footer', 'quickboard_remove_link_js' );
	

	/* User ID lesen */
	add_action( 'plugins_loaded', 'quickboard_get_current_user_id' );

	function quickboard_get_current_user_id(){
		define( 'QUICKCURRENTUSER', get_current_user_id() );
	}
	
		/* copy settings from Quickdashboard */
		if ( !get_option( 'custom_dash_setting_information' ) ) {
			add_option( 'custom_dash_setting_information', '' );
		}	

		if ( !get_option( 'custom_dash_design' ) ) {
			add_option( 'custom_dash_design', '' );
		}

		if ( !get_option( 'quick_custom_userid' ) ) {
			add_option( 'quick_custom_userid', [0] );
		}
	
		if('' == get_option( 'quick_custom_userid' )){
			update_option( 'quick_custom_userid', [0] );
		}

	/** who installes this plugin is super-admin **/
	function set_quick_super_admin(){
		if ( !get_option( 'quick_admin_userid' ) || ( '' == get_option( 'quick_admin_userid' ) ) )  {
			update_option( 'quick_admin_userid', QUICKCURRENTUSER );
		}
	}

		add_action( 'plugins_loaded', 'set_quick_super_admin' );
		
 
		function quick_add_link_to_admin_bar($admin_bar) {         
			$args = array(
					'parent' => '',
					'id'     => 'wtf-quick-custom-link',
					'title'  => 'Quickdashboard',
					'href'   => esc_url( admin_url( 'index.php?page=quickdashboard' ) ),
					'meta'   => false
				);
				$admin_bar->add_node( $args );       
		}
	
		/* Entfernen von Elementen in der Admin Bar */
		function quickboard_admin_bar_render($wp_admin_bar) {
			$wp_admin_bar->remove_node( 'wp-logo' );
			$wp_admin_bar->remove_menu('site-name');
			$wp_admin_bar->remove_menu( 'comments' );
			$wp_admin_bar->remove_menu( 'my-blogs' );
			$wp_admin_bar->remove_menu( 'appearance' );
			$wp_admin_bar->remove_menu( 'edit' );
			$wp_admin_bar->remove_menu( 'new-content' );
			$wp_admin_bar->remove_menu( 'updates' );
		}
		
		/** adding javascript with AJAX function **/
		function quickboard_makequickjavascript(){ 
			?>
			<script type="text/javascript" id="quickboardjs">
			jQuery( document ).ready( function(){
				var quickimgsrc = '<?php echo plugins_url( "/img/logo.svg", __FILE__ ); ?>';
				jQuery( '#wp-admin-bar-wtf-quick-custom-link a' ).html( '<img src="' + quickimgsrc + '">Quickdashboard' );
				if( jQuery( '.fs-notice' ).length >= 1 ){
					jQuery( '.fs-notice' ).remove();
				}
			<?php
				$taskproof = get_option( 'custom_dash_design' )[ 'taskbar' ] ?? 1;
				if( 1 == $taskproof ){
			?>
				jQuery( '.quicktaskitem' ).hover( function(){
					jQuery( '.quicktaskinfo' ).html( jQuery( this ).attr( 'data-info' ) );
					jQuery( '.quicktaskinfo' ).css( { 'left' : jQuery( this ).position().left + 40 + 'px', 'bottom' : '60px' } );
					jQuery( '.quicktaskinfo' ).show();
				}, function(){
					jQuery( '.quicktaskinfo' ).hide();
				});

				jQuery( '.quicktaskitem' ).each( function(){
					var siteURL = window.location.href.split( '/' );
					var urlPart = siteURL[ siteURL.length -1]; 
					if( urlPart == jQuery( this ).attr( 'href' ) ){
						jQuery( this ).children( 'span' ).css( 'background', 'limegreen' );
					}
				});
			<?php
				}
			?>
			});
			</script>
		<?php		
		}
		
		/** adding javascript to remove link **/
		function quickboard_remove_link_js(){ 
			?>
			<script type="text/javascript" id="quickboardlinkjs">
			jQuery( document ).ready( function(){
				jQuery( 'a[href="index.php?page=quickdashboard"]' ).remove();
				jQuery( 'a[href="admin.php?page=quickdashboard/quickdashboard.php"]' ).remove();
			});
			</script>
		<?php		
		}
		
		
		function quickboard_additional_custom_styles() {
			if ( '' != get_option( 'quick_custom_userid' ) ){
				if( in_array( QUICKCURRENTUSER, get_option( 'quick_custom_userid' ) ) ){
					wp_enqueue_style( 'quickboard-cdash', QUICKBOARDPLUGINURL . 'css/dashboard.css', 'all' );
					add_action( 'admin_bar_menu', 'quickboard_admin_bar_render',999 );
					add_action( 'admin_footer', 'quickboard_makequickjavascript' );
					add_action( 'admin_bar_menu', 'quick_add_link_to_admin_bar',999 );
				}
			}
		}
		
		/** adding CSS rules **/
		add_action( 'admin_head', 'quickboard_makequickcss' );

			function quickboard_makequickcss(){ 
				if( '' != get_option( 'quick_custom_userid' ) && in_array( QUICKCURRENTUSER, get_option( 'quick_custom_userid' ) ) ){?>
					<style id="makequickprocss" >
					<?php
						$ccss = get_option( 'custom_dash_design' );
						if( in_array( QUICKCURRENTUSER, get_option( 'quick_custom_userid' ) ) ){
							echo '#wpadminbar{display:block !important}';
							echo '#adminmenumain{display:none}';
							echo '#wpcontent{margin-left:0px}';
							echo 'li[id^="wp-admin-bar"]:not(#wp-admin-bar-wtf-quick-custom-link):not(#wp-admin-bar-my-account):not( [id=wp-admin-bar-logout] ):not( .quickalert ):not(#wp-admin-bar-edit-profile):not(#wp-admin-bar-qick-dashboard):not([id*=WPML_ALS]){display:none;	}';
							echo '.interface-interface-skeleton__header{position:relative;top:32px}';
							echo '.interface-interface-skeleton__sidebar{top:32px}';
							echo '#footer-left, #footer-upgrade{display:none}' . "\n";
						}
						if( !in_array( 'media-new.php', get_option( 'custom_dash_setting_information' ) ) ){
							echo 'a[href*="media-new.php"]:not( .quicktaskitem ):not( .qlinktext ){display:none;}' . "\n";
						}
						if( !in_array( 'post-new.php', get_option( 'custom_dash_setting_information' ) ) ){
							echo 'a[href*="post-new.php"]:not( .quicktaskitem ):not( .qlinktext ){display:none;}' . "\n";
						}
						if( !in_array( 'post-new.php?post_type=page', get_option( 'custom_dash_setting_information' ) ) ){
							echo 'a[href*="post-new.php?post_type=page"]:not( .quicktaskitem ):not( .qlinktext ){display:none;}' . "\n";
						}
						if( !in_array( 'plugin-install.php', get_option( 'custom_dash_setting_information' ) ) ){
							echo 'a[href*="plugin-install.php"]:not( .quicktaskitem ):not( .qlinktext ){display:none;}' . "\n";
						}
						$qbcolor = $ccss[ 'taskback' ] ?? '#23282d';
						$qsbbcolor =  $ccss[ 'taskspanback' ] ?? '#4D4D4D';
						$qbccolor = $ccss[ 'taskspancolor' ] ?? 'white';
						$qshbcolor = $ccss[ 'taskspanhover' ] ?? '#d3d3d3';
						$qshcbcolor = $ccss[ 'taskspanhoverc' ] ?? 'black';
						$qinfoback = $ccss[ 'taskinfoback' ] ?? '#d3d3d3';
						$qinfocolor = $ccss[ 'taskinfocolor' ] ?? 'black';
						echo '.quicktaskbar{background:' . $qbcolor . '}' . "\n";
						echo '.quicktaskbar a span{background:' . $qsbbcolor . ';color:' . $qbccolor . '}' . "\n";
						echo '.quicktaskbar a span:hover{background:' . $qshbcolor  . ';color:' . $qshcbcolor  . '}' . "\n";
						echo '.quicktaskinfo{background:' . $qinfoback  . ';color:' . $qinfocolor  . '}' . "\n";
					?>
					</style>
			<?php 
				}
			}


final class Qickdashboardmaker{
	const MINIMUM_PHP_VERSION = '7.0';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'quickboard_init' ) );
		add_action( 'admin_menu', array( $this,'quickboard_custom_register_menu' ) );
		add_action( 'current_screen', array( $this,'quickboard_custom_redirect_dashboard' ) );
		add_action( 'admin_init', array( $this, 'quickboard_css' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [$this,'quickdashboard_adddashlinks'], 10, 1 );
		add_action( 'admin_menu', [$this,'quickdashboard_settingmenue'] );
	}

	
		/** Link on Plugin page **/
		public function quickdashboard_adddashlinks( array $links ) {
   $url = get_admin_url() . 'options-general.php?page=' . basename( __DIR__ ) . '/' . basename( __FILE__ );
			$teamlinks = '<a href="' . $url . '" style="color:#39b54a;">' .  __( "Settings", "quickdashboard"  ) . '</a>';
			$links[ 'quick-info' ] = $teamlinks;
				return $links;
		}
			       
		/** settings page **/
		public function quickdashboard_settingmenue() {
			add_submenu_page( 'options-general.php', 'Quickdashboard', 'Quickdashboard', 'manage_options', __FILE__, [$this,'quickdashboard_settingpage'] );
		}

	public function quickdashboard_settingpage(){
		if( 1 == get_current_user_id() ){
			include_once 'admin/settings.php';
		}	
	}	

	public function quickboard_css(){
		/* Admin-Bar im Frontend abschalten */
		add_filter( 'show_admin_bar', '__return_false' );
	}	
	
	/* redirect to custom dashboard */
	public function quickboard_custom_redirect_dashboard() { 
    $screen = get_current_screen();	
		if ( '' != get_option( 'quick_custom_userid' ) ){
			if( $screen->base == 'dashboard' && in_array( QUICKCURRENTUSER, get_option( 'quick_custom_userid' ) )){
				 wp_redirect( admin_url( 'index.php?page=quickdashboard' ) );
			}
		}
	}

	public function quickboard_custom_register_menu() {
		add_dashboard_page( '', '', 'read', 'quickdashboard', array( $this, 'quickboard_create_dashboard' ) );
	}

	public function quickboard_create_dashboard() {
			include_once 'quick-back.php';
	}

	public function quickboard_init() {
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'quickboard_admin_notice_minimum_php_version' ) );
			return;
		}
	}
	

	public function quickboard_admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			__( '"%1$s" requires "%2$s" version %3$s or greater.', 'quickdashboard' ),
			'<strong>' . __( 'Quickdashboard', 'quickdashboard' ) . '</strong>',
			'<strong>' . __( 'PHP', 'quickdashboard' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}
new Qickdashboardmaker();

	add_action( 'plugins_loaded', 'quickboard_check_for_url' );

	function quickboard_check_for_url(){
		if( '' != get_option( 'quick_custom_userid' ) && in_array( QUICKCURRENTUSER, get_option( 'quick_custom_userid' ) ) ){
			$userlinks = get_option( 'custom_dash_setting_information' ) ?? [];
			$fakepage = [];
			if( !empty( $userlinks ) && 0 != QUICKCURRENTUSER ){
				foreach( $userlinks[ QUICKCURRENTUSER ] AS $key => $val ){
					if( isset( $_GET[ 'page' ] ) && stripos( $val[ 2 ], $_GET[ 'page' ] ) === false  && stripos( 'profile', $_GET[ 'page' ] ) === false && stripos( 'quickdashboard', $_GET[ 'page' ] ) === false ) {
						$fakepage[] = $_GET[ 'page' ];
					}
					if( !isset( $_GET[ 'page' ] ) && !isset( $_GET[ 'post' ] ) ){
						if( stripos( $_SERVER[ 'REQUEST_URI' ], $val[ 2 ] ) === false && stripos( $_SERVER[ 'REQUEST_URI' ], 'profile.php' ) === false ){
							$fakepage[] = stripos( $_SERVER[ 'REQUEST_URI' ], $val[ 2 ] );
						}
					} 
				} 
					if( count( $fakepage ) == count( $userlinks[ QUICKCURRENTUSER ]  ) ){ 
						add_action( 'admin_notices', 'quickboard_admin_fakepage' );
					}
			}
		}
	}
	
	function quickboard_admin_fakepage(){
		echo '<style>div[class="wrap"], #screen-meta-links{visibility:hidden}#wpadminbar a.ab-item, .ab-top-menu li:hover{color:black;background-color:#ccc !important;}.quickalert{background: white;height: 47px;border: 1px solid lightgrey;border-left: 4px solid red;padding: 10px 20px;margin: 30px 0;}.block-editor{display:none}</style><div class="quickalert" style="display:block"><p>' . __( 'You are not allowed to visit this page!', 'quickdashboard' ) . '</p></div>';
		exit;
	}

	function quickboard_uninstall(){
		delete_option( 'custom_dash_setting_information' );
		delete_option( 'custom_dash_design' );
		delete_option( 'quick_custom_userid' );
	}
	
