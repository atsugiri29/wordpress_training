<?php get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="content" class="site-content" role="main">



	<table><tr valign="top"><td>
 <?php have_posts(); // この行がないと記事が表示されない不具合。原因不明 ?>
 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div class="page-title">
           <h1><?php the_title(); ?></h1>
      </div>
      
      <article class="container">
           <div>
                <div class="col span_9">
<?php if(get_post_meta($post->ID, '画像1', true)): ?><a href="<?php $Image = wp_get_attachment_image_src(get_post_meta($post->ID, '画像1', true), 'full'); echo $Image[0]; ?>" class="lightbox"><?php echo wp_get_attachment_image(get_post_meta($post->ID, '画像1', true),'custom_size'); ?></a><?php else : ?><?php endif; ?>
	            </div>
	            <!-- サムネイル -->
				<div>
<?php
	             	for($count = 1; $count <= 3; $count++) {
					 	$thumbnail = wp_get_attachment_image_src(post_custom('画像' . $count),'thumbnail' );
					 	if(strlen($thumbnail[0]) > 0)
						 	echo '<img src="', $thumbnail[0], '" />';
					}
?>
	             </div>
	        </div>
			<!-- 説明文 -->
			<p />
			<div>
				<?php the_field('descriptionOfProduct'); ?>
			</div>
			<p />
            <div>
				<table>
<?php
					$price = get_field('priceOfProduct');
					if(strlen($price) > 0)
						echo '<tr><th>価格</th><td>', $price, '</td></tr>';
					$material = get_field('materialOfProduct');
					if(strlen($material) > 0)
						echo '<tr><th>素材</th><td>', $material, '</td></tr>';
					$color = get_field('colorOfProduct');
					if(strlen($color) > 0)
						echo '<tr><th>色</th><td>', $color, '</td></tr>';
					$size = get_field('sizeOfProduct');
					if(strlen($size) > 0)
						echo '<tr><th>サイズ</th><td>', $size, '</td></tr>';
					$remarks = get_field('remarksOfProduct');
					if(strlen($remarks) > 0)
						echo '<tr><th>備考</th><td>', $remarks, '</td></tr>';
?>
				</table>
            </div>
           <!-- /.row -->
      </article>
      <!-- /.container -->
<?php
		endwhile; endif;
		wp_reset_postdata();
?>
	</td></tr></table>



	</div><!-- #content -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

