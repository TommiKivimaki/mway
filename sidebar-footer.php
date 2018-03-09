<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mway
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<aside id="footer-widget-area" class="widget-area footer-widgets">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->
