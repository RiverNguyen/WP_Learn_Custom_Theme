<div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container py-5 px-lg-5">
    <div class="row g-5">
      <div class="col-md-6 col-lg-3">
        <h5 class="text-white mb-4">Get In Touch</h5>
        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
        <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
        <div class="d-flex pt-2">
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <?php
      jang_footer_menu()
      ?>
      <div class="col-md-6 col-lg-3">
        <h5 class="text-white mb-4">Project Gallery</h5>
        <div class="row g-2">
          <?php if( have_rows('footer_images') ): ?>
              <?php while( have_rows('footer_images') ): the_row();
                $image = get_sub_field('footer-image');
                if( $image ): ?>
                  <div class="col-4">
                    <img class="img-fluid rounded-1" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                  </div>
                <?php endif; ?>
              <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <h5 class="text-white mb-4">Newsletter</h5>
        <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulpu</p>
        <div class="position-relative w-100 mt-3">

          <?php
          if(function_exists('do_shortcode')) {
            echo do_shortcode('[contact-form-7 id="7fcba21" title="Email"]');
            ?>
            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
            <?php

          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container px-lg-5">
    <div class="copyright">
      <div class="row">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
          Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="footer-menu">
            <a href="">Home</a>
            <a href="">Cookies</a>
            <a href="">Help</a>
            <a href="">FQAs</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
</div>

<?php wp_footer(); ?>

</body>

</html>