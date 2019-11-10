<?php
define( 'TEMPLATE_URL' , get_template_directory_uri() );
define( 'HOME_URL' , home_url() );
$URL_G=explode("/",$_SERVER["REQUEST_URI"]);
array_shift($URL_G);

function the_slug_exists($post_name) {
    global $wpdb;
    if($wpdb->get_row("SELECT post_name FROM " . $wpdb->posts ." WHERE post_type='post' and post_name = '" . $post_name . "'", 'ARRAY_A')) {
        return true;
    } else {
        return false;
    }
}

if(isset($URL_G[0]) && $URL_G[0]!="" && the_slug_exists($URL_G[0]))
{
	$url = home_url()."/news/".$URL_G[0].".html";	
	wp_redirect($url);
    exit;
}


/*add_action('wp_enqueue_scripts', 'add_style_css');*/
/************ Enqueue Styles and Scripts ************/
function add_style_js()
{
	
}
add_action('wp_footer', 'add_style_js',5);

add_action( 'wp_head', 'myplugin_ajaxurl' );
function myplugin_ajaxurl() {
	echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
         </script>';
}

/************ Init ************/
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_generator' );
add_theme_support( 'post-thumbnails' );

add_action('admin_menu', 'my_remove_sub_menus');
function my_remove_sub_menus() {
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}

function remove_menus(){  
  
  //remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  /*
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  */
  
  
}

add_action( 'admin_menu', 'remove_menus' );
add_image_size( 'thumb-video', 360, 216, true );

//hide top admin bar when admin login
show_admin_bar( false );
register_nav_menus();


if ( !function_exists( 'wpex_pagination' ) ) {
	function wpex_pagination() {		
		global $wp_query;
		$prev_arrow = is_rtl() ? '前へ' : '前へ';
		$next_arrow = is_rtl() ? '次へ' : '次へ';
		$big = 999999999; // need an unlikely integer	
		$total = $wp_query->max_num_pages;
		
		if( $total > 1 )  {
			 
			 if( !$current_page = get_query_var('paged') )
                 $current_page = 1;
             if( get_option('permalink_structure') ) {
                 $format = 'page/%#%/';
             } else {
                 $format = '&paged=%#%';
             }
			 
			
			$pages = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => $format,
				'current' => max( 1, get_query_var( 'paged' ) ),
				'total' => $total,
				'mid_size' => 3,
                'end_size' => 1,
				'type' => 'array',
				'prev_text' => $prev_arrow,
				'next_text' => $next_arrow
			) );
			
			if ( is_array( $pages ) ) {
				$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
				echo '<nav class="pager"><ul class="pagination clearfix">';
				foreach ( $pages as $page ) {
					echo "<li>$page</li>";
				}
				echo '</ul></nav>';
			}
		}
	}
}

function login_logo() {    
    echo '<style type="text/css">
    .login h1 a {
          background-image: url('.HOME_URL.'/images/common/logo.png);
          background-size:100%;
          width:100%;
        }
    </style>';
}
add_action( 'login_head', 'login_logo' );

function login_logo_url() {
  return home_url();
}
add_filter('login_headerurl','login_logo_url');

