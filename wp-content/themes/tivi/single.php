<?php 
get_header(); ?>
<div class="inner clearfix">
			<div id="main">
				<?php breadcrumb(); ?>

				<div id="main_inner">
					<div class="main_block">
						<div class="show_detail">
	            <?php
				
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
					        wpb_set_post_views(get_the_ID());
							 $date_post = date("Y-m-d",strtotime($post->post_date));
					        ?>
					        <div class="date"><?php echo $date_post;?>
							
							<?php 
								$category_detail=get_the_category($post->ID);//$post->ID								
								foreach($category_detail as $cd){
									echo '<em><a href="/category/'.$cd->slug.'">'.$cd->cat_name.'</a></em>';
								}
								?>
							</div>
							<h3 class="headline5"><?php echo $post->post_title; ?></h3>
							
					        <?php
							the_content();
					endwhile;
				endif;
				?>
				</div>
				<!-- .show_detail  -->
             </div>
					<!-- .main_block -->
				</div>
				<!-- #main_inner -->
			</div>
			<!-- #main -->	
 <?php get_template_part( 'inc/sidebar' )?>
</div>
<!-- .inner --> 
			
<?php get_footer(); ?>
