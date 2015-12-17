<?php 
/*Template Name: Articles
*/
get_header(); ?>
<?php
query_posts('cat=1');
while (have_posts()) : the_post();
the_content();
endwhile;
?>
<?php get_footer(); ?>