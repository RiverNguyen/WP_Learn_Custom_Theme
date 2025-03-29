<article id="content-<?= the_ID() ?>" <?= post_class() ?>>
  <div class="content-container">
    <?php the_content() ?>
    <hr />
    <?php
    if(is_single()) {
      ?>
        <footer class="entry-footer">
          <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&versionv13.0" nonce="NONCE"></script>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
          <div class="social-share">
            <span>Share:</span>
            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink(); ?>" class="share-facebook">Facebook</a>
            <a target="_blank" href="https://twitter.com/share" class="twitter-share-button" data-url="<?= get_permalink() ?>" data-text="Noi dung ban muon chia se">Tweet</a>
          </div>
          <div class="content-tag">
            <?php
            if (has_tag()) :
            ?>
            <span class="tags-content">Tags: <?= the_tags('', ', ', '') ?></span>
            <?php endif; ?>
          </div>
        </footer>
    <?php
    } else {
      // If not a single post, dont show the post
    }
    ?>
  </div>
</article>
