var gulp = require('gulp'),
rename = require('gulp-rename'),
sass = require('gulp-sass'),
autoprefixer = require('gulp-autoprefixer'),
notify = require('gulp-notify'),
sourcemaps = require('gulp-sourcemaps'),
watch = require('gulp-watch'),
browserSync = require('browser-sync').create();

gulp.task('styles', function() {
    gulp.src('./library/scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 Chrome versions']
        }))
        .pipe(sourcemaps.write('./', {includeContent: false, sourceRoot: '../scss'}))
        .pipe(gulp.dest('./library/css'))
        .pipe(browserSync.stream())
        .pipe(notify({ message: 'Styles task complete' }));
});

// Static Server + watching scss/html files
gulp.task('serve', ['styles'], function() {

    browserSync.init({
        proxy: "nm.dev"
    });

    gulp.watch('./library/scss/*.scss', ['styles']);
    gulp.watch("*.php").on('change', browserSync.reload);
});

gulp.task('default', ['serve']);