<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php /*
<div id="secondary">
	<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( ! empty ( $description ) ) :
	?>
	<h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<nav role="navigation" class="navigation site-navigation secondary-navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
	</nav>
	<?php endif; ?>

	<?php // if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php // dynamic_sidebar( 'sidebar-1' ); ?>
		
	</div><!-- #primary-sidebar -->
	<?php // endif; ?>
*/ ?>

</div><!-- #secondary -->
	<div>
		<p></p>
		<ul>
			<?php if ( !is_home() && !is_front_page() ) : ?>
				NEWS<br>
				CATEGORY<br>
			<?php endif; ?>

			<!-- 各ブランドのリンク -->
		    <?php $args = array(
		        'numberposts' => 100,                //表示（取得）する記事の数
		        'post_type' => array( 'brand' ),    //投稿タイプの指定
		    );
		    $customPosts = get_posts($args);
		    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); 
		    ?>
				<b><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></b><br>
		    <?php endforeach; ?>

			<?php if ( !is_home() && !is_front_page() ) : ?>
				INFORMATION<br>
				MEDIA<br>
			<?php endif; ?>

		    <?php endif;
		    wp_reset_postdata(); //クエリのリセット ?>
		</ul>

	</div>
