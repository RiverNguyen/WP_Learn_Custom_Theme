<?php
// Khai bao hang so goc thu muc
define("JANG_THEME_DIR", get_template_directory());
define("JANG_THEME_URL", get_template_directory_uri());
define("JANG_THEME_CSS", JANG_THEME_URL . "/css");
define("JANG_THEME_IMG", JANG_THEME_URL . "/img");
define("JANG_THEME_JS", JANG_THEME_URL . "/js");
define("JANG_THEME_LANG", JANG_THEME_DIR . "/lang");
define("JANG_THEME_LIB", JANG_THEME_URL . "/lib");
define("JANG_THEME_SCSS", JANG_THEME_URL . "/scss");
define("JANG_THEME_TEMPLATES", JANG_THEME_URL . "/templates");


// Khai bao CSS bang cach su dung wp_enqueue_style(
function jang_enqueue_style() {
  // Google web font
  wp_enqueue_style("jang_theme_google_1", "https://fonts.googleapis.com", array(), "1.0", "all");
  wp_enqueue_style("jang_theme_google_2", "https://fonts.gstatic.com", array(), "1.0", "all");
  wp_enqueue_style("jang_theme_google_3", "https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap", array(), "1.0", "all");

  // Font Stylesheet
  wp_enqueue_style("jang_theme_font_1", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css", array(), "5.10.0", "all");
  wp_enqueue_style("jang_theme_font_2", "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css", array(), "1.4.1", "all");

  // Libraries Stylesheet
  wp_enqueue_style("jang_theme_lib_1", JANG_THEME_LIB . "/animate/animate.min.css", array(), "1.0", "all");
  wp_enqueue_style("jang_theme_lib_2", JANG_THEME_LIB . "/owlcarousel/assets/owl.carousel.min.css", array(), "1.0", "all");
  wp_enqueue_style("jang_theme_lib_3", JANG_THEME_LIB . "/lightbox/css/lightbox.min.css", array(), "1.0", "all");

  // Bootstrap Stylesheet
  wp_enqueue_style("jang_theme_bootstrap", JANG_THEME_CSS . "/bootstrap.min.css", array(), "1.0", "all");

  // Main Stylesheet
  wp_enqueue_style("jang_theme_style", JANG_THEME_CSS . "/style.css", array(), "1.0", "all");
}

add_action("wp_enqueue_scripts", "jang_enqueue_style");

// Khai bao scripts
function jang_enqueue_script() {
  wp_enqueue_script("jang_jquery", 'https://code.jquery.com/jquery-3.4.1.min.js', array(), "3.4.1", true);
  wp_enqueue_script("jang_bootstrap", 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js', array(), "5.0.0", true);
  wp_enqueue_script("jang_wow", JANG_THEME_LIB . "/wow/wow.min.js", array(), "1.0", true);
  wp_enqueue_script("jang_easing", JANG_THEME_LIB . "/easing/easing.min.js", array(), "1.0", true);
  wp_enqueue_script("jang_waypoints", JANG_THEME_LIB . "/waypoints/waypoints.min.js", array(), "1.0", true);
  wp_enqueue_script("jang_owlcarousel", JANG_THEME_LIB . "/owlcarousel/owl.carousel.min.js", array(), "1.0", true);
  wp_enqueue_script("jang_isotope", JANG_THEME_LIB . "/isotope/isotope.pkgd.min.js", array(), "1.0", true);
  wp_enqueue_script("jang_lightbox", JANG_THEME_LIB . "/lightbox/js/lightbox.min.js", array(), "1.0", true);

  wp_enqueue_script("jang_main", JANG_THEME_JS . "/main.js", array(), "1.0", true);
}

add_action("wp_enqueue_scripts", "jang_enqueue_script");

// Tao ham quan ly chuc nang them vao trong theme
function jang_theme_option() {
  // Them chuc nang Thumbnail
  add_theme_support("post-thumbnails");

  //Them chuc nang Title
  add_theme_support("title-tag");

  // Dang ky menu
  register_nav_menu(
    'primary',
    __('Primary Menu', 'jang')
  );

  // Tao sidebar
  $sidebar = array(
    'name' => __('Main Sidebar', 'jang'),
    'id' => "main-sidebar",
    'description' => "This is the Main Sidebar of Jang Theme",
    'class' => "main-sidebar",
    'before_title' => '<h3 class="widget-title">',
    "after_title" => "</h3>"
  );
  register_sidebar($sidebar);

  // Khai bao tep ngon ngu
  load_theme_textdomain("jang", JANG_THEME_LANG);

  // Thay doi mau sac background
  $default_background = array(
    'default-color' => "#c6c6c6",
    'default-repeat' => 'no-repeat'
  );
  add_theme_support("custom-background", $default_background);

  // Them cac loai post format
  add_theme_support("post-formats", array(
    'aside', 'gallery', 'image', 'video', 'quote', 'link'
  ));
}

add_action("init", "jang_theme_option");

// Tao danh muc services
if(!function_exists('jang_option')) {
  function jang_option($option = '', $default = null) {
    $option = get_option("jang_cs_options"); // Dat ID la duy nhat
    return (isset($option[$option])) ? $option[$option] : $default;
  }
}

class Jang_Services {
  // Build Construct Function
  // @return__void
  function __construct() {
    add_action("init", array(__CLASS__, "jang_Services_init"));
    add_filter('single_template', array($this, 'portfolio_single'));
  }

public static function jang_Services_init() {
  if(function_exists('jang_option')) {
    $slug_text = jang_option("Services_slug");
  }
  $slug = !empty($slug_text) ? $slug_text : 'dich-vu'; // https://domain.com/dich-vu/post
  register_post_type('services', array(
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => $slug),
    'capability_type' => 'post',
    'has_archive' => false,
    'hierarchical' => false,
    'show_in_rest' => true, // REST API
    'menu_position' => 20,
    'menu_icon' => 'dashicons-images-alt2',
    'supports' => array('title', 'editor', 'thumbnail', 'comments', 'elementor'),
    'labels' => array(
      'name' => _x("Dịch vụ", "jang"),
      'singular_name' => _x("Dịch vụ", "jang"),
      'menu_name' => _x("Dịch vụ", "jang"),
      'name_admin_bar' => _x("Dịch vụ", "jang"),
      'add_new' => _x("Thêm mới", "jang"),
      'add_new_item' => __("Thêm mới dịch vụ", "jang"),
      'edit_item' => __("Sửa", "jang"),
      'view_item' => __("Xem", "jang"),
      'all_items' => __("Tất cả dịch vụ", "jang"),
      'search_items' => __("Tìm kiếm dịch vụ", "jang"),
      'parent_item_colon' => __("Dịch vụ liên quan:", "jang"),
      'not_found' => __("Không tìm thấy dịch vụ.", "jang"),
      'not_found_in_trash' => __("Không tìm thấy dịch vụ nào bị xóa.", "jang")
    ),
  ));

  // Dang ky services category
  register_taxonomy("services_cat", array('services'), array(
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => trailingslashit('services_cat')),
    'labels' => array(
      'name' => _x("Danh mục", "jang"),
      'singular_name' => _x("Danh mục", "jang"),
      'search_items' => __("Tìm kiếm danh mục", "jang"),
      'all_items' => __("Tất cả danh mục", "jang"),
      'parent_item' => __('Danh mục liên quan', 'jang'),
      'parent_item_colon' => __('Danh mục liên quan:', 'jang'),
      'edit_item' => __('Sửa danh mục', 'jang'),
      'update_item' => __('Cập nhật danh mục', 'jang'),
      'add_new_item' => __('Thêm mới danh mục', 'jang'),
      'new_item_name' => __('Tên danh mục mới', 'jang'),
      'menu_name' => __('Danh mục', 'jang')
    )
  ));

  // Register services tag
  register_taxonomy("services_tag", array('services'), array(
    'hierarchical' => false,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => 'jang_Services_tag'),
    'labels' => array(
      'name' => _x("Tags", "jang"),
      'singular_name' => _x("Tags", "jang"),
      'search_items' => __("Tìm kiếm tags", "jang"),
      'all_items' => __("Tất cả tags", "jang"),
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => __('Sửa tags', 'jang'),
      'update_item' => __('Cập nhật tags', 'jang'),
      'add_new_item' => __('Thêm mới tags', 'jang'),
      'new_item_name' => __('Tên tags mới', 'jang'),
      'separate_items_with_commas' => __('Separate tag with commas', 'jang'),
      'add_or_remove_items' => __('Thêm hoặc xóa tag', 'jang'),
      'choose_from_most_used' => __('Chọn từ tags phổ biến nhất', 'jang'),
      'not_found' => __('Không tìm thấy tags.', 'jang'),
      'menu_name' => __('Tags', 'jang')
    )
  ));
}

