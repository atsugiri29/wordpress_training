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

</div><!-- #secondary -->
*/ ?>

	<div>
		<p></p>
		<ul>
			<?php if(is_singular('product') || is_tax( 'product-tag' )) : ?>
				<!-- // 商品ページ -->
				<?php
					// ブランド名を取得
					if(is_singular('product')) {
						if ( have_posts() ) {
							the_post();
							$terms = get_the_terms( $post->ID, 'brand-tag' );
							if(count($terms) == 1)
								foreach ( $terms as $term ); // $termのセットのための空ループ
							$brandName = $term->name;
						}
					} else {
						$brandName = get_field('select_brand-tag_in_product-tag', 'product-tag_' . $wp_query->get_queried_object()->term_id);
					}
					
					echo 'PRODUCT<br>';

					// 商品カテゴリを表示
					// 最上層の商品カテゴリを取得
					$args = array(
						'orderby' 	=> 'name',
						'order'		=> 'ASC',
						'get'		=> 'all',
						'parent'	=> 0,
					);
					$terms = get_terms( 'product-tag', $args );
					if(count($terms) > 0)
						foreach ( $terms as $term ) {
							// 商品カテゴリに付いたブランドタグが商品のブランド名と一致するもののみ処理
							if( get_field('select_brand-tag_in_product-tag', 'product-tag_' . $term->term_id) == $brandName) {

								// 最上層の商品カテゴリのリンクを設置
								echo '　', '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>', '<br>';
								// 子の商品カテゴリを取得してリンクを設置
								$args['parent'] = (int)$term->term_id;
								$cTerms = get_terms( 'product-tag', $args );
								if(count($cTerms) > 0)
									foreach ( $cTerms as $cTerm )
										echo '　　', '<a href="' . get_term_link( $cTerm ) . '">' . $cTerm->name . '</a>', '<br>';
							}
						}
					?>
			<?php else : ?>
				<!-- // 商品ページ以外 -->
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
						<b><a href="<?php echo home_url("information"); ?>">INFORMATION</a></b><br>
						<b><a href="<?php echo home_url("media"); ?>">MEDIA</a></b><br>
					<?php endif; ?>

			    <?php endif; ?>
			<?php endif; ?>
		    <?php wp_reset_postdata(); //クエリのリセット ?>
		</ul>

	</div>
