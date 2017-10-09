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
var zip = require('gulp-zip');
var fs = require("fs");


var paths = {
    scripts: 'src/js/**/*.js',
    sass: 'src/scss/**/*.scss',
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

function getLatestVersionName() {
    var files = fs.readdirSync('releases');
    var lastFile = files[files.length - 1];
    var lastFileArr = lastFile.split(".");
    var subVersion = parseInt(lastFileArr[lastFileArr.length - 2]);
    lastFileArr[lastFileArr.length - 2] = subVersion + 1;
    var newFileName = lastFileArr.join('.');
    return newFileName;
}

/**
 * ######################################################################
 * CLEAN
 * ######################################################################
 */
gulp.task('clean', function () {
    return gulp.src(['dist', '_coworkingspacemanager', 'coworkingspacemanager.zip'], {read: false})
        .pipe(clean());
});

gulp.task('clean_distro', function () {
    return gulp.src(['csm-codecanyon-pack/_coworkingspacemanager'], {read: false})
        .pipe(clean());
});

gulp.task('clean_codecayon_package', function () {
    return gulp.src(['csm-codecanyon-pack'], {read: false})
        .pipe(clean());
});

/**
 * ######################################################################
 * COPY
 * ######################################################################
 */
gulp.task('copy-i18n', function () {
    gulp.src('./bower_components/angular-i18n/**/*')
    // Perform minification tasks, etc here
        .pipe(gulp.dest('./dist/js/i18n'));
});

gulp.task('calendar-locales', function () {
    gulp.src('./bower_components/fullcalendar/dist/locale/**/*')
    // Perform minification tasks, etc here
        .pipe(gulp.dest('./dist/js/calendar-locale'));
});

gulp.task('copy-images', function () {
    gulp.src('./src/img/**/*')
        .pipe(gulp.dest('./dist/img'));
});

gulp.task('copy-documentation', function () {
    gulp.src('./codecanyon-files/documentation/**/*')
        .pipe(gulp.dest('./csm-codecanyon-pack/documentation'));
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

    return merge(scssStream, cssStream)
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
    'bower_components/fullcalendar/dist/fullcalendar.js',
    'bower_components/angular-bootstrap/ui-bootstrap.min.js',
    'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'
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

gulp.task('default', function () {
    runSequence('clean', ['js', 'fonts', 'css', 'copy-i18n', 'calendar-locales', 'copy-images']);
});

/**
 * ######################################################################
 * MAKE DISTRO
 * ######################################################################
 */

gulp.task('distro', function () {
    runSequence('clean',
        [
            'copy-documentation'
        ], [
            'js',
            'fonts',
            'css',
            'copy-i18n',
            'calendar-locales',
            'copy-images'
        ],
        [
            'make_distro'
        ],
        [
            'zip-plugin'
        ],
        [
            'clean_distro'
        ],
        [
            'zip-codecayon-package'
        ],
        [
             'clean_codecayon_package'
        ]
    );
});

gulp.task('make_distro', function () {
    return gulp.src([
        'app/**/*',
        'dist/**/*',
        'install/**/*',
        'vendor/**/*',
        'coworkingspacemanager.php',
        'routing.php'
    ], {base: "."})
        .pipe(gulp.dest('csm-codecanyon-pack/_coworkingspacemanager/'));
});

/**
 * ######################################################################
 * ZIP PLUGIN
 * ######################################################################
 */
gulp.task('zip-plugin', function () {
    return gulp.src('csm-codecanyon-pack/_coworkingspacemanager/**/*')
        .pipe(zip('csm-codecanyon-pack/coworkingspacemanager.zip'))
        .pipe(gulp.dest('.'));
});

gulp.task('zip-codecayon-package', function () {
    var newFileName = getLatestVersionName();

    return gulp.src('csm-codecanyon-pack/**/*')
        .pipe(zip('releases/' + newFileName))
        .pipe(gulp.dest('.'));
});