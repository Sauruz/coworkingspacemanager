/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var minify = require('gulp-clean-css');
var merge = require('merge-stream');
var rename = require('gulp-rename');
var flatten = require('gulp-flatten');
var del = require('del');
var runSequence = require('run-sequence');
var plumber = require('gulp-plumber');
var notify = require("gulp-notify");
var clean = require('gulp-clean');
var htmlmin = require('gulp-htmlmin');
var stripDebug = require('gulp-strip-debug');


var paths = {
    scripts: 'src/js/**/*.js',
    sass: 'src/scss/**/*.scss'
};

function handleError(err) {
    console.log(err.toString());
    this.emit('end');
}

var onError = function (err) {
    notify.onError({
        title: "Gulp",
        subtitle: "Failure!",
        message: "Error: <%= error.message %>",
        sound: "Pop"
    })(err);
    this.emit('end');
};

/**
 * ######################################################################
 * CLEAN
 * ######################################################################
 */
gulp.task('clean', function () {
    return gulp.src('dist', {read: false})
        .pipe(clean());
});

/**
 * ######################################################################
 * COPY
 * ######################################################################
 */
gulp.task('copy-i18n', function() {
    gulp.src('./bower_components/angular-i18n/**/*')
    // Perform minification tasks, etc here
    .pipe(gulp.dest('./dist/js/i18n'));
});

gulp.task('calendar-locales', function() {
    gulp.src('./bower_components/fullcalendar/dist/locale/**/*')
    // Perform minification tasks, etc here
    .pipe(gulp.dest('./dist/js/calendar-locale'));
});

/**
 * ######################################################################
 * SASS
 * ######################################################################
 */

gulp.task('css', function () {
    var scssStream = gulp.src(['./src/scss/**/*.scss'])
            .pipe(plumber({errorHandler: onError}))
            .pipe(sass())
            .pipe(concat('scss-files.scss'));

    var cssStream = gulp.src([
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'
    ])
            .pipe(concat('css-files.css'));

    var mergedStream = merge(scssStream, cssStream)
            .pipe(concat('styles.css'))
            
            //only uglify if gulp is ran with '--type production'
            .pipe(gutil.env.type === 'production' ? minify() : gutil.noop())
            .pipe(gulp.dest('dist/css'))
            .pipe(notify({
                'title': 'SASS',
                'message': 'Sass compiled and compressed',
                'icon': 'gulp_img/sass.png',
                'sound': true
            }));
});


/**
 * ######################################################################
 * JAVASCRIPT
 * ######################################################################
 */

var bowerComponents = [
    'bower_components/jquery/dist/jquery.min.js',
    'bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'bower_components/angular/angular.min.js',
    'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'bower_components/moment/min/moment.min.js',
    'bower_components/fullcalendar/dist/fullcalendar.js'
];

gulp.task('js', function () {
    return gulp.src(bowerComponents.concat([
        'src/js/App.js',
        'src/js/Ctrl.js',
        paths.scripts
    ]))
            .pipe(plumber({errorHandler: onError}))
            .pipe(concat('app.js'))
    
            //only uglify if gulp is ran with '--type production'
            .pipe(gutil.env.type === 'production' ? stripDebug() : gutil.noop())
            .pipe(gutil.env.type === 'production' ? uglify() : gutil.noop())
            .pipe(gulp.dest('dist/js'))
            .pipe(notify({
                'title': 'Javascript',
                'message': 'Javascript compiled and compressed',
                'icon': 'gulp_img/js.png',
                'sound': true
            }));
    ;
});


/**
 * ######################################################################
 * FONTS
 * ######################################################################
 */

gulp.task('fonts', function () {
    return gulp.src([
        'bower_components/bootstrap-sass/assets/fonts/bootstrap/*',
        'bower_components/font-awesome/fonts/*'
    ])
            .pipe(flatten())
            .pipe(gulp.dest('dist/fonts'))
            .pipe(notify({
                'title': 'Fonts',
                'message': 'Fonts copied',
                'icon': 'gulp_img/fonts.png',
                'sound': true
            }));
});


/**
 * ######################################################################
 * WATCH
 * ######################################################################
 */


gulp.task('watch', function () {
    gulp.watch(paths.scripts, ['js']);
    gulp.watch(paths.sass, ['css']);
});

gulp.task('default', function() {
    runSequence('clean', ['js','fonts', 'css', 'copy-i18n', 'calendar-locales']);    
});