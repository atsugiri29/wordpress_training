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
			    // 記事を取得して表示
			    $args = array(
			        'numberposts' => 20, // 表示する記事の数
			        'post_type' => array( 'media', 'information' ), //投稿タイプを指定
			    );
			    $customPosts = get_posts($args);
			    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
			    	printPost();
			    endforeach;
	?>
			</ul>
		    <?php else : //記事が無い場合 ?>
		        <li><p>記事はまだありません。</p></li>
		    <?php endif;
			wp_reset_postdata(); //クエリのリセット ?>
		</td></tr></table>



	</div><!-- #content -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