function wpdocs_theme_add_editor_styles() {	
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

function et_exceprt( $string , $charlength ) {
	if ( mb_strlen( $string ) > $charlength ) {	
		if ( mb_strlen( $string ) <= 0 ) {
			 $result = '...';			 
		} else {
			$stringStriped = wp_strip_all_tags($string);
			$result = mb_substr( $stringStriped, 0,$charlength);
			$result .= '...';
		}
	} else {
		$result = $string;
	}
	return $result;
}

/*get Post all */
function my_init(){

	if( !isset($_SESSION) ) {
		session_start();
	}
	
	if(!empty($_POST)){
		$_SESSION['post_data'] = $_POST;
	}
	 
}
add_action('init', 'my_init', 1);


/* add comment..
* ---------------------------------------- */
if( !function_exists('breadcrumb') ){

  function breadcrumb(){

    global $post;
    // ポストタイプを取得
    $post_type = get_post_type( $post );

    $bc  = '<ul id="breadcrumb" class="breadcrumb clearfix">';
    $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.home_url().'" itemprop="url"><i class="fa fa-home"></i> <span itemprop="title">ホーム</span></a> / </li>';

    if( is_home() ){
      // メインページ
	  if(isset($_REQUEST['_y']) && isset($_REQUEST['_m']) && (int)$_REQUEST['_y']>0 && (int)$_REQUEST['_m']>0)
	  {
		$year = (int)$_REQUEST['_y'];
		$moth = (int)$_REQUEST['_m'];
		$str_date = $year.'年 '.$moth.'月';
		$bc .= '<li><i class="fa fa-list-alt"></i> '.$str_date.'</li>';
	  }else
	  {
		$bc .= '<li><i class="fa fa-list-alt"></i> 最新記事一覧</li>';  
	  }	
       
    }elseif( is_search() ){
      // 検索結果ページ
      $bc .= '<li><i class="fa fa-search"></i> 「'.get_search_query().'」の検索結果</li>';
    }elseif( is_404() ){
      // 404ページ
      $bc .= '<li><i class="fa fa-question-circle"></i> ページが見つかりませんでした</li>';
    }elseif( is_date() ){
      // 日付別一覧ページ
      $bc .= '<li><i class="fa fa-clock-o"></i> ';
      if( is_day() ){
        $bc .= get_query_var( 'year' ).'年 ';
        $bc .= get_query_var( 'monthnum' ).'月 ';
        $bc .= get_query_var( 'day' ).'日';
      }elseif( is_month() ){
        $bc .= get_query_var( 'year' ).'年 ';
        $bc .= get_query_var( 'monthnum' ).'月 ';
      }elseif( is_year() ){
        $bc .= get_query_var( 'year' ).'年 ';
      }
      $bc .= '</li>';
    }elseif( is_post_type_archive() ){
      // カスタムポストアーカイブ
      $bc .= '<li><i class="fa fa-folder"></i> '.post_type_archive_title('', false).'</li>';
    }elseif( is_category() ){
      // カテゴリーページ
      $cat = get_queried_object();
      if( $cat -> parent != 0 ){
        $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
        foreach( $ancs as $anc ){
          $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($anc).'" itemprop="url"><i class="fa fa-folder"></i> <span itemprop="title">'.get_cat_name($anc).'</span></a> / </li>';
        }
      }
      $bc .= '<li><i class="fa fa-folder"></i> '.$cat->cat_name.'</li>';
    }elseif( is_tag() ){
      // タグページ
      $bc .= '<li><i class="fa fa-tag"></i> '.single_tag_title("",false).'</li>';
    }elseif( is_author() ){
      // 著者ページ
      $bc .= '<li><i class="fa fa-user"></i> '.get_the_author_meta('display_name').'</li>';
    }elseif( is_attachment() ){
      // 添付ファイルページ
      if( $post->post_parent != 0 ){
        $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_permalink( $post->post_parent ).'" itemprop="url"><i class="fa fa-file-text"></i> <span itemprop="title">'.get_the_title( $post->post_parent ).'</span></a> / </li>';
      }
      $bc .= '<li><i class="fa fa-picture-o"></i> '.$post->post_title.'</li>';
    }elseif( is_singular('post') ){
      $cats = get_the_category( $post->ID );
      $cat = $cats[0];

      if( $cat->parent != 0 ){
        $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
        foreach( $ancs as $anc ){
          $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link( $anc ).'" itemprop="url"><i class="fa fa-folder"></i> <span itemprop="title">'.get_cat_name($anc).'</span></a> / </li>';
        }
      }
      $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link( $cat->cat_ID ).'" itemprop="url"><i class="fa fa-folder"></i> <span itemprop="title">'.$cat->cat_name.'</span></a> / </li>';
      $bc .= '<li><i class="fa fa-file-text"></i> '.$post->post_title.'</li>';
    }elseif( is_singular('page') ){
      // 固定ページ
      if( $post->post_parent != 0 ){
        $ancs = array_reverse( $post->ancestors );
        foreach( $ancs as $anc ){
          $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_permalink( $anc ).'" itemprop="url"><i class="fa fa-file"></i> <span itemprop="title">'.get_the_title($anc).'</span></a> /';
        }
      }
      $bc .= '<li><i class="fa fa-file"></i> '.$post->post_title.'</li>';
    }elseif( is_singular( $post_type ) ){
      // カスタムポスト記事ページ
      $obj = get_post_type_object($post_type);

      if( $obj->has_archive == true ){
      $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_post_type_archive_link($post_type).'" itemprop="url"><i class="fa fa-pencil-square-o"></i> <span itemprop="title">'.get_post_type_object( $post_type )->label.'</span></a> / </li>';
      }
      $bc .= '<li><i class="fa fa-file"></i> '.$post->post_title.'</li>';
    }else{
      // その他のページ
      $bc .= '<li><i class="fa fa-file"></i> '.$post->post_title.'</li>';
    }

    $bc .= '</ul>';

    echo $bc;

  }
}
/*
add_action( 'init', 'register_menus' );
function register_menus() {
  register_nav_menus( array(
    'main_header' => 'Main Header'
  ) );
	
 register_nav_menus( array(
    'main_footer' => 'Main Footer'
  ) ); 
  
}

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
*/
//To keep the count accurate, lets get rid of prefetching
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
/*
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'ニュース';
    $submenu['edit.php'][5][0] = 'ニュース';
    $submenu['edit.php'][10][0] = '新規追加';
    unset($submenu['edit.php'][16][0]);
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'ニュース';
    $labels->singular_name = 'ニュース';
    $labels->add_new = '新規追加';
    $labels->add_new_item = '新規追加';
    $labels->edit_item = '編集';
    $labels->new_item = 'ニュース';
    $labels->view_item = '確認';
    $labels->search_items = '検索';
    $labels->not_found = 'ニュースがない';
    $labels->not_found_in_trash = 'ニュースがない';
    $labels->all_items = '全てのニュース';
    $labels->menu_name = 'ニュース';
    $labels->name_admin_bar = 'ニュース';
}
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );
*/
add_filter( 'use_block_editor_for_post', '__return_false' );

add_filter( 'aioseop_title', 'change_wordpress_seo_title' );
function change_wordpress_seo_title( $title ){   
	if(is_post_type_archive('information'))
	{
		$title ="ARM RIGHTS株式会社｜インフォメーション（詳細）｜神戸｜アームライツ";
	}	
	if(is_post_type_archive('seminar'))
	{
		$title ="ARM RIGHTS株式会社｜セミナー｜神戸｜アームライツ";
	}	
    return $title;
}

add_action( 'pre_get_posts', 'wpsites_cpt_archive_items' );
function wpsites_cpt_archive_items( $query ) 
{
	global $paged;
	if(!$paged)
	{
		$paged = (isset($_GET['num_paged']) && (int)$_GET['num_paged']>0) ? $_GET['num_paged'] : 1;
	}
		
    if( $query->is_main_query() && !is_admin() && (is_category() || is_archive()) ) {
		$query->set( 'post_status', 'publish' );		
	}

}

function dp_count_post_views($post_ID, $update = false) 
{
//Set the name of the Posts Custom Field.
$count_key = 'post_views_count';
//Returns values of the custom field with the specified key from the specified post.
$count = get_post_meta($post_ID, $count_key, true);

//If the the Post Custom Field value is empty. 
if ( $count == null ) {
$count = 0; // set the counter to zero.
//Delete all custom fields with the specified key from the specified post. 
delete_post_meta($post_ID, $count_key); 
//Add a custom (meta) field (Name/value)to the specified post.
add_post_meta($post_ID, $count_key, 0);

} else {	//If the the Post Custom Field value is NOT empty.
if ($update) {
//increment the counter by 1.
//Update the value of an existing meta key (custom field) for the specified post.
$count++;
update_post_meta($post_ID, $count_key, $count);
}
}

// Do action
do_action( 'dp_count_post_views', array($post_ID, $update) );
}

//Gets the number of Post Views to be used later.
function dp_get_post_views($post_ID, $meta_key)
{
$meta_key = empty($meta_key) ? 'post_views_count' : $meta_key;
//Returns values of the custom field with the specified key from the specified post.
$count = get_post_meta($post_ID, $meta_key, true);
return $count;
}