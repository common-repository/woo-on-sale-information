<?php
/**
 * Plugin Name: WooCommerce On Sale Information
 * Plugin URI: https://gitlab.com/vanguardly/wordpress/woocommerce-onsale-information/
 * Description: Shows the sale end date on the product page. Works with simple and variable products.
 * Version: 1.1.2
 *
 * Author: Vanguardly (António Pinto)
 * Author URI: https://www.vanguardly.com/
 *
 * Text Domain: woocommerce-onsale-information
 * Domain Path: /languages
 *
 * WC requires at least: 3.1
 * WC tested up to: 3.7.0-rc.2
 **/

namespace VGY\WcOnSaleInformation;

/* Localization */
function load_textdomain() {
	load_plugin_textdomain( 'woocommerce-onsale-information' );
}

add_action( 'init', __NAMESPACE__ . '\\load_textdomain' );

/**
 * Check if WooCommerce is active - Get active network plugins
 * "Stolen" from Multibanco and MBWAY (IfthenPay gateway) for WooCommerce that "stole" from Novalnet Payment Gateway ;)
 *
 * @return array|bool
 */
function active_network_plugins() {
	if ( ! is_multisite() ) {
		return false;
	}

	$active_network_plugins = get_site_option( 'active_sitewide_plugins' ) ? array_keys( get_site_option( 'active_sitewide_plugins' ) ) : [];

	return $active_network_plugins;
}

/* If WooCommerce is active, add the actions. */
if ( in_array( 'woocommerce/woocommerce.php', (array) get_option( 'active_plugins' ), true )
     || in_array( 'woocommerce/woocommerce.php', (array) active_network_plugins(), true ) ) {

	add_filter( 'woocommerce_get_price_html', __NAMESPACE__ . '\\add_sale_end_date_to_product_price', 10, 2 );
	add_filter( 'woocommerce_variable_price_html', __NAMESPACE__ . '\\add_sale_end_date_to_product_price', 20, 2 );
}


/** @noinspection PhpUnused */
/**
 * @param string      $price_html
 * @param \WC_Product $product
 *
 * @return string Product Price HTML
 */
function add_sale_end_date_to_product_price( $price_html, $product ) {
	$sale_price = $product->get_sale_price();

	/**
	 * Skip if:
	 * - the product does not have a defined sale price;
	 * - the product is not on sale at this moment;
	 * - the product on the loop is not single or not a variation;
	 * - the sale start or end date is not defined;
	 */
	if (
		empty( $sale_price ) ||
		! $product->is_on_sale() ||
		! is_single()
	) {
		return $price_html;
	}

	/*
	 * Define the $output_content variable.
	 */
	$output_content = '';

	/**
	 * This defines the date format output.
	 * Defaults to the WordPress defined date format.
	 *
	 * @see http://php.net/manual/en/function.date.php
	 */
	$date_format = apply_filters( 'vgy_wcosi_date_format', get_option( 'date_format' ) );

	/**
	 * Defines the text to appear before the sale start and end date.
	 */
	$sale_from_text    = apply_filters( 'vgy_wcosi_sale_from_text', __( 'On sale from', 'woocommerce-onsale-information' ) );
	$sale_ends_on_text = apply_filters( 'vgy_wcosi_sale_ends_on_text', __( 'Sale ends on', 'woocommerce-onsale-information' ) );

	/**
	 * Set the css classes to output
	 */
	$wrapper_css_class   = apply_filters( 'vgy_wcosi_wrapper_css_class', 'vgy_wcosi_wrapper' );
	$sale_from_css_class = apply_filters( 'vgy_wcosi_sale_from_css_class', 'vgy_wcosi_sale_from_date' );
	$sale_end_css_class  = apply_filters( 'vgy_wcosi_sale_end_css_class', 'vgy_wcosi_sale_end_date' );

	if ( $product->get_date_on_sale_from() ) {
		$sale_from_date = date_i18n( $date_format, $product->get_date_on_sale_from()->getTimestamp() );
		$sale_from_html = '<div class="' . $sale_from_css_class . '">' . $sale_from_text . ' ' . $sale_from_date . '.</div>';

		$output_content .= $sale_from_html;
	}

	if ( $product->get_date_on_sale_to() ) {
		$sale_end_date = date_i18n( $date_format, $product->get_date_on_sale_to()->getTimestamp() );
		$sale_end_html = '<div class="' . $sale_end_css_class . '">' . $sale_ends_on_text . ' ' . $sale_end_date . '.</div>';

		$output_content .= $sale_end_html;
	}

	$output = '<div class="' . $wrapper_css_class . '">' . $output_content . '</div>';

	/**
	 * Returns and filters the output of the modified price_html.
	 */
	return apply_filters( 'vgy_wcosi_price_html', $price_html . $output );
}
