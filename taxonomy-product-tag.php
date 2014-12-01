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
			echo $wp_query->get_queried_object()->name;
			display_products($wp_query->get_queried_object()->name);
/*
			// 該当商品カテゴリに属する商品を全て取得
			echo $wp_query->get_queried_object()->name;
			$args = array(
			    'post_type' => 'product',
			    'posts_per_page' => 10,
			    'tax_query' => array(
					array(
						'taxonomy' => 'product-tag', //(string) - タクソノミー。
						'field' => 'slug', //(string) - IDかスラッグのどちらでタクソノミー項を選択するか
						'terms' => $wp_query->get_queried_object()->name, //(int/string/array) - タクソノミー項
						'include_children' => true, //(bool) - 階層構造を持ったタクソノミーの場合に、子タクソノミー項を含めるかどうか。デフォルトはtrue
					)
				)
			);
			$loop = new WP_Query($args);
			if ( $loop->have_posts() ) :
				echo '<table>';
				$postCount = 0; // 表示した商品をカウント
				$POSTS_PER_ROW = 2; // 一行あたりに表示する商品数
				while($loop->have_posts()): $loop->the_post();
					if( $postCount % $POSTS_PER_ROW == 0 ) echo '<tr>';
					echo '<td>';
						$thumbnail = wp_get_attachment_image_src(post_custom('画像1'),'thumbnail' );
						echo '<img src="' . $thumbnail[0] . '" /><br>';
						the_title();
					echo '</td>';
					if( $postCount++ % $POSTS_PER_ROW == $POSTS_PER_ROW - 1 ) echo '</tr>';
				endwhile;
				echo '</table>';
			endif;
*/
?>
     </div>
     <!-- /.page-wrap -->
</div>
<!-- /#main -->
</td>
</tr>
</tbody></table>
 
<?php get_footer(); ?>