function portfolio_single($template) {
  global $post;
  if($post->post_type == 'jang_Services') {
    $template = JANG_THEME_DIR . '/services/single.php';
  }
  return $template;
}

public static function related() {
  global $post;
  // Get the good menu tags.
  $cats = get_the_terms($post, 'jang_Services_cat');

  if($cats) {
    $cat_ids = array();

    foreach ($cats as $cat) {
      $cat_ids[] = $cat->term_id;
    }

    $post_perpage = jang_option('relpost_count') ? jang_option('relpost_count') : (int) '3';
    $args = array(
      'post_type' => 'jang_Services',
      'post__not_in' => array($post->ID),
      'posts_per_page' => 3,
      'tax_query' => array(
        array(
          'taxonomy' => 'jang_services_cat',
          'field' => 'id',
          'terms' => $cat_ids
        )
      )
    );
    $the_query = new WP_Query($args);

    }
    wp_reset_postdata();
  }
}
$portfolio = new Jang_Services();

function jang_menu() {
  $menu_args = array(
    'theme_location' => 'primary',
    'container' => '',
    'container_class' => 'collapse navbar-collapse',
    'container_id' => 'navbarCollapse',
    'menu_class' => 'navbar-nav ms-auto py-0',
    'fallback_cb' => 'false',
  );
  wp_nav_menu($menu_args);
}

