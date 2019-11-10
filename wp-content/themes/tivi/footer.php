<nav class="navpc navpc--footer">
    <?php
	 $menu_items = wp_get_nav_menu_items(19);				 
	 $str_menu_pc = "";
	 if(count($menu_items>0)){
		 $str_menu_pc.='<ul class="d-flex">'; 
	 ?>
	<ul class="d-flex">
		<?php 
			foreach($menu_items as $item_m) {				
		?>					
		<li class="ahover"><a href="<?php echo $item_m->url; ?>" class="sidebar-anchor"><i class="fa fa-angle-double-right"></i> <?php echo $item_m->title; ?></a></li>
		<?php } ?>                   
	</ul>
	 <?php } ?>
</nav>

<footer>
    <div class="main">
        <h2><a href="./"><img src="<?php echo get_bloginfo('template_directory'); ?>/common_img/logo_ft.jpg" alt="介護の資格取得なら JOB COLLEGE SENDAI"></a></h2>
        <div class="txt">
            <ul>
                <li><a href="./"><i class="fa fa-caret-right"></i>会社概要</a></li>
                <li><a href="./"><i class="fa fa-caret-right"></i>プライバシーポリシー</a></li>
            </ul>
            <p>Copyright (c) <?php echo date("Y");?> 株式会社人材サービスYOU <span>ジョブカレッジ仙台 All Rights Reserved.</span></p>
        </div>
    </div>
</footer>
<!-- End Footer-->
<?php wp_footer(); ?>	
<script>
    $(window).on("resize", function () {
        if($(window).width() > 1400) {
			$(".boxnews").css('right', '140px');
        }
        if($(window).width() < 1400) {
			$(".boxnews").css('right', '20px');
		}
	}).resize();
</script>
</body>
</html>