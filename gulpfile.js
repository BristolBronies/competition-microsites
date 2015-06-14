var gulp = require("gulp");
var util = require("gulp-util");
var newer = require("gulp-newer");
var sass = require("gulp-sass");
var autoprefixer = require("gulp-autoprefixer");
var imagemin = require("gulp-imagemin");
var uglify = require("gulp-uglify");
var concat = require("gulp-concat");

var paths = {
	css: { src: "./src/scss/", dst: "./dst/css/" },
	js: { src: "./src/js/scripts/", dst: "./dst/js/" },
	jsV: { src: "./src/js/vendor/", dst: "./dst/js/" },
	jsP: { src: "./src/js/preload/", dst: "./dst/js/" },
	images: { src: "./src/images/", dst: "./dst/images/" },
	fonts: { src: "./src/type/", dst: "./dst/type/" }
};

gulp.task("default", function() {
	gulp.watch(paths.css.src + "{,*/}*.scss", ["stylesheets"]);
	gulp.watch(paths.js.src + "{,*/}*.js", ["scripts"]);
	gulp.watch(paths.jsV.src + "{,*/}*.js", ["scriptsVendor"]);
	gulp.watch(paths.jsP.src + "{,*/}*.js", ["scriptsPreload"]);
	gulp.watch(paths.images.src + "*/*", ["images"]);
	gulp.watch(paths.fonts.src + "*/*", ["fonts"]);
});

gulp.task("force", ["stylesheets", "scripts", "scriptsVendor", "scriptsPreload", "images", "fonts"]);

gulp.task("stylesheets", function() {
	gulp.src(paths.css.src + "stylesheet.scss")
	.pipe(sass({
		errLogToConsole: true,
		outputStyle: "compressed"
	}))
	.pipe(autoprefixer({
		browsers: ["last 2 version", "ie 8", "ie 9"],
		cascade: true
	}))
	.pipe(gulp.dest(paths.css.dst))
});

gulp.task("scripts", function() {
	gulp.src(paths.js.src + "*.js")
	.pipe(uglify().on("error", util.log))
	.pipe(concat("scripts.js"))
	.pipe(gulp.dest(paths.js.dst))
});

gulp.task("scriptsVendor", function() {
	gulp.src(paths.jsV.src + "*.js")
	.pipe(uglify().on("error", util.log))
	.pipe(concat("vendor.js"))
	.pipe(gulp.dest(paths.jsV.dst))
});

gulp.task("scriptsPreload", function() {
	gulp.src(paths.jsP.src + "*.js")
	.pipe(uglify().on("error", util.log))
	.pipe(concat("preload.js"))
	.pipe(gulp.dest(paths.jsP.dst))
});

gulp.task("images", function() {
	gulp.src(paths.images.src + "*")
	.pipe(newer(paths.images.dst))
	.pipe(imagemin({
		optimizationLevel: 5,
		progressive: true,
		interlaced: true,
		multipass: true
	}))
	.pipe(gulp.dest(paths.images.dst))
});

gulp.task("fonts", function() {
	gulp.src(paths.fonts.src)
	.pipe(gulp.dest(paths.fonts.dst))
});