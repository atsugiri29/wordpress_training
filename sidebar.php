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

			if(is_singular('product') || is_tax( 'product-tag' ) || is_singular('brand') || is_post_type_archive('media') || is_post_type_archive('information')) {
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
				if(is_post_type_archive('media') || is_post_type_archive('information') || is_singular('brand') && $pageType == 'news') {

				    // URLを設定
				    if(is_post_type_archive('media') || is_post_type_archive('information'))
				    	$urlStr = '../';
				    else $urlStr = '../../';

					echo '<a href="', $urlStr, 'news"><b>NEWS</b></a><br>';
					echo '<b>CATEGORY</b><br>';

				    // 各ブランドの記事一覧へのリンク
				    // 記事を取得
				    $args = array(
				        'numberposts' => 100,           	// 記事数
				        'post_type' => array( 'brand' ),    // 投稿タイプ
				    );
				    
				    $customPosts = get_posts($args);
				    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
				    	echo '<a href="', $urlStr, 'brand/', the_title('', '', false), '?page_type=news	"><b>　', the_title('', '', false), '</b></a><br>';
				    endforeach; endif;

					// メディア・インフォメーション記事一覧へのリンク
					echo '<a href="', home_url("information"), '">　INFORMATION</a><br>';
					echo '<a href="', home_url("media"), '">　MEDIA</a><br>';
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

			// トップページ
			} else if(is_home() || is_front_page()) { ?>
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

		    <?php endif; ?>
		<?php } ?>
	    <?php wp_reset_postdata(); //クエリのリセット ?>



</div><!-- #secondary -->