function jang_nav_menu() {
  ?>
  <div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
      <a href="" class="navbar-brand p-0">
<!--        <h1 class="m-0"><i class="fa fa-search me-2"></i>SEO<span class="fs-5">Master</span></h1>-->
         <img src="/wp-content/themes/theme-custom/img/logo.svg" alt="Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
      </button>
        <?php jang_menu() ?>
        <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
        <a href="https://htmlcodex.com/startup-company-website-template" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Pro Version</a>
    </nav>
  </div>
  <?php
}

function register_my_menus() {
  register_nav_menus(array(
    'footer-menu-1' => __('Footer Menu 1'),
  ));
}
add_action('after_setup_theme', 'register_my_menus');

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
    $classes = !empty($item->classes) ? implode(' ', $item->classes) : '';
    $output .= '<li class="' . esc_attr($classes) . '">';

    $attributes = !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    // Thêm class tùy chỉnh vào thẻ <a>
    $output .= '<a class="btn btn-link" ' . $attributes . '>';
    $output .= apply_filters('the_title', $item->title, $item->ID);
    $output .= '</a>';
  }
}

function jang_footer_menu() {
  $menu_args = array(
    'theme_location' => 'footer-menu-1',
    'container' => '',
//    'menu_class' => 'col-md-6 col-lg-3',
    'fallback_cb' => false,
    'walker' => new Custom_Walker_Nav_Menu()
  );
  ?>
  <div class="col-md-6 col-lg-3">
    <h5 class="text-white mb-4">Popular Link</h5>
<?php
  wp_nav_menu($menu_args);
 ?>
  </div>
    <?php
}

// Pagination
function jang_pagination($recent_posts) {
  if ($recent_posts->max_num_pages <= 1) return; // Nếu chỉ có 1 trang, không hiển thị phân trang

  $big = 999999999; // Giá trị lớn để thay thế trong URL
  $current_page = max(1, get_query_var('paged'));

  echo '<div class="pagination">';
  echo paginate_links(array(
    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format'    => '?paged=%#%', // Format chuẩn
    'total'     => $recent_posts->max_num_pages, // Sử dụng max_num_pages của WP_Query
    'current'   => $current_page,
    'prev_text' => __('« Trước', 'jang'),
    'next_text' => __('Sau »', 'jang'),
  ));
  echo '</div>';
}

?>