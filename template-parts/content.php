<?php
/**
 * Template part for displaying single posts and index and archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mway
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!-- If archive page -->
<?php
  if ( !is_singular() ) { ?>
  <figure class="index-image">
    <?php mway_post_thumbnail(); ?>
  </figure>
  <?php 
  } ?>

<div class="post-content">
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

	<?php
		if ( 'post' === get_post_type() ) : ?> 
		<div class="entry-meta">
			<div class="entry-taxonomy">
			<?php
				mway_the_category_list();
				echo ' ';
				mway_the_tag_list();
			?>
			</div> <!-- .entry-taxonomy -->
			<div class="entry-author">
			<?php
				mway_posted_by();
				mway_posted_on();
			?>
			</div> <!-- .entry-author -->
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

  <?php
		if ( is_singular() ) :
			mway_post_thumbnail();
		endif;
		?>

	<div class="entry-content">
    <?php
        if ( is_singular() ) :
          the_content( sprintf(
            wp_kses(
              /* translators: %s: Name of current post. Only visible to screen readers */
              __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mway' ),
              array(
                'span' => array(
                  'class' => array(),
                ),
              )
            ),
            get_the_title()
          ) );
    
          wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mway' ),
            'after'  => '</div>',
          ) );
        else :
          the_excerpt();
        endif;
		?>
  </div><!-- .entry-content -->
    
	<footer class="entry-footer">
		<?php mway_entry_footer(); ?>
  </footer><!-- .entry-footer --> 
  
</div><!-- .post-content -->
</article><!-- #post-<?php the_ID(); ?> -->
