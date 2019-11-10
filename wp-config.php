<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define('DB_NAME', 'tivinhat');

/** Username của database */
define('DB_USER', 'root');

/** Mật khẩu của database */
define('DB_PASSWORD', '');

/** Hostname của database */
define('DB_HOST', 'localhost');

/** Database charset sử dụng để tạo bảng database. */
define('DB_CHARSET', 'utf8');

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|k;Bc7/4u.1FymG/a -g.8]Xt=mc,8s_+^+aX]51E&+A8;UX0t=#M1fdLhX%!al{');
define('SECURE_AUTH_KEY',  'as8FFXG6-I>Yy54M8~_kq:sOVhu+i<}0<7M]P**^I%w,)]=>L1rikQ$*lSGpkUx3');
define('LOGGED_IN_KEY',    '7lk$3%,JBuNcTD4dwVNQW[GUxY00+[gHkm/UB}(j5,boC[^aLKNl,vES@2Sk};om');
define('NONCE_KEY',        'j/{+vY}hNnUYTpP>oX{zRFn!%lUHtYK~#vk97]T9=$}~K~]Tc+C$>a1+tXO@s4Jw');
define('AUTH_SALT',        'FHEXZ2&!%fLW8l;>/p-L&3u=|oBp.bA,V|`J_.4YF!mZoTBMazAB7IP?[l=C:Wg+');
define('SECURE_AUTH_SALT', '+T*Iq7{@RE#|LpR4vEGis  XKD-*e4yp-2?gTAx_@B=$fe+-|q5K<cUb?0`/H^Ew');
define('LOGGED_IN_SALT',   'Qc)CPRNf9}7j#<G3a r(k!{gNP#/p9]xM4A|{2]swoMzWJKFFb,HHy~1cO4WT,tw');
define('NONCE_SALT',       'xk*=O$c?]`gi{y%Zc`HnERGCcFS6]b0Sa!M<)4:V+m*Ay5(eo,x~sm*j-*EX> W,');

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'tivinhat_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
