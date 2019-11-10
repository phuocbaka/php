<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
    <title>Untitled Document</title>
    <link rel="stylesheet" href="<?php echo home_url('css/common.css'); ?>" />
    <link rel="stylesheet" href="<?php echo home_url('css/detail.css'); ?>" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.4.6/plyr.css">
    <link rel="stylesheet" href="<?php echo home_url('css/plyr.css'); ?>" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.plyr.io/3.4.6/plyr.js"></script>
    <!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script> -->
    <script src="<?php echo home_url('js/share.js'); ?>"></script>
    <script src="<?php echo home_url('js/plyr.js'); ?>"></script>
<!--     <script type="<?php echo home_url('css/slideshow.js'); ?>"></script> -->
</head>

<body>
    <?php include('inc/header.php'); ?>
        <main class="main">
            <div class="all">
                <div class="column1 about-video">
                    <?php
                    if ( have_posts() ) { while ( have_posts() ) {
                            the_post(); 
                            if (function_exists('dp_count_post_views')) {
                                dp_count_post_views($post->ID, true);
                            }                           
                            $slug = get_post_field( 'post_name', $post->ID );
                            $url_video = get_field('url-video', $post->ID); 
                            $viewed = dp_get_post_views($post->ID,"post_views_count");                          
                    ?>
                        <video width="1036" controls id="player">
                            <source src="<?php echo $url_video;?>" type="video/mp4"> Your browser does not support HTML5 video.
                        </video>
                        <div class="video-tl">
                            <div class="video-title">
                                <h1><?php the_title();?></h1>
                                <span><?php echo $viewed;?> views</span>
                            </div>
                            <div class="video-icon">
                                <div class="video-like">
                                    <a href="#"><img src="https://img.icons8.com/color/48/000000/two-hearts.png"></a>2k</div>
                                <div class="video-unlike">
                                    <a href="#"><img src="https://img.icons8.com/color/48/000000/dislike.png"></a>1</div>
                                <div class="video-share">
                                    <a href="#"><img src="https://img.icons8.com/material-outlined/48/000000/share-rounded.png"></a>share</div>
                            </div>
                        </div>
                        <?php the_content();?>
                            </p>
                            <?php 
                        } /* end while */
                    } /*end if */
                    ?>
                </div>

                <div class="column2">
                    <div class="up-next">
                        <div class="col-left">Up next</div>
                        <div class="col-right">
                            <div class="text-upload">Up load</div>
                            <div class="flatRoundedCheckbox">
                                <input type="checkbox" name="" id="flatOneRoundedCheckbox" value="1">
                                <label for="flatOneRoundedCheckbox"></label>
                                <div></div>
                            </div>
                        </div>
                    </div>

                    <ul class="all-column">

                        <?php 
                            /*get other */
                            $args = array(              
                            'post_type' => 'tivishow',
                            'posts_per_page' => 20,                         
                            'post_status'   => 'publish',               
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                            'post__not_in' => array($post->ID), 

                            /*
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category_video',
                                    'field' => 'name',
                                    'terms' => $item_cate_video->name
                                )
                            ),

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
                                    $description_video = get_field('description-video', $post->ID);             
                                    $url_img = get_the_post_thumbnail_url($post->ID,'thumb-video');                                 
                                    //printf("<pre>%s</pre>",print_r($post,true));

                                    $viewed = dp_get_post_views($post->ID,"post_views_count");

                        ?>

                            <li class="column2-01 abc">
                                <a href="<?php echo $thePostUrl;?>">
                                    <div class="thumnail">
                                        <img src="<?php echo $url_img;?>">
                                    </div>
                                    <div class="title-content">
                                        <h3 class="video-title"><?php echo $title;?></h3>
                                        <p class="video-content">
                                            <?php echo $description_video;?>
                                        </p>
                                        <p class="video-content">
                                            <?php echo $viewed;?> views</p>
                                    </div>
                                </a>
                            </li>

                            <?php 
                                } /*end while */
                            } /*end if */
                                ?>
                    </ul>
                </div>
            </div>
            </div>
            </div>
        </main>
        <?php include('inc/footer.php'); ?>
</body>

</html>