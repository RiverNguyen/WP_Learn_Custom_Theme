<div class="main-content">
  <?php
  // Query chỉ lấy 3 bài viết gần nhất
  $recent_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
  ));

  // Kiểm tra xem có bài viết không
  if ($recent_posts->have_posts()) :
    while ($recent_posts->have_posts()) :
      $recent_posts->the_post();
      ?>
      <div class="recent-post">
        <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail">
            <?= get_the_post_thumbnail(get_the_ID(), "thumbnail") ?>
          </div>
        <?php endif; ?>

        <div class="post-details">
          <h2><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h2>
          <p><?= wp_trim_words(get_the_excerpt(), 20, '...') ?></p>
          <p class="post-meta">
            Tác giả: <?= get_the_author() ?> | Ngày đăng: <?= get_the_time('d/m/Y') ?>
          </p>
        </div>
      </div>
    <?php
    endwhile;
    jang_pagination($recent_posts);
    wp_reset_postdata();
  else :
    get_template_part('content', 'none');
  endif;
  ?>
</div>