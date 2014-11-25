<?php get_header(); ?>
<table cellpadding="0" cellspacing="0"><tbody>
<tr>
<td width="250">
<?php get_sidebar(); ?>
</td>
<td>
<div id="main" role="main">
     <div class="page-wrap">
     
     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <div class="page-title">
               <h1><?php the_title(); ?></h1>
          </div>
          
          <article class="container">
               <div class="author row">
                    <div class="col span_3 author-img"><?php the_post_thumbnail(); ?></div>
                    <div class="col span_9">

						<div>
						<?php echo get_the_date("Y.n.j"); ?>
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
          <?php endwhile; endif; ?>
     </div>
     <!-- /.page-wrap -->
</div>
<!-- /#main -->
</td>
</tr>
</tbody></table>
 
<?php get_footer(); ?>
