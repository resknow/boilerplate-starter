<?php

// Set Page Meta Tags
set('page.title', 'Home | ' . get('site.company'));
set('page.description', 'A few words about this page should be here...');

// Slider Assets
add_stylesheet('slick-css', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css');
add_script('slick-js', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css');
add_script('slick-init', '/_templates/assets/js/slick-init.js');

// Header
get_header(); ?>

    <section id="slider" class="slider">

        <div class="slide" style="background-image: url('http://placehold.it/1600x500');">
            <div class="overlay">
                <div class="caption">
                    <div class="container">
                        <h1>Slide Caption Here</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer odio augue, tincidunt feugiat lobortis vel.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="main" class="main-content">
        <div class="container">

            <main class="main">

                <h1>Main Page Title, Here</h1>
                <p>Suspendisse potenti. Etiam accumsan, quam sit amet vehicula rhoncus, dolor velit suscipit mauris, vel bibendum urna nulla et tortor. In lacinia erat eget ipsum cursus pretium.</p>
                <p>Phasellus at interdum est, eu porttitor nunc. Phasellus auctor lacus orci, eu fermentum lectus placerat eget. Vivamus ut lectus lacus. In id tortor pulvinar, facilisis justo rutrum, euismod libero.</p>
                <p>Maecenas aliquam elit arcu, vel facilisis turpis pretium sit amet. Ut sollicitudin posuere nisl, non pharetra nulla. Donec sit amet felis sed nisl tincidunt accumsan. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc dui diam, finibus at massa ut, interdum cursus tellus. Suspendisse finibus ornare lectus, nec dapibus sapien maximus ut.</p>

            </main>

            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>

        </div>
    </section>

<?php get_footer(); ?>
