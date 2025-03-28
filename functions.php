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
if(!function_exists('jang-option')) {
  function jang_option($option = '', $default = null) {
    $option = get_option("jang_cs_options"); // Dat ID la duy nhat
    return (isset($option[$option])) ? $option[$option] : $default;
  }
}

class Jang_Services {
  // Build Construct Funtion
  // @return__void
  function __construct() {
    add_action("init", array(__CLASS__, "jang_services_init"));
    add_filter('single_template', array($this, 'portfolio_single_template'));
  }
}

public static function jang_Service_init() {
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
  ));
}

?>