<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
    // Post thumbnail.
    twentyfifteen_post_thumbnail();
  ?>

  <header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>

    <?php if ( !is_user_logged_in() ): ?>

      <?php $row = 1; if(get_field('sns_log_in_list')): ?>
        <div class="sns-login sns-desktop">
          <h2>SNS Login:</h2>
          <ul class="list-inline">
            <?php while(has_sub_field('sns_log_in_list')): ?>
              <li>
                <?php the_sub_field('sns_social_link'); ?>
                <?php the_sub_field('sns_social'); ?>
              </a>
              </li>
            <?php $row++; endwhile; ?>
          </ul>
        </div>
      <?php endif; ?>

    <?php endif;  ?>

    <?php
      wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
      ) );
    ?>
  </div><!-- .entry-content -->

  <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->