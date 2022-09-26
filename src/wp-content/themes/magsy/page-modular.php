<?php
/**
 * Template Name: Modular Page
 */

get_header(); ?>

<div class="content-area">
  <main class="site-main">
    <?php dynamic_sidebar( 'modules' ); ?>
  </main>
</div>

<?php get_footer(); ?>