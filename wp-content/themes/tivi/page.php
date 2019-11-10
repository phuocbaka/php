<?php get_header(); ?>
<?php			
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
?>			
<section class="titleheader">
	<h2 class="fontmin text-center"><?php the_title();?></h2>
</section>
<!-- End Top-->
<section class="content_secon flow">
	<article>
		<div class="flow--block">
			<?php the_content(); ?>
		 </div>
	</article>
</section>

<?php 
	endwhile;
	else:
?>					
	<section class="content_secon flow">
	<article id="post-404"class="cotent-none post" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
	  <section class="post-content" itemprop="text">
		<?php echo get_template_part('content', 'none'); ?>
	  </section>
	</article>
	</section>					
<?php 				
	endif;
?>				
<?php get_footer(); ?>
