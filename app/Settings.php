<?php
/**
 * All settings related functions
 */
namespace WPPlugines\Product_View_Count\App;
use WPPlugines\Product_View_Count\Helper;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

/**
 * @package Plugin
 * @subpackage Settings
 * @author WPPlugines <hi@wpplugines.io>
 */
class Settings extends Base {

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
	
	public function init_menu() {
		
		$site_config = [
			'PHP Version'				=> PHP_VERSION,
			'WordPress Version' 		=> get_bloginfo( 'version' ),
			'WooCommerce Version'		=> is_plugin_active( 'woocommerce/woocommerce.php' ) ? get_option( 'woocommerce_version' ) : 'Not Active',
			'Memory Limit'				=> defined( 'WP_MEMORY_LIMIT' ) && WP_MEMORY_LIMIT ? WP_MEMORY_LIMIT : 'Not Defined',
			'Debug Mode'				=> defined( 'WP_DEBUG' ) && WP_DEBUG ? 'Enabled' : 'Disabled',
			'Active Plugins'			=> get_option( 'active_plugins' ),
		];

		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => "{$this->name} v{$this->version}",
			'header'        => $this->name,
			// 'parent'     => 'woocommerce',
			// 'priority'   => 10,
			// 'capability' => 'manage_options',
			// 'icon'       => 'dashicons-wordpress',
			// 'position'   => 25,
			// 'topnav'	=> true,
			'sections'      => [
				'product-view-count_basic'	=> [
					'id'        => 'product-view-count_basic',
					'label'     => __( 'Settings', 'product-view-count' ),
					'icon'      => 'dashicons-admin-tools',
					// 'color'		=> '#4c3f93',
					'sticky'	=> false,
					'fields'    => [
						'views_text' => [
							'id'        => 'views_text',
							'label'     => __( 'Label', 'product-view-count' ),
							'type'      => 'text',
							'default'   => __( 'View', 'product-view-count' ),
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'display_view_count' => [
							'id'      => 'display_view_count',
							'label'     => __( 'Display View Count', 'product-view-count' ),
							'type'      => 'checkbox',
							'options'   => [
								'shop'  	=> __( 'Shop Page', 'product-view-count' ),
								'single' 	=> __( 'Single Page', 'product-view-count' ),
								'admin'  	=> __( 'Admin Product Column', 'product-view-count' ),
							],
							'default'   => [ 'shop', 'single', 'admin' ],
							'disabled'  => false, // true|false
							'multiple'  => true, // true|false
						],
					]
				],
				'product-view-count_tools'	=> [
					'id'        => 'product-view-count_tools',
					'label'     => __( 'Tools', 'product-view-count' ),
					'icon'      => 'dashicons-hammer',
					'sticky'	=> false,
					'fields'    => [
						'report' => [
							'id'      => 'report',
							'label'     => __( 'Report', 'product-view-count' ),
							'type'      => 'textarea',
							'desc'     	=> '<button id="product-view-count_report-copy" class="button button-primary"><span class="dashicons dashicons-admin-page"></span></button>',
							'columns'   => 24,
							'rows'      => 10,
							'default'   => json_encode( $site_config, JSON_PRETTY_PRINT ),
							'readonly'  => true,
						],
					]
				],
			],
		];

		new Settings_API( $settings );
	}
}