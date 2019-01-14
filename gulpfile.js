const gulp          = require('gulp');
const concat        = require('gulp-concat');
const less          = require('gulp-less');
const cssnano       = require('gulp-cssnano');
const autoprefixer  = require('gulp-autoprefixer');

gulp.task('default', () => {
    gulp.start(['less', 'watch']);
});

gulp.task('watch', () => {
    gulp.watch('src/less/**/*.less', () => {
        gulp.start(['less']);
    });
});


gulp.task('less', () => {
    gulp.src(['src/less/index.less'])
        .pipe(less())
        .pipe(autoprefixer({ browsers: ['last 2 versions'], cascade: false }))
        .pipe(cssnano())
        .pipe(concat('site/styles.css'))
        .pipe(gulp.dest('.'));
});
