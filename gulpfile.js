var gulp            = require('gulp'),
    sass            = require('gulp-ruby-sass'),
    cssnano         = require('gulp-cssnano'),
    uglify          = require('gulp-uglify'),
    rename          = require('gulp-rename'),
    concat          = require('gulp-concat'),
    notify          = require('gulp-notify'),
    plumber         = require('gulp-plumber'),
    del             = require('del'),
    autoprefixer    = require('gulp-autoprefixer');

// Style Tasks
gulp.task('styles', function() {
    return sass('_templates/assets/sass/style.scss', { style: 'expanded' })
    .pipe(plumber())
    .pipe(gulp.dest('_templates/assets/css'))
    .pipe(autoprefixer({cascade: false}))
    .pipe(cssnano())
    .pipe(gulp.dest('_templates/assets/css'))
    .pipe(notify({ message: 'CSS compiled' }));
});

// Javascript Tasks
gulp.task('scripts', function() {
    return gulp.src(['_templates/assets/js/source/*.js', '_templates/assets/js/source/vendor/*.js'], { base: '_templates/assets/js' })
    .pipe(plumber())
    .pipe(concat('main.js'))
    .pipe(gulp.dest('_templates/assets/js'))
    .pipe(uglify())
    .pipe(gulp.dest('_templates/assets/js'))
    .pipe(notify({ message: 'Javascript compiled' }));
});

// Housekeeping
gulp.task('clean', function(cb) {
    del(['_templates/assets/css'], cb)
});

// Default task
gulp.task('default', ['clean'], function() {
    gulp.start('styles', 'scripts');
});

// Watch
gulp.task('watch', function() {

    // Watch .scss files
    gulp.watch(['_templates/assets/sass/*.scss', '_templates/assets/sass/**/*.scss'], ['styles']);

    // Watch .js files
    gulp.watch(['_templates/assets/js/source/*.js', '_templates/assets/js/source/**/*.js'], ['scripts']);

});
