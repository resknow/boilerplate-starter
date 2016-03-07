<?php

/**
 * Set Page Meta Tags
 */
set('page.title', 'Page Not Found | ' . get('site.company'));
set('page.description', 'The page you were looking for could not be found.');

get_header(); ?>

    <h1>Page Not Found.</h1>
    <p>Sorry, the page you were looking for could not be found.</p>

<?php get_footer(); ?>
