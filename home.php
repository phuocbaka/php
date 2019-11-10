<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
    <title>Untitled Document</title>
    <link rel="stylesheet" href="css/ul-li.css" />
    <link rel="stylesheet" href="css/common.css" />
	<link rel="stylesheet" href="css/plyr.css">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <!--       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script> -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!--       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script> -->
    <script src="js/share.js"></script>
	<script src="js/plyr.js"></script>
    <!--       <script type="js/slideshow.js"></script> -->
</head>

<body>
    <header id="header">
        <div class="inter">
            <div class="imess">
                <a href="https://www.youtube.com/channel/UCscZnAgp94_Yg0umE5wrAAQ?view_as=subscriber" target="_blank">
                    <img src="images/ytb.png" alt="youtube">
                </a>
                <a href="">
                    <img src="images/fb.png" alt="facebook"></a>
                <a href="https://www.pinterest.com/shirokurovn1987/" target="_blank"><img src="images/pr.png" alt="pinterest">
                </a>
            </div>
            <div class="logo-header">
                <a href="./index.html"> <img src="images/logo.png" alt="logo"></a>
            </div>
            <div class="open">
                <svg class="ham hamRotate ham4" viewBox="0 0 80 80" width="40" onclick="this.classList.toggle('active')">
                    <path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
                    <path class="line middle" d="m 70,50 h -40" />
                    <path class="line bottom" d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
                </svg>
            </div>
            <div id="navbar" class="overlay">
                <div class="overlay-content">
                    <a href="./index.html">Home</a>
                    <a href="#">Portfolio</a>
                    <a href="#">Services</a>
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
	    <?php 
		/*get all category */
		$category_video = get_terms( array(
					'taxonomy' => 'category_video',
					'hide_empty' => true,
				) );
		if(count($category_video)>0){
			$no=1;
			foreach($category_video as $item_cate_video)
			{
		?>
        <div class="video-new">

            <h2><?php echo $item_cate_video->name;?></h2>
            <div class="clip">
                
                <input type='hidden' id='current_page_<?php echo $no;?>' />
                <input type='hidden' id='show_per_page_<?php echo $no;?>' />
                <ul class="cf" id="pagingBox_<?php echo $no;?>" >
				    <?php 
			
					$args = array( 				
							'post_type' => 'tivishow',
							'posts_per_page' => -1,							
							'post_status'   => 'publish',				
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => 'category_video',
									'field' => 'name',
									'terms' => $item_cate_video->name
								)
							),
							/*
							'meta_query'=>array(
								array(
									'key' => 'show_top',
									'value' => true,
									'compare' => '='
								),
							),
                            */							
						);

				    $the_query = new WP_Query( $args );               			
							if ( $the_query->have_posts() ) {						
								while ( $the_query->have_posts() ) {
									$the_query->the_post();
									$date_post  = date("Y m d",strtotime($post->post_date));					
									$thePostUrl = get_the_permalink();									
									$slug       = get_post_field( 'post_name', $post->ID );
									$title      = $post->post_title;
									$content    = $post->post_content;
                                    $viewed = dp_get_post_views($post->ID,"post_views_count");  
									$url_img = get_the_post_thumbnail_url($post->ID,'thumb-video');	
									
									/*$is_new = get_field('is_new', $post->ID);*/  									
									//printf("<pre>%s</pre>",print_r($post,true));
									
									$now = strtotime(date("d-m-Y",time()));                                   
                                    $your_date = strtotime(date('d-m-Y',strtotime($post->post_date)));                                    
                                    $datediff = $now - $your_date;
                                    $date_re = floor($datediff/(60*60*24));
									$is_new = false;
									if($date_re<=1)
									{
										$is_new = true;
									}
									
				
					?>
                    <li class="categoly-video">
                        <a href="<?php echo $thePostUrl;?>">						    
                            <figure><img src="<?php echo $url_img;?>" alt="<?php echo $title;?>"></figure>
                            <p class="video_news"><?php echo $title;?> <?php if($is_new) { echo '<img src="'.home_url('./images/news.gif').'">'; } ?></p>
                            <span><?php echo $viewed;?> views</span>
                            <p class="day"><?php echo $date_post;?></p>
                        </a>
                    </li>
					
								<?php 
									} /* end while */
							}/* end if */
								?>		
                </ul>                           
            </div>
            <div class="pagination__wrapper ">
                <div id='page_navigation_<?php echo $no;?>'></div> 
            </div>
        </div>	
		<script>          
             jQuery(document).ready(function () {

                        //Pagination JS
                        //how much items per page to show
                        var show_per_page_<?php echo $no;?> = 12; 
                        //getting the amount of elements inside pagingBox div
                        var number_of_items_<?php echo $no;?> = $('#pagingBox_<?php echo $no; ?>').children().size();
                        //calculate the number of pages we are going to have
                        var number_of_pages_<?php echo $no;?> = Math.ceil(number_of_items_<?php echo $no;?>/show_per_page_<?php echo $no;?>);
                        
                        //set the value of our hidden input fields
                        $('#current_page_<?php echo $no;?>').val(0);
                        $('#show_per_page_<?php echo $no;?>').val(show_per_page_<?php echo $no;?>);
                        
                        //now when we got all we need for the navigation let's make it '
                        
                        /* 
                        what are we going to have in the navigation?
                            - link to previous page
                            - links to specific pages
                            - link to next page
                        */
                        var navigation_html_<?php echo $no;?> = '<a class="previous_link" href="javascript:previous(\'<?php echo $no;?>\');">Prev</a>';
                        var current_link_<?php echo $no;?> = 0;
                        while(number_of_pages_<?php echo $no;?> > current_link_<?php echo $no;?>){
                            navigation_html_<?php echo $no;?> += '<a class="page_link" href="javascript:go_to_page(' + current_link_<?php echo $no;?> +',\'<?php echo $no;?>\')" longdesc="' + current_link_<?php echo $no;?> +'">'+ (current_link_<?php echo $no;?> + 1) +'</a>';
                            current_link_<?php echo $no;?>++;
                        }
                        navigation_html_<?php echo $no;?> += '<a class="next_link" href="javascript:next(\'<?php echo $no;?>\');">Next</a>';
                        
						
						if(current_link_<?php echo $no;?> > 1) {
						
							$('#page_navigation_<?php echo $no;?>').html(navigation_html_<?php echo $no;?>);
							
							//add active_page class to the first page link
							$('#page_navigation_<?php echo $no;?> .page_link:first').addClass('active_page_<?php echo $no;?>');
							
							//hide all the elements inside pagingBox div
							$('#pagingBox_<?php echo $no;?>').children().css('display', 'none');
							
							//and show the first n (show_per_page) elements
							$('#pagingBox_<?php echo $no;?>').children().slice(0, show_per_page_<?php echo $no;?>).css('display', 'block');
						}
                    
                });

		 </script>
		
		<?php  
         $no++;
		} /*end if */
		} /* end foreach */
		?>

        
             <script>

                //Pagination JS

                function previous(no){
                    
                    new_page = parseInt($('#current_page_'+no).val()) - 1;
					console.log(new_page);
                    //if there is an item before the current active link run the function
                    if($('.active_page_'+no).prev('.page_link').length==true){
                        go_to_page(new_page,no);
                    }
                    
                }

                function next(no){
                    new_page = parseInt($('#current_page_'+no).val()) + 1;
                    //if there is an item after the current active link run the function
                    if($('.active_page_'+no).next('.page_link').length==true){
                        go_to_page(new_page,no);
                    }
                    
                }

                function go_to_page(page_num,no){
                    //get the number of items shown per page
                    var show_per_page = parseInt($('#show_per_page_'+no).val());
                    
                    //get the element number where to start the slice from
                    start_from = page_num * show_per_page;
                    
                    //get the element number where to end the slice
                    end_on = start_from + show_per_page;
                    
                    //hide all children elements of pagingBox div, get specific items and show them
                    $('#pagingBox_'+no).children().css('display', 'none').slice(start_from, end_on).css('display', 'block');
                    
                    /*get the page link that has longdesc attribute of the current page and add active_page class to it
                    and remove that class from previously active page link*/
                    $('.page_link[longdesc=' + page_num +']').addClass('active_page_'+no).siblings('.active_page_'+no).removeClass('active_page_'+no);
                    
                    //update the current page input field
                    $('#current_page_'+no).val(page_num);
                }

        </script>
    </main>
    <div class="fot">
        <footer>My blog</footer>
    </div>
</body>

</html>