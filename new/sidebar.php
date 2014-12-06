<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div id="secondary">
	<p></p>
<?php

	// ブランドページ、商品ページ
	if(is_singular('brand') || is_singular('product') || is_tax('product-tag')) {
		// URL末尾の「?page_type=」で設定された値を取得
		parse_str($_SERVER['QUERY_STRING'], $strs);
		if(count($strs) > 0)
			$pageType = $strs['page_type'];

		// ブランド名を取得
		if(is_singular('product') || is_singular('brand')) {
			$brandName = getBrandName();
		}
		if(is_tax( 'product-tag' )) {
			$brandName = get_field('select_brand-tag_in_product-tag', 'product-tag_' . $wp_query->get_queried_object()->term_id);
		}
		
		// ブランドの記事一覧ページ
		if(is_singular('brand') && $pageType == 'news') {
		
		    // 記事を取得
		    $args = array( 
		        'numberposts' => 100,           	// 記事数
		        'post_type' => array( 'brand' ),    // 投稿タイプ
		    );
		    $customPosts = get_posts($args);
		    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
		    	the_title(, , false);
		    endforeach; endif;
		
		// ブランドの記事一覧ページ以外
		} else {

			// ブランドの説明ページへのリンク
			echo '<a href="../../brand/', $brandName, '?page_type=description	"><b>', $brandName, 'とは</b></a><br>';

			// 新着記事へのリンク
			echo '<a href="../../brand/', $brandName, '?page_type=news	"><b>NEWS</b></a><br>';

			// ブランドの商品一覧ページへのリンク
			echo '<a href="../../brand/', $brandName, '?page_type=products"><b>PRODUCTS</b></a><br>';

			// 商品カテゴリを表示
			// 最上層の商品カテゴリを取得
			$args = array(
				'orderby' 	=> 'name',
				'order'		=> 'ASC',
				'get'		=> 'all',
				'parent'	=> 0,
			);
			$terms = get_terms( 'product-tag', $args );
			if(count($terms) > 0) {
				foreach ( $terms as $term ) {
					// 商品カテゴリに付いたブランドタグが商品のブランド名と一致するもののみ処理
					if( get_field('select_brand-tag_in_product-tag', 'product-tag_' . $term->term_id) == $brandName) {

						// 最上層の商品カテゴリのリンクを設置
						echo '　<a href="', get_term_link($term), '">', $term->name, '</a><br>';
						// 子の商品カテゴリを取得してリンクを設置
						$args['parent'] = (int)$term->term_id;
						$cTerms = get_terms( 'product-tag', $args );
						if(count($cTerms) > 0)
							foreach ( $cTerms as $cTerm )
								echo '　　', '<a href="' . get_term_link( $cTerm ) . '">' . $cTerm->name . '</a>', '<br>';
					}
				}
			}
			echo 'SHOP LIST';
		}

	// ブランドページ・商品ページ以外
	} else {
		// トップページ以外
		if ( !is_home() && !is_front_page() ) : ?>
			<b>NEWS</b><br>
			<b>CATEGORY</b><br>
		<?php endif; ?>

		<!-- 各ブランドのリンク -->
	    <?php $args = array(
	        'numberposts' => 100,                //表示（取得）する記事の数
	        'post_type' => array( 'brand' ),    //投稿タイプの指定
	    );
	    $customPosts = get_posts($args);
	    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); 
	    	echo '　';
	    ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><br>
	    <?php endforeach; ?>

			<?php if ( !is_home() && !is_front_page() ) : ?>
				<?php echo '　'; ?>
				<a href="<?php echo home_url("information"); ?>">INFORMATION</a><br>
				<?php echo '　'; ?>
				<a href="<?php echo home_url("media"); ?>">MEDIA</a><br>
			<?php endif; ?>

	    <?php endif; ?>
	<?php } ?>
    <?php wp_reset_postdata(); //クエリのリセット ?>

</div><!-- #secondary -->
