<?php
/**
 * All public facing functions
 */
namespace WPPlugines\Product_View_Count\App;
use Codexpert\Plugin\Base;
use WPPlugines\Product_View_Count\Helper;
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author WPPlugines <hi@wpplugines.io>
 */
class Front extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	public function add_admin_bar( $admin_bar ) {
		if( ! current_user_can( 'manage_options' ) ) return;

		$admin_bar->add_menu( [
			'id'    => $this->slug,
			'title' => $this->name,
			'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
			'meta'  => [
				'title' => $this->name,            
			],
		] );
	}

	public function head() {}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'PVC_DEBUG' ) && PVC_DEBUG ? '' : '.min';

		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/front{$min}.css", PVC ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/front{$min}.js", PVC ), [ 'jquery' ], $this->version, true );
		
		$localized = [
			'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
			'_wpnonce'	=> wp_create_nonce(),
		];
		wp_localize_script( $this->slug, 'PVC', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function shop_loop_item() {

		$display = Helper::get_option( 'product-view-count_basic', 'display_view_count' );

		if ( in_array( 'shop', $display ) ) {
			global $product;

			// Get the current product ID.
	 		$product_id = $product->get_id();

	 		// Get the current view count for the product.
	 		$view_count = get_post_meta( $product_id, 'product_view_count', true );

	 		// If the view count is empty, set it to 0.
	 		if ( empty( $view_count ) ) {
		        $view_count = 0;
		    }

		    printf( '<div id="product-view-count-panel"><span class="product-view-count">%s %d</span></div>', __( 'Views: ', 'product-view-count' ), esc_html( $view_count ) );
		}
	}

	public function product_view_count() {

		// Get the current product ID.
	    $product_id = get_the_ID();

	    // Get the current view count for the product.
	    $view_count = get_post_meta( $product_id, 'product_view_count', true );

	    // If the view count is empty, set it to 0.
	    if ( empty( $view_count ) ) {
	        $view_count = 0;
	    }

	    // Increment the view count by 1.
	    $view_count++;

	    // Update the view count meta data.
	    update_post_meta( $product_id, 'product_view_count', $view_count );
	}

	public function display_product_view_count() {

		$display = Helper::get_option( 'product-view-count_basic', 'display_view_count' );

		if ( in_array( 'single', $display ) ) {

			global $post;

		    // Get the current post ID.
		    $post_id = $post->ID;

		    // Get the current view count for the product.
		    $view_count = get_post_meta( $post_id, 'product_view_count', true );

		    // If the view count is empty, set it to 0.
		    if ( empty( $view_count ) ) {
		        $view_count = 0;
		    }

		    // Display the view count.
		    echo '<p class="product-view-count">'. __( 'Views: ', 'product-view-count' ) .' ' . esc_attr( $view_count ) . '</p>';
		}
	}

	public function modal() {
		echo '
		<div id="product-view-count-modal" style="display: none">
			<img id="product-view-count-modal-loader" src="' . esc_attr( PVC_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}