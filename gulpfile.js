var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var sourcemaps = require('gulp-sourcemaps');
var del = require('del');
var csslint = require('gulp-csslint');


var paths = {
    images: 'assets/images/*',
    css: 'assets/css/*',
    js: 'assets/js/*'
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('clean', function () {
    // You can use multiple globbing patterns as you would with `gulp.src`
    return del(['build']);
});

gulp.task('scripts', ['clean'], function () {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    return gulp.src(paths.scripts)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('all.min.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('assets/js'));
});

// Copy all static images
gulp.task('images', ['clean'], function () {
    return gulp.src(paths.images)
    // Pass in options to the task
        .pipe(imagemin({optimizationLevel: 5}))
        .pipe(gulp.dest('build/img'));
});

// Rerun the task when a file changes
gulp.task('watch', function () {
    //gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.images, ['images']);
});

gulp.task('css', function () {
    gulp.src('assets/css/*.css')c
        .pipe(csslint())
        .pipe(csslint.formatter());
});
/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function () {
    gulp.src(paths.js)
        .pipe(rename({'suffix': '.min'}))
        .pipe(uglify({
            'mangle': false
        }))
        .pipe(gulp.dest('assets/js'));
});


// The default task (called when you run `gulp` from cli)
//gulp.task('default', ['watch', 'scripts', 'images']);
gulp.task('default', ['watch', 'images']);
gulp.task('scripts', ['uglify']);

