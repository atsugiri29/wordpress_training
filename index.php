<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

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



			<!-- 新着記事を表示 -->
			<table ><tr valign="top"><td>
			<h2>NEWS</h2>
			<ul>
<?php
			    // 記事を取得して表示
			    $args = array(
			        'numberposts' => 3, // 表示する記事の数
			        'post_type' => array( 'media', 'information' ), //投稿タイプを指定
					'orderby' => 'modified',
					'paged' => $paged,
			    );
			    $customPosts = get_posts($args);
			    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
			    	printPost();
			    endforeach;
/*
wp_pagenavi();
echo $wp_query->found_posts;
echo '<pre>', print_r($wp_query), '</pre>';
*/
?>
			</ul>
			    <?php else : //記事が無い場合 ?>
			        <li><p>記事はまだありません。</p></li>
			    <?php endif;
			wp_reset_postdata(); //クエリのリセット ?>

			</td></tr></table>


		<?php
/*
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
/*
					get_template_part( 'content', get_post_format() );

				endwhile;
				// Previous/next post navigation.
				twentyfourteen_paging_nav();

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
*/
		?>

		</div><!-- #content -->
<?php /*
	</div><!-- #primary -->
*/ ?>
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
