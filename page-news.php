<!--
	全ブランドのニュースを表示するページ
-->

<?php get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="content" class="site-content" role="main">



		<!-- 新着記事を表示 -->
		<table><tr valign="top"><td>
			<h2>NEWS</h2>
			<ul>
<?php
// $paged = get_query_var('paged') ? get_query_var('paged') : 1 ; // pagedが固定ページで取得できない場合があるらしい
?>
<?php
	    	$loop = new WP_Query(array(
	    			'post_type' => array('information', 'media'),
				    'posts_per_page' => 2,
					'orderby' => 'modified',
				    'paged' => $paged,
			));
	    	if ( $loop->have_posts() ) : while($loop->have_posts()): $loop->the_post();
				printPost();
          	endwhile;
			wp_pagenavi(array('query' => $loop));
			wp_reset_postdata();
?>
			</ul>
		    <?php else : //記事が無い場合 ?>
		        <li><p>記事はまだありません。</p></li>
		    <?php endif; ?>

		</td></tr></table>



	</div><!-- #content -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

