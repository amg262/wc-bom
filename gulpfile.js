// Require our dependencies
//const babel = require('gulp-babel');
const gulp = require('gulp');
const pump = require('pump');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const del = require('del');
//const csslint = require('gulp-csslint');
const rename = require("gulp-rename");
const browserSync = require('browser-sync').create();
//const sass = require('gulp-sass');
const cssnano = require('gulp-cssnano');
const plumber = require('gulp-plumber');
//const postcss      = require('gulp-postcss');
//const sourcemaps   = require('gulp-sourcemaps');
//const autoprefixer = require('autoprefixer');


var paths = {
  assets:'assets/',
  img:'assets/img/',
  lib:'assets/lib/',
  dist_css:'assets/dist/css/',
  dist_js:'assets/dist/js/',
  css:'assets/lib/css/*.css',
  js:'assets/lib/js/*.js',
  includes:'includes/',
  classes:'classes/',
  fontawesome: 'assets/vendor/fontawesome/',
  sweetalert: 'assets/vendor/sweetalert/',
  chartjs: 'assets/vendor/chartjs/'
};


// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('clean', function () {
  // You can use multiple globbing patterns as you would with `gulp.src`
  return del(['build']);
});


// Copy all static images
gulp.task('images', function () {
  return gulp.src(paths.img)
  // Pass in options to the task
    .pipe(imagemin({ optimizationLevel:5 }))
    .pipe(gulp.dest(paths.img));
});


gulp.task('cssnano', function () {
  gulp.src(paths.css)
    .pipe(cssnano({
      'safe':true // Use safe optimizations.
    }))
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.dist_css))
});
/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function () {

  gulp.src(paths.js)
    .pipe(uglify())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.dist_js));

});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('vendor', function () {

  gulp.src(paths.sweetalert+'sweetalert.css')
    .pipe(cssnano())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.sweetalert));

  gulp.src(paths.fontawesome+'css/font-awesome.css')
    .pipe(cssnano())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.fontawesome+'css'));

  gulp.src(paths.chartjs+'chart.js')
    .pipe(uglify())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.chartjs));

  gulp.src(paths.sweetalert+'sweetalert-dev.js')
    .pipe(uglify())
    .pipe(rename({ suffix:'.min' }))
    .pipe(gulp.dest(paths.sweetalert));

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
gulp.task('serve', ['serve'], function () {

  browserSync.init({
    proxy:"http://www.devnet.dev"
  });

  gulp.watch("classes/*.php").on('change', browserSync.reload);
});

// Rerun the task when a file changes
gulp.task('watch', ['serve'], function () {
  //gulp.watch(paths.scripts, ['scripts']);
  gulp.watch(paths.img, ['images']);
});

gulp.task('default', ['images', 'cssnano', 'uglify']);
gulp.task('ulify', ['uglify']);
//gulp.task('uglify', ['uglify']);
// The default task (called when you run `gulp` from cli)
//gulp.task('default', ['watch', 'scripts', 'images']);
//gulp.task('default', ['watch', 'images']);
//gulp.task('scripts', ['clean']);

