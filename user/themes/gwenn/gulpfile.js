const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

function watch() {
    return gulp.watch(watch_dir, build);
}

function build() {
    gulp.src('./assets/scss/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css'));
}

exports.watch = watch
exports.build = build
exports.default = build
