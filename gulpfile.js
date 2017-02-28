// Require our dependencies
const autoprefixer = require('autoprefixer');
const babel = require('gulp-babel');
const gulp = require('gulp');
const pump = require('pump');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const del = require('del');
const csslint = require('gulp-csslint');
const rename = require("gulp-rename");
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass');
const cssnano = require('gulp-cssnano');
const plumber = require('gulp-plumber');
const postcss      = require('gulp-postcss');
const sourcemaps   = require('gulp-sourcemaps');
const autoprefixer = require('autoprefixer');


var paths = {
  images:'assets/images/*',
  css:'assets/css/*',
  js:'assets/js/*'
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
    .pipe(imagemin({ optimizationLevel:5 }))
    .pipe(gulp.dest('build/img'));
});

// Rerun the task when a file changes
gulp.task('watch', function () {
  //gulp.watch(paths.scripts, ['scripts']);
  gulp.watch(paths.images, ['images']);
});

gulp.task('css', function () {
  gulp.src('assets/css/*.css')
    .pipe(csslint())
    .pipe(csslint.formatter());
});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('compress', function () {

  gulp.src('assets/js/*.js')
    .pipe(uglify())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest('assets/js/'));

});

// Static server
gulp.task('browser-sync', function () {
  browserSync.init({
    server:{
      baseDir:"./"
    }
  });
});


// Static Server + watching scss/html files
gulp.task('serve', ['sass'], function () {

  browserSync.init({
    proxy:"http://www.devnet.dev"
  });

  //gulp.watch("assets/scss/*.scss", ['sass']);
  gulp.watch("classes/*.php").on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function () {
  return gulp.src("app/scss/*.scss")
    .pipe(sass())
    .pipe(gulp.dest("app/css"))
    .pipe(browserSync.stream());
});

gulp.task('cssnano', function () {
  gulp.src('assets/css/*.css')
  // .pipe(plumber({'errorHandler': handleErrors}))
    .pipe(cssnano({
      'safe':true // Use safe optimizations.
    }))
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest('includes'))
  //.pipe( browserSync.stream() )
});


gulp.task('default', ['serve']);
// The default task (called when you run `gulp` from cli)
//gulp.task('default', ['watch', 'scripts', 'images']);
gulp.task('default', ['watch', 'images']);
gulp.task('scripts', ['uglify']);

