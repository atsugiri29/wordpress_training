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

<table cellpadding="0" cellspacing="0"><tbody>
<tr>
<td width="250">
<?php get_sidebar(); ?>
</td>
<td>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">



			<h2>NEWS</h2>
			<ul>
			    <?php $args = array(
			        'numberposts' => 5,                //表示（取得）する記事の数
			        'post_type' => array( /*'post',*/ 'media', 'information', 'product' ),    //投稿タイプの指定

			    );
			    $customPosts = get_posts($args);
			    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); ?>
						<div>
						<?php the_post_thumbnail(array(68,68)); ?>
						<?php echo get_the_date("Y.n.j"); ?>
						<br>

						<?php $tags = wp_get_post_tags( $post->ID ); ?>
						<?php for($cnt = 0; $cnt < count($tags); $cnt++) { ?>
							<?php echo $tags[$cnt]->name, " "; ?>
						<?php } ?>
						</div>

						<div>
						<u><b><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></b></u>
				<?php /*
					    <?php the_excerpt(); ?>
						<?php echo get_the_excerpt(); ?>
				*/ ?>
						<br>
						<?php echo mb_substr ( get_the_content() , 0, 150 ), "..."; ?>
						</div>
						<p></p>
				<?php /*
				        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				*/ ?>
				    <?php endforeach; ?>
			</ul>



			    <?php else : //記事が無い場合 ?>
			        <li><p>記事はまだありません。</p></li>
			    <?php endif;
    wp_reset_postdata(); //クエリのリセット ?>



		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

</td>
</tr>
</tbody></table>

<?php
// get_sidebar();
get_footer();
?>
