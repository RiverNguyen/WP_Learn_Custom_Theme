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

function jang_nav_menu() {
  ?>
  <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
    <a href="" class="navbar-brand p-0">
      <h1 class="m-0"><i class="fa fa-search me-2"></i>SEO<span class="fs-5">Master</span></h1>
      <!-- <img src="img/logo.png" alt="Logo"> -->
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto py-0">
        <a href="index.html" class="nav-item nav-link active">Home</a>
        <a href="templates/about.php" class="nav-item nav-link">About</a>
        <a href="templates/service.php" class="nav-item nav-link">Service</a>
        <a href="templates/project.php" class="nav-item nav-link">Project</a>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
          <div class="dropdown-menu m-0">
            <a href="templates/team.php" class="dropdown-item">Our Team</a>
            <a href="templates/testimonial.php" class="dropdown-item">Testimonial</a>
            <a href="404.php" class="dropdown-item">404 Page</a>
          </div>
        </div>
        <a href="templates/contact.php" class="nav-item nav-link">Contact</a>
      </div>
      <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
      <a href="https://htmlcodex.com/startup-company-website-template" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Pro Version</a>
    </div>
  </nav>
  <?php
}

?>