<!DOCTYPE html>
<html lang="ja">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
        <meta name="format-detection" content="telephone=no">        
        <!--テストデータの為-->
        <title>	
		   <?php bloginfo('name');	?>
		</title>		
	<?php wp_head(); ?>
</head>

<body id="wrapper" class="seconpage">   
    <header>
        <div class="main">
            <div class="logo"><a href="<?php echo HOME_URL; ?>"><img src="<?php echo TEMPLATE_URL; ?>/common_img/logo_ft.jpg" alt="介護の資格取得なら JOB COLLEGE SENDAI"></a></div>
            <nav class="navigation">
                <div class="navigation--item navigation--mail"><a href="<?php echo HOME_URL; ?>/contact/"><i class="fa fa-envelope"></i> <span>資料請求・お問い合わせはこちら</span></a></div>

                <div class="navigation--item nav-right visible-xs">
                    <div class="button" id="btn">
                        <div class="bar top"></div>
                        <div class="bar middle"></div>
                        <div class="bar bottom"></div>
                    </div>
                </div>
                <div class="sidebar">
				  <?php
				 $menu_items = wp_get_nav_menu_items(18);				 
				 $str_menu_pc = "";
				 if(count($menu_items>0)){
					 $str_menu_pc.='<ul class="d-flex">'; 
			     ?>
                <ul class="sidebar-list">
				    <?php 
						foreach($menu_items as $item_m) {
							$str_menu_pc.='<li class="ahover"><a href="'.$item_m->url.'">'.$item_m->title.'</a></li>';
					?>					
                    <li class="sidebar-item"><a href="<?php echo $item_m->url; ?>" class="sidebar-anchor"><i class="fa fa-angle-double-right"></i> <?php echo $item_m->title; ?></a></li>
					<?php } ?>                   
                </ul>
					 <?php 
						$str_menu_pc.='</ul>'; 
					 } 
					 ?>
                </div>
            </nav>
        </div>
    </header>
    
    <nav class="navpc">
       <?php if($str_menu_pc) echo $str_menu_pc;?>    
    </nav>    