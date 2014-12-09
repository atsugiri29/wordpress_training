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
<?php
		echo '<h1>INFORMATION</h1><br>';
    	$loop = new WP_Query(array(
    			'post_type' => 'information',
    			'posts_per_page' => 2,
				'orderby' => 'modified',
			    'paged' => $paged,
		));
    	if ($loop->have_posts()) : while($loop->have_posts()): $loop->the_post();
			printPost();
      	endwhile; endif;

/*
// メインクエリでアーカイブの記事がすでに抽出されているのではないか
// クエリを使う必要はないかも
		// 内部データ確認用
		echo $wp_query->found_posts, '<br>', $loop->found_posts;
*/
		wp_pagenavi(array('query' => $loop));
		wp_reset_postdata(); //クエリのリセット
?>
 		</td></tr></table>



		<?php // include("pager.php"); ?>
	
		</div><!-- #content -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

