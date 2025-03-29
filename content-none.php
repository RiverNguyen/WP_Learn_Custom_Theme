<section class="content-none">
  <header class="page-header">
    <h1 class="page-title"><?php _e("Nothing found", "jang")  ?></h1>
  </header>
  <div class="page-content-none">
    <?php if (is_search()) : ?>
      <p><?php _e("Sorry, but nothing matched your search terms. Please try again with some different keywords.", "jang") ?></p>
    <?php get_search_form() ?>
    <?php else : ?>
      <p> <?php _e("It seems we cannot find what your search", "jang") ?></p>
    <?php endif; ?>
  </div>
</section>