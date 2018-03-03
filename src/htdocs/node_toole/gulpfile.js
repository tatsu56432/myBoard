var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var pleeease = require('gulp-pleeease');//autoprefixer
var uglify = require('gulp-uglify');
var concat = require("gulp-concat");
var plumber = require("gulp-plumber");
var compass = require('gulp-compass');

//setting path
var sass_src = '../assets/_sass/';
var sass_dist = '../assets/css/';

// タスクの定義
// Sassコンパイル
gulp.task( 'sass', function() {
    gulp.src( sass_src + '*.scss' )
        .pipe(plumber())
        .pipe(sass({ outputStyle: 'expand' }))
        .pipe(gulp.dest(sass_dist))
        .pipe(pleeease({    //autoprefixer設定追記
            autoprefixer: {
                browsers: ['last 4 versions']
            },
            minifier: false //minify無効
        }))
        .pipe(gulp.dest(sass_dist));
});

gulp.task('watch', function(){
    gulp.watch(sass_src + '*.scss', ['sass']);
});

gulp.task('default', ['sass','watch']);