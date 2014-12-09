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
		have_posts(); // この行がないと記事が表示されない不具合。原因不明

		// URL末尾の「?page_type=」で設定された値を取得
		parse_str($_SERVER['QUERY_STRING'], $strs);
		if(count($strs) > 0)
			$pageType = $strs['page_type'];
		if($pageType == 'description') {

			// ブランド説明のページ
			if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
	        <div class="page-title">
	             <h1><?php the_title(); echo 'とは'; ?></h1>
	        </div>
	        <article class="container">
				<?php the_content(); ?>
			</article>
<?php
			endwhile; endif;
			wp_reset_postdata();
		} else if($pageType == 'news') {

			// ブランドの記事一覧のページ
			echo '<h1>'; the_title(); echo '</h1><p></p>';
?>
			<ul>
<?php
//				$paged = get_query_var('paged')? get_query_var('paged') : 1;
				// 記事を取得して表示
				$args = array(
				    'post_type' => array( 'media', 'information' ),
				    'posts_per_page' => 2,
				    'paged' => $paged,
				    'tax_query' => array(
						array(
							'taxonomy' => 'brand-tag',
							'field' => 'slug',
							'terms' => getBrandName(),
						)
					)
				);
				$loop = new WP_Query($args);
				if ( $loop->have_posts() ) : while($loop->have_posts()) : $loop->the_post();
					printPost();
				endwhile; endif;
/*
// メインクエリの抽出件数によって表示されるページを超えたページへ移動しようとするとリダイレクトが起こって1ページ目に戻されるらしい
// functions.phpのmy_disable_redirect_canonicalでリダイレクトを抑制して応急対処しているが、このままで問題ないかも
				// 内部データ確認用
				echo $paged, '<br>';
				echo $wp_query->found_posts, '<br>';
				echo $loop->found_posts;
*/
				wp_pagenavi(array('query' => $loop));
				wp_reset_postdata();
?>
			</ul>
<?php
 		} else if($pageType == 'products') {

			// ブランドの商品一覧のページ
			echo '<h1>製品一覧</h1><p></p>';
			// 最上層の商品カテゴリを取得
			$args = array(
				'orderby' 	=> 'name',
				'order'		=> 'ASC',
				'get'		=> 'all',
				'parent'	=> 0,
			);
			$terms = get_terms( 'product-tag', $args );
			if(count($terms) > 0) {
				$brandName = getBrandName();

				// 最上位の商品カテゴリのリンクを設置
				foreach ( $terms as $term )
					// 現在のブランドの商品カテゴリのみ処理
					if( get_field('brand-tagOfProduct-tag', 'product-tag_' . $term->term_id) == $brandName)
						echo '<a href="', get_term_link($term), '">', $term->name, '</a>　';
				
				// 各商品カテゴリの商品を表示
				foreach ( $terms as $term ) {
					// 現在のブランドの商品カテゴリのみ処理
					if( get_field('brand-tagOfProduct-tag', 'product-tag_' . $term->term_id) == $brandName) {
						printProducts($term);
					}
				}
			}
		} else {
			// ブランドのトップページ
			if ( have_posts() ) : while ( have_posts() ) : the_post();
	?>
				<div class="page-title">
				     <h1><?php the_title(); echo 'とは'; ?></h1>
				</div>

				<article class="container">
				    <div>
				        <div class="col span_3 author-img"><?php the_post_thumbnail(); ?></div>
	  	                <div class="col span_9">
	<?php if(get_post_meta($post->ID, '画像1', true)): ?><a href="<?php $Image = wp_get_attachment_image_src(get_post_meta($post->ID, '画像1', true), 'full'); echo $Image[0]; ?>" class="lightbox"><?php echo wp_get_attachment_image(get_post_meta($post->ID, '画像1', true),'custom_size'); ?></a><?php else : ?><?php endif; ?>
		                </div>
               		</div>
		            <!-- /.row -->
               
		            <div>
		                 <?php the_excerpt(); ?>
		                 <p></p>
		                 <?php echo'<a href=".', '?page_type=description">>READ MORE</a><br>'; ?>
		            </div>
		            <!-- /.row -->
	            </article>
	            <!-- /.container -->

				<!-- 新着記事を取得して表示 -->
			    <h1><?php echo 'NEWS'; ?></h1>
				<ul>
<?php
					$args = array(
					    'post_type' => array( 'media', 'information' ),
					    'posts_per_page' => 3,
					    'tax_query' => array(
							array(
								'taxonomy' => 'brand-tag',
								'field' => 'slug',
								'terms' => getBrandName(),
							)
						)
					);
					$loop = new WP_Query($args);
					if ( $loop->have_posts() ) : while($loop->have_posts()) : $loop->the_post();
						printPost();
					endwhile; endif;
					wp_reset_postdata();
?>
				</ul>
				<p></p>
			    <h1><?php echo 'NEW ITEM'; ?></h1>
<?php
			endwhile; endif;
			wp_reset_postdata();
		}
?>
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

