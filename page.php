<?php get_header(); ?>
<?php dt_storage('have_sidebar', true); ?>

<div class="main clearfix">

<?php
if( have_posts() ) {
    while( have_posts() ) {
        the_post();
        the_content();
    }
}
?>

</div>

<?php get_footer(); ?>
