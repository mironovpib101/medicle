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
    gulp.watch('src/js/**/*.js', () => {
        gulp.start(['js']);
    });
});


gulp.task('less', () => {
    gulp.src(['src/less/index.less'])
        .pipe(less())
        .pipe(autoprefixer({ browsers: ['last 2 versions'], cascade: false }))
        .pipe(cssnano())
        .pipe(concat('data/public/site/styles.css'))
        .pipe(gulp.dest('.'));
});

gulp.task('js', function () {
    gulp.src([
        'src/js/jquery.min.js',
        'src/bootstrap.min.js',
        'src/js/script.js',
    ])
        .pipe(concat('data/public/site/scripts.js'))
        .pipe(gulp.dest('.'))
});

