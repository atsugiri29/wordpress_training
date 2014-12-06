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
		echo '<h1>INFORMATION</h1><br>';
	    	$loop = new WP_Query(array("post_type" => "information"));
	    	if ( $loop->have_posts() ) : while($loop->have_posts()): $loop->the_post();
				printPost();
          	endwhile; endif; ?>
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

