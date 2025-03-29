<?= get_header() ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <header class="page-header">
      <h1 class="page-title">
        <?php
        if (is_category()) {
          single_cat_title();
        } elseif (is_tag()) {
          single_tag_title();
        } elseif (is_author()) {
          printf(__('Author: %s', 'jang'), '<span class="vcard">' . get_the_author() . '</span>');
        } elseif (is_home()) {
          echo "Trang chủ";
        } else {
          _e('Archives', 'jang');
        }
        ?>
      </h1>
    </header>

    <?= get_template_part('templates/news') ?>

  </main>
  <?php get_sidebar() ?>
</div>

<?= get_footer() ?>
