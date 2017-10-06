<?php
/**
 * Plugin Name:       Product feed manager Customisations
 * Description:       A handy little plugin to contain your theme customisation snippets.
 * Plugin URI:        https://github.com/Auke1810/wp-product-feed-manager-hacks
 * Version:           1.0.0
 * Author:            Auke Jongbloed
 * Author URI:        https://www.wpmarketingrobot.com/
 *
 * @package Product_feed manager_Customisations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 *
 */
function alter_feed_item( $attributes, $feed_id, $product_id ) {

	// The $attributes variable is an array that contains all the product data that goes into the feed. Each item
	// can be accessed by it's feed key. So if in the feed file an item has a key like 'description', you
	// can access that specific item by $attributes['description'].
	// The $feed_id (string) makes it possible to only edit a specific feed. You can find the id of a feed in the
	// url of the Feed Editor, right after id=.
	// The $product_id (string) makes it possible to select a specific product id that you want to filter.
	
	// The following example only changes the data of a feed with ID 7
	if( $feed_id === '7' ) {
		
		// this line changes the title data and removes the " <prompt> " string
		$attributes['title'] = str_replace( " <prompt> ", "", $attributes['title'] );
		
		// this lines puts the text Dollar behind the price data
		$attributes['price'] = $attributes['price'] . " Dollar";
		
		// And you can be more specific by using the $product_id
		if ( $product_id === '13' ) {
			$attributes['availability'] = 'unknown';
		}
	}
	
	// or you can just make a simple change that will influence all feeds
	// If you have shortcodes in your product description you can remove them with het next code
	// Remove WordPress shortcodes from Description
	$attributes['description'] = strip_shortcodes( $attributes['description'] );
	
	// If you use VIdual Composer markup in your product descrioptions you can remove Visual Composer markup with the next code.
	$attributes['description'] = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $attributes['description'] );
	
	// IMPORTANT! Always return the $attributes
	return $attributes;
}

add_filter( 'wppfm_feed_item_value', 'alter_feed_item', 10, 3 );
