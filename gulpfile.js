const gulp = require('gulp');
const watch = require('gulp-watch');
const concat = require('gulp-concat');
const babel = require('gulp-babel');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();

const JS_SRC = 'main.js';
const JS_SRC_WATCH = 'resources/assets/js/*.js';
const JS_DEST = 'public/js';

const CSS_SRC = 'resources/assets/scss/main.scss';
const CSS_SRC_WATCH = 'resources/assets/scss/*.scss';
const CSS_DEST = 'public/css';

gulp.task('watch-js', () => {
	return watch(JS_SRC_WATCH, { verbose: true, ignoreInitial: false }, buildJS);
});

gulp.task('build-js', buildJS);

function buildJS() {
	return gulp
		.src(JS_SRC_WATCH)
		.pipe(concat(JS_SRC))
		.pipe(babel())
		.on('error', function(error) {
			console.log(error.toString());
			this.emit('end');
		})
		.pipe(gulp.dest(JS_DEST));
}

gulp.task('watch-css', () => {
	return watch(CSS_SRC_WATCH, { verbose: true, ignoreInitial: false }, buildCSS);
});

gulp.task('build-css', buildCSS);

function buildCSS() {
	return gulp
		.src(CSS_SRC)
		.pipe(sass({ outputStyle: 'compressed' }))
		.on('error', function(error) {
			console.log(error.toString());
			this.emit('end');
		})
		.pipe(autoprefixer({ cascade: false }))
		.pipe(gulp.dest(CSS_DEST));
}

gulp.task('auto-reload', () => {
	browserSync.init({ proxy: 'http://localhost' });

	return watch(['resources/**'], { verbose: true, ignoreInitial: false }, () => {
		browserSync.reload();
	});
});

gulp.task('watch', ['watch-js', 'watch-css', 'auto-reload']);
gulp.task('build', ['build-js', 'build-css']);
