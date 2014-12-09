<?php get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

<?php /*
	<div id="primary" class="content-area">
*/ ?>
		<div id="content" class="site-content" role="main">



		<table><tr valign="top"><td>
<?php
		echo '<h1>MEDIA</h1><br>';
    	$loop = new WP_Query(array(
    			'post_type' => 'media',
    			'posts_per_page' => 2,
				'orderby' => 'modified',
			    'paged' => $paged,
		));
    	if ($loop->have_posts()) : while($loop->have_posts()): $loop->the_post();
			printPost();
      	endwhile; endif;

		wp_pagenavi(array('query' => $loop));
		wp_reset_postdata(); //クエリのリセット
?>
 		</td></tr></table>



		</div><!-- #content -->
<?php /*
	</div><!-- #primary -->
*/ ?>
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

