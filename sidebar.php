<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mway
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="frontpage-widget-area" class="widget-area frontpage-widgets">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #frontpage-widget-area-->
