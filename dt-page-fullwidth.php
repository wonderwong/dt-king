<?php
/* Template Name: 03. Full-width Page (Default) */
?>
<?php get_header(); ?>

<div class="main clearfix">

<?php
if( have_posts() ) {
    while( have_posts() ) { the_post(); the_content(); }
}
?>

</div>

<?php get_footer(); ?>
