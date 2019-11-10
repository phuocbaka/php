<div class="news_catalog">
<h4><img width="26" src="<?php echo get_bloginfo('template_directory'); ?>/images/nt_cat.png">カテゴリー</h4>
<?php 
$terms = get_terms( array(
	'taxonomy' => 'cat_information',
	'hide_empty' => false,
));
if(count($terms)>0){
foreach($terms as $key=>$term)
{
	 $term_link = get_term_link( $term );	
?>	
	<p><a href="<?php echo $term_link; ?>"><?php echo $term->name;?></a></p>
<?php 
}
} 
?>	
</div>	