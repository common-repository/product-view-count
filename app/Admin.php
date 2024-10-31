<?php
/**
 * All admin facing functions
 */
namespace WPPlugines\Product_View_Count\App;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Metabox;
use WPPlugines\Product_View_Count\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author WPPlugines <hi@wpplugines.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'product-view-count', false, PVC_DIR . '/languages/' );
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {

		if( ! get_option( 'product-view-count_version' ) ){
			update_option( 'product-view-count_version', $this->version );
		}
		
		if( ! get_option( 'product-view-count_install_time' ) ){
			update_option( 'product-view-count_install_time', time() );
		}
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'PVC_DEBUG' ) && PVC_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", PVC ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", PVC ), [ 'jquery' ], $this->version, true );
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'settings'	=> sprintf( '<a href="%1$s">' . __( 'Settings', 'product-view-count' ) . '</a>', add_query_arg( 'page', $this->slug, $this->admin_url ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		
		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['help'] = '<a href="https://help.wpplugines.com/" target="_blank" class="cx-help">' . __( 'Help', 'product-view-count' ) . '</a>';
		}

		return $plugin_meta;
	}

	public function update_cache( $post_id, $post, $update ) {
		wp_cache_delete( "pvc_{$post->post_type}", 'pvc' );
	}

	public function footer_text( $text ) {
		if( get_current_screen()->parent_base != $this->slug ) return $text;

		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'product-view-count' ), $this->name, "https://wordpress.org/support/plugin/{$this->slug}/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐' );
	}

	public function modal() {
		echo '
		<div id="product-view-count-modal" style="display: none">
			<img id="product-view-count-modal-loader" src="' . esc_attr( PVC_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}

	public function product_columns( $columns ) {
	    $display = Helper::get_option( 'product-view-count_basic', 'display_view_count' );

	    // Check if $display is not an array or 'admin' is not in the array
	    if ( ! is_array( $display ) || ! in_array( 'admin', $display ) ) {
	        return $columns;
	    }

	    // Add the 'Views' column
	    $columns['view'] = __( 'Views', 'woocommerce' );

	    return $columns;
	}


	public function view_count_columns( $column, $product_id ) {
		if ( $column == 'view' ) {
	        $view_count = get_post_meta( $product_id, 'product_view_count', true );
	        echo esc_html( $view_count );
	    }
	}

	public function sortable_columns( $columns ) {
		$columns['view'] = 'product_view_count';
  		return $columns;
	}

	public function view_orderby( $query ) {
		if( ! is_admin() || ! $query->is_main_query() ) {
	    	return;
	  	}

	  	if ( 'product_view_count' === $query->get( 'orderby') ) {
	    	$query->set( 'orderby', 'meta_value' );
	    	$query->set( 'meta_key', 'product_view_count' );
	    	$query->set( 'meta_type', 'numeric' );
	  	}
	}
}