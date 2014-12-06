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
		// その商品カテゴリが子カテゴリを持つか
		$productCat = $wp_query->get_queried_object(); // 商品カテゴリ
		display_products($productCat);

?>
     </div>
     <!-- /.page-wrap -->
</div>
<!-- /#main -->
</td>
</tr>
</tbody></table>
 
<?php get_footer(); ?>
