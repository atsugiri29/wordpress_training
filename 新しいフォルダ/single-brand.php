<?php get_header(); ?>
<table cellpadding="0" cellspacing="0"><tbody>
<tr>
<td width="250">
<?php get_sidebar(); ?>
</td>
<td>
<div id="main" role="main">
     <div class="page-wrap">

<?php
		have_posts(); // この行がないと記事が表示されない不具合。原因不明

		parse_str($_SERVER['QUERY_STRING'], $strs);
		if(count($strs) > 0 && $strs['page_type'] == 'products') {
			// ブランドの商品一覧のページ
			echo 'second<br>';

			// 最上層の商品カテゴリを取得
			$args = array(
				'orderby' 	=> 'name',
				'order'		=> 'ASC',
				'get'		=> 'all',
				'parent'	=> 0,
			);
			$terms = get_terms( 'product-tag', $args );
			if(count($terms) > 0) {
				$brandName = get_brand_name();
				echo $brandName, '<br>';
				foreach ( $terms as $term ) {
					if($term->term_id == $brandName) {
						echo 'display';
						display_products($term);
					}
				}
			}
		} else {
			// ブランドのトップページを表示
			if ( have_posts() ) : while ( have_posts() ) : the_post();
	?>
	          <div class="page-title">
	               <h1><?php the_title(); ?></h1>
	          </div>
	          
	          <article class="container">
	               <div class="author row">
	                    <div class="col span_3 author-img"><?php the_post_thumbnail(); ?></div>
	                    <div class="col span_9">

							<div>
	<?php if(get_post_meta($post->ID, '画像1', true)): ?><a href="<?php $Image = wp_get_attachment_image_src(get_post_meta($post->ID, '画像1', true), 'full'); echo $Image[0]; ?>" class="lightbox"><?php echo wp_get_attachment_image(get_post_meta($post->ID, '画像1', true),'custom_size'); ?></a><?php else : ?><?php endif; ?>						<?php echo get_the_date("Y.n.j"); ?>
							<br>

							<?php $tags = wp_get_post_tags( $post->ID ); ?>
							<?php for($cnt = 0; $cnt < count($tags); $cnt++) { ?>
								<?php echo $tags[$cnt]->name, " "; ?>
							<?php } ?>
							</div>

							<div>
					<?php /*
						    <?php the_excerpt(); ?>
							<?php echo get_the_excerpt(); ?>
					*/ ?>
							</div>
							<p></p>

	                    </div>
	               </div>
	               <!-- /.row -->
	               
	               <div class="row team-content">
	                    <?php the_content(); ?>
	               </div>
	               <!-- /.row -->
	          </article>
	          <!-- /.container -->
<?php
	           endwhile; endif;
		}
?>
    </div>
     <!-- /.page-wrap -->
</div>
<!-- /#main -->
</td>
</tr>
</tbody></table>
 
<?php get_footer(); ?>
