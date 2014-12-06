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
	     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <div class="page-title">
               <h1><?php the_title(); ?></h1>
          </div>
          
          <article class="container">
               <div class="author row">
                    <div class="col span_9">
						<?php echo get_the_date("Y.n.j"), '　'; ?>
						<?php printTags($POST->ID, true); ?>
                    </div>
                    <div class="col span_3 author-img"><?php the_post_thumbnail(); ?></div>
					<p></p>
               </div>
               <!-- /.row -->
               
               <div class="row team-content">
                    <?php the_content(); ?>
               </div>
               <!-- /.row -->
          </article>
          <!-- /.container -->
          <?php endwhile; endif; ?>
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

