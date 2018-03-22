<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mway
 */

if ( ! function_exists( 'mway_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function mway_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'on %s', 'post date', 'mway' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'mway_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function mway_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s ', 'post author', 'mway' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'mway_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function mway_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'mway' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				// TKi: Move to a separate function below this function. 
				// printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mway' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mway' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				// TKi: Moved to a separate function below this function
				// printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mway' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mway' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'mway' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
    );
    
    
		if ( !is_singular() ) { ?>
      <span class="continue-reading">
      <?php
      $read_more_link = sprintf(
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
      );
      ?>
      <a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">
        <?php echo $read_more_link; ?>
      </a>
    </span><!-- .continue-reading -->
    <?php 
    }

	}
endif;

/** 
 * 
 * Displays the category list for a post
 * This is used on content.php
 */
function mway_the_category_list() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ' ', 'mway' ) );
	if ( $categories_list ) {
		/* translators: 1: list of categories. */
		printf( '<span class="cat-links">' . esc_html__( 'in %1$s', 'mway' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}
}


/**
 * 
 * Displays the tags for a post
 * This is used in content.php
 */
function mway_the_tag_list() {
	$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'mway' ) );
		if ( $tags_list ) {
		/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'mway' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}
}


if ( ! function_exists( 'mway_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function mway_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail('mway-featured-image'); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;

/**
 * 
 * Post navigation links in single posts (previous / next post)
 */

 function mway_post_navigation() {
   the_post_navigation( array(
    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'mway' ) . '</span> ' .
    '<span class="screen-reader-text">' . __( 'Next post:', 'mway' ) . '</span> ' .
    '<span class="post-title">%title</span>',
  'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'mway' ) . '</span> ' .
    '<span class="screen-reader-text">' . __( 'Previous post:', 'mway' ) . '</span> ' .
    '<span class="post-title">%title</span>',
   ));
 }