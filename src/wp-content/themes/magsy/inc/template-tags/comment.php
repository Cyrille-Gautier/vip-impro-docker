<?php function magsy_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;

  if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
    <div class="comment-body">
      <?php esc_html_e( 'Pingback:', 'magsy' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'magsy' ), '<span class="edit-link">', '</span>' ); ?>
    </div>

  <?php else : ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-wrapper u-clearfix" itemscope itemtype="https://schema.org/Comment">
      <div class="comment-author-avatar vcard">
        <?php $avatar_url = get_avatar_url( $comment, $args['avatar_size'] ); ?>
        <img class="lazyload" data-src="<?php echo esc_url( $avatar_url ); ?>">
      </div>

      <div class="comment-content">
        <div class="comment-author-name vcard" itemprop="author">
          <?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
        </div>

        <div class="comment-metadata">
          <time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
            <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'magsy' ), get_comment_date(), get_comment_time() ); ?>
          </time>

          <?php
            edit_comment_link( esc_html__( 'Edit', 'magsy' ), ' <span class="edit-link">', '</span>' );
            comment_reply_link( array_merge( $args, array(
              'add_below' => 'div-comment',
              'depth'     => $depth,
              'max_depth' => $args['max_depth'],
              'before'    => '<span class="reply-link">',
              'after'     => '</span>',
            ) ) );
          ?>
        </div>

        <div class="comment-body" itemprop="comment">
          <?php comment_text(); ?>
        </div>

        <?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'magsy' ); ?></p>
        <?php endif; ?>
      </div>
    </article> <?php

  endif;
}