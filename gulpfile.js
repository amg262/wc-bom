// Require our dependencies
//const babel = require('gulp-babel');
const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const del = require('del');
const clean = require('gulp-clean');
const rename = require("gulp-rename");
const browserSync = require('browser-sync').create();
const cssnano = require('gulp-cssnano');


var paths = {
    assets: 'assets/',
    img: 'assets/img/*',
    lib: 'assets/lib/',
    dist: 'assets/dist/',
    scripts: 'assets/dist/scripts/',
    images: 'assets/dist/images/',
    includes: 'includes/',
    classes: 'classes/'
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('delete', function () {
    gulp.src(paths.images + 'img', {read: false})
        .pipe(clean());
});

// Copy all static images
gulp.task('imagemin', function () {
    gulp.src(paths.img)
    // Pass in options to the task
        .pipe(imagemin())
        .pipe(gulp.dest(paths.images));
});

gulp.task('cssnano', function () {
    gulp.src(paths.lib + '*.css')
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(paths.scripts))
});
/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function () {

    gulp.src(paths.lib + '*.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(paths.scripts));
});


// Static Server + watching scss/html files
gulp.task('serve', function () {

    browserSync.init({
        proxy: "http://www.devnet.dev/wp-admin/"
    });

});

// Rerun the task when a file changes
gulp.task('watch', function () {
    //gulp.watch(paths.scripts, ['scripts']);
    gulp.watch("classes/*.php").on('change', browserSync.reload);
    gulp.watch("assets/dist/scripts/*").on('change', browserSync.reload);
    gulp.watch("includes/*.php").on('change', browserSync.reload);
    gulp.watch("wc-bom.php").on('change', browserSync.reload);
});

gulp.task('default', ['imagemin', 'delete', 'cssnano', 'uglify', 'serve', 'watch']);
gulp.task('clean', ['imagemin', 'delete', 'cssnano', 'uglify']);
gulp.task('start', ['imagemin', 'delete', 'cssnano', 'uglify', 'serve', 'watch']);
gulp.task('live', ['serve', 'watch']);
