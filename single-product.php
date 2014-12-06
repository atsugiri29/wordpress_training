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
     <?php have_posts(); // この行がないと記事が表示されない不具合。原因不明 ?>
     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <div class="page-title">
               <h1><?php the_title(); ?></h1>
          </div>
          
          <article class="container">
               <div class="author row">
                    <div class="col span_9">
<?php if(get_post_meta($post->ID, '画像1', true)): ?><a href="<?php $Image = wp_get_attachment_image_src(get_post_meta($post->ID, '画像1', true), 'full'); echo $Image[0]; ?>" class="lightbox"><?php echo wp_get_attachment_image(get_post_meta($post->ID, '画像1', true),'custom_size'); ?></a><?php else : ?><?php endif; ?>
                    </div>
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

