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
	// トップページ
	if(is_home() || is_front_page()) {
?>
		<ul>
			<!-- 各ブランドのリンク -->
		    <?php $args = array(
		        'numberposts' => 100,                //表示（取得）する記事の数
		        'post_type' => array( 'brand' ),    //投稿タイプの指定
		    );
		    $customPosts = get_posts($args);
		    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); 
		    ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
<?php
		    endforeach; endif;
			wp_reset_postdata();
?>
		</ul>
<?php
	} else /* if(is_singular('product') || is_tax( 'product-tag' ) || is_singular('brand') || is_post_type_archive('media') || is_post_type_archive('information')) */ {
		// URL末尾の「?page_type=」で設定された値を取得
		parse_str($_SERVER['QUERY_STRING'], $strs);
		if(count($strs) > 0)
			$pageType = $strs['page_type'];

		// ブランド名を取得
		if(is_singular('product') || is_singular('brand')) {
			$brandName = getBrandName();
		}
		if(is_tax( 'product-tag' )) {
			$brandName = get_field('brand-tagOfProduct-tag', 'product-tag_' . $wp_query->get_queried_object()->term_id);
		}
		
		// ブランドの記事一覧ページ
		if(is_post_type_archive('media') || is_post_type_archive('information') || is_singular('brand') && $pageType == 'news' || is_page('news')) {

		    // URLを設定
			echo '<a href="', get_site_url(), '/news"><h1>NEWS</h1></a>';
			echo '<h3>CATEGORY</h3>';

		    // 各ブランドの記事一覧へのリンク
	    	echo '<ul>';
		    // 記事を取得
		    $args = array(
		        'numberposts' => 100,           	// 記事数
		        'post_type' => array( 'brand' ),    // 投稿タイプ
		    );
		    
		    $customPosts = get_posts($args);
		    if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
		    	echo '<li><a href="', get_site_url(), '/brand/', the_title('', '', false), '?page_type=news	"><b>　', the_title('', '', false), '</b></a></li>';
		    endforeach; endif;
		    wp_reset_postdata();

			// メディア・インフォメーション記事一覧へのリンク
			echo '<li><a href="', home_url("information"), '">　INFORMATION</a></li>';
			echo '<li><a href="', home_url("media"), '">　MEDIA</a></li>';
			echo '</ul>';
		// ブランドの記事一覧ページ以外
		} else {

			// ブランド名の見出し
			echo '<h1>', $brandName, '</h1>';

			echo '<ul>';
			// ブランドの説明ページへのリンク
			echo '<li><a href="', get_site_url(), '/brand/', $brandName, '?page_type=description	"><b>', $brandName, 'とは</b></a></li>';

			// 新着記事へのリンク
			echo '<li><a href="', get_site_url(), '/brand/', $brandName, '?page_type=news	"><b>NEWS</b></a></li>';

			// ブランドの商品一覧ページへのリンク
			echo '<li><a href="', get_site_url(), '/brand/', $brandName, '?page_type=products"><b>PRODUCTS</b></a></li>';

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
				echo '<ul>';
				foreach ( $terms as $term ) {
					// 商品カテゴリに付いたブランドタグが商品のブランド名と一致するもののみ処理
					if( get_field('brand-tagOfProduct-tag', 'product-tag_' . $term->term_id) == $brandName) {

						// 最上層の商品カテゴリのリンクを設置
						echo '<li><a href="', get_term_link($term), '">', $term->name, '</a></li>';
						// 子の商品カテゴリを取得してリンクを設置
						$args['parent'] = (int)$term->term_id;
						$cTerms = get_terms( 'product-tag', $args );
						if(count($cTerms) > 0) {
							echo '<ul>';
							foreach ( $cTerms as $cTerm )
								echo '<li><a href="' . get_term_link( $cTerm ) . '">' . $cTerm->name . '</a>', '</li>';
							echo '</ul>';
						}
					}
				}
				echo '</ul>';
			}
			echo '<li>SHOP LIST</li>';
			echo '</ul>';
		}
	}
//    wp_reset_postdata(); //クエリのリセット
?>



</div><!-- #secondary -->
