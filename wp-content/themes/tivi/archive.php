<?php
	get_header(); 
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;	
?>
<main>
        <article class="titleheader">
            <h2 class="fontmin text-center">インフォメーション</h2>
        </article>
	   
		<article class="content">
            <div class="box_news clearfix">
			    <div class="ov_hide content_news">
	            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>				
				<?php				    
					$post_tags = get_the_tags($post->ID);
                    $date_post = date("Y-m-d",strtotime($post->post_date));
					
					$thePostUrlGroup =  get_field('custom_url');
					if($thePostUrlGroup ) 
					{
						$thePostUrl = $thePostUrlGroup[0]['custom_url_post'];                     				
						if ($thePostUrl=="") 
                        {
							$thePostUrl=get_the_permalink();
						}
						$target = $thePostUrlGroup[0]['custom_url_post_target'];
						
					}else
					{
						$thePostUrl=get_the_permalink();
						$target = "";
					}
					
				?>
				    <div class="box">
                        <p class="time clearfix"><?php echo $date_post; ?>	
						<?php
							$category_detail=wp_get_post_terms($post->ID,'cat_information',array("fields" => "all"));//$post->ID                           						
							foreach($category_detail as $cd){
								echo '<span>'.$cd->name.'</span>';
							}
						?>	
						</p>
						
                        <div class="clearfix">
						    <?php if ( has_post_thumbnail() ) { ?>	
								<div class="pht"><a href="<?php the_post_thumbnail_url(); ?>" rel="lightbox"><img class="imghover" src="<?php the_post_thumbnail_url('thumb-news'); ?>" /></a></div>
							<?php } ?>
                            <div class="ov_hide">
                                <h4>
                                    <a href="<?php echo $thePostUrl ?>"><?php echo $post->post_title; ?></a>
                                </h4>
                                <p class="ttext">
                                   <?php echo et_exceprt($post->post_content,130); ?>
                                </p>
                            </div>
                        </div>
                    </div>					
					<!-- .news_item -->
				<?php endwhile; ?>
				
							
				<div class="dv_next clearfix">
					<?php if ( get_previous_posts_link() ) : ?>
						 <p class="pre"><?php previous_posts_link('back'); ?></p>
					<?php endif; ?>
					
					<?php if ( get_next_posts_link() ) : ?>
					      <p class="next"><?php next_posts_link('next'); ?></p>
					<?php endif; ?>
					
				</div>
                
				<?php
				else:			
				 ?>
					<article id="post-404"class="cotent-none post" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
					  <section class="post-content" itemprop="text">
						<?php echo get_template_part('content', 'none'); ?>
					  </section>
					</article>
	            <?php
				endif;
				?>
			</div>
			<?php get_template_part( 'sidebar' )?>			
		 </div>
		<!-- #main_block -->
		</div>
  </article>
 </main>
<?php get_footer();