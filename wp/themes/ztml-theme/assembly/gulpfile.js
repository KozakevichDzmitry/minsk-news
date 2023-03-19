import * as nodePath from 'path'
import * as fs from 'fs';
import gulp from 'gulp'
import {deleteAsync} from 'del'
import concat from "gulp-concat"
import plumber from "gulp-plumber"
import notify from "gulp-notify"
import versionNumber from "gulp-version-number"
import ifPlugin from "gulp-if"

import dartSass from 'sass'
import gulpSass from 'gulp-sass'
import rename from 'gulp-rename'


import importCss from "gulp-import-css"
import minifyCSS from "gulp-minify-css"
import autoprefixer from "gulp-autoprefixer"
import groupCssMediaQueries from "gulp-group-css-media-queries"

import browsersync from "browser-sync"
import webpack from "webpack";
import webpackStream from "webpack-stream";
import uglify from "gulp-uglify"

import imagemin, {gifsicle, mozjpeg, optipng, svgo} from "gulp-imagemin";
import newer from "gulp-newer";
import webp from "gulp-webp";


const rootFolder = nodePath.basename(nodePath.resolve())
const buildFolder = '../assets'
const srcFolder = './src'
const AUTOPREFIXER_BROWSERS = {
    overrideBrowserslist: ['last 8 versions'],
    browsers: [
        'Android >= 4',
        'Chrome >= 20',
        'Firefox >= 24',
        'Explorer >= 11',
        'iOS >= 6',
        'Opera >= 12',
        'Safari >= 6',
    ],
    grid: true,
    cascade: true
}
const isDev = !process.argv.includes('--prod')
const isProd = process.argv.includes('--prod')
const path = {
    build: {
        files: `${buildFolder}/files/`,
        css: `${buildFolder}/styles/`,
        js: `${buildFolder}/js`,
        img: `${buildFolder}/images/`,
        svg: `${buildFolder}/images/`,
        fonts: `${buildFolder}/fonts/`,
    },
    src: {
        files: `${srcFolder}/files/**/*.*`,
        css: `${srcFolder}/styles/style.scss`,
        js: `${srcFolder}/scripts/*.js`,
        img: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,webp}`,
        svg: `${srcFolder}/images/**/*.svg`,
        fonts: `${srcFolder}/fonts/*.*`,
    },
    watch: {
        files: `${srcFolder}/files/**/*.*`,
        css: `${srcFolder}/styles/**/*.scss`,
        js: `${srcFolder}/scripts/**/*.js`,
        img: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,webp,svg}`,
    },
    clean: buildFolder,
    srcFolder: srcFolder,
    rootFolder: rootFolder
}

const templateDir = './src/scripts/pages/';

const entryPoints = {
    'main-head': './src/scripts/main-head.js',
    'main-footer': './src/scripts/main-footer.js',
    'aaq': './src/scripts/pages/aaq/index.js',
    'about': './src/scripts/pages/about/index.js',
    'advertisement': './src/scripts/pages/advertisement/index.js',
    'all-news': './src/scripts/pages/all-news/index.js',
    'all-videos': './src/scripts/pages/all-videos/index.js',
    'appeal': './src/scripts/pages/appeal/index.js',
    'author': './src/scripts/pages/author/index.js',
    'authors-column': './src/scripts/pages/authors-column/index.js',
    'cae': './src/scripts/pages/cae/index.js',
    'event': './src/scripts/pages/event/index.js',
    'home': './src/scripts/pages/home/index.js',
    'management': './src/scripts/pages/management/index.js',
    'radio-minsk': './src/scripts/pages/radio-minsk/index.js',
    'satms': './src/scripts/pages/satms/index.js',
    'single-cae': './src/scripts/pages/single-cae/index.js',
    'single-authors-column': './src/scripts/pages/single-authors-column/index.js',
    'single-district': './src/scripts/pages/single-district/index.js',
    'single-event': './src/scripts/pages/single-event/index.js',
    'single-news': './src/scripts/pages/single-news/index.js',
    'single-satm': './src/scripts/pages/single-satm/index.js',
    'take-action': './src/scripts/pages/take-action/index.js',
    'taxonomy-news-list': './src/scripts/pages/taxonomy-news-list/index.js',
    'taxonomy-meri-list': './src/scripts/pages/taxonomy-meri-list/index.js',
    'taxonomy-newspapers': './src/scripts/pages/taxonomy-newspapers/index.js',
    'taxonomy-videos': './src/scripts/pages/taxonomy-newspapers/index.js',
    'tv-programme': './src/scripts/pages/taxonomy-newspapers/index.js',
    'your-district': './src/scripts/pages/taxonomy-newspapers/index.js',
    'sockets': './src/scripts/components/sockets.js',
    'calendar': './src/scripts/components/calendar.js',
    'sidebar': './src/scripts/components/sidebar.js',
};

const webpackConf = {
    mode: isDev ? 'development' : 'production',
    optimization: {
        minimize: false
    },
    entry: entryPoints,
    output: {
        filename: '[name].min.js',
    },
    module: {
        rules: [
            {
                test: /\.(js)$/,
                exclude: /(node_modules)/,
                loader: 'babel-loader'
            }
        ]
    }
}

const sass = gulpSass(dartSass)
const scss = () => {
    return gulp.src(path.src.css, {sourcemaps: isDev})
        .pipe(plumber(notify.onError({
            title: "Error in CSS",
            message: "Error: <%= error.message %>"
        })))
        .pipe(sass())
        .pipe(ifPlugin(isProd, groupCssMediaQueries()))
        .pipe(ifPlugin(isProd, autoprefixer(AUTOPREFIXER_BROWSERS)))
        .pipe(ifPlugin(isProd, minifyCSS()))
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest(path.build.css))
        .pipe(browsersync.stream())
}
const css = () => {
    return gulp.src(path.src.css, {sourcemaps: isDev})
        .pipe(plumber(notify.onError({
            title: "Error in CSS",
            message: "Error: <%= error.message %>"
        })))
        .pipe(importCss())
        .pipe(concat("style.min.css"))
        .pipe(ifPlugin(isProd, groupCssMediaQueries()))
        .pipe(ifPlugin(isProd, minifyCSS()))
        .pipe(ifPlugin(isProd, autoprefixer(AUTOPREFIXER_BROWSERS)))
        .pipe(gulp.dest(path.build.css))
        .pipe(browsersync.stream())
}

const js = () => {
    return gulp.src(path.src.js, {sourcemaps: isDev})
        .pipe(plumber(notify.onError({
            title: "Error in JS",
            message: "Error: <%= error.message %>"
        })))
        .pipe(webpackStream(webpackConf, webpack))
        .pipe(ifPlugin(isProd, uglify()))
        .pipe(gulp.dest(path.build.js))
        .pipe(browsersync.stream())
}

const copy = () => {
    return gulp.src(path.src.files)
        .pipe(gulp.dest(path.build.files))
}

const img = () => {
    return gulp.src(path.src.img)
        // .pipe(ifPlugin(isProd, newer(path.build.img)))
        // .pipe(ifPlugin(isProd, webp()))
        // .pipe(ifPlugin(isProd, gulp.dest(path.build.img)))
        // .pipe(ifPlugin(isProd, gulp.src(path.src.img)))
        // .pipe(ifPlugin(isProd, newer(path.build.img)))
        // .pipe(ifPlugin(isProd, imagemin([
        //     gifsicle({interlaced: true}),
        //     mozjpeg({quality: 75, progressive: true}),
        //     optipng({optimizationLevel: 5}),
        // ])))
        .pipe(gulp.dest(path.build.img))
        .pipe(gulp.src(path.src.svg))
        .pipe(gulp.dest(path.build.img))
        .pipe(browsersync.stream())
}

const fonts = () => {
    return gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.build.fonts))
}

const watcher = () => {
    gulp.watch(path.watch.files, copy)
    gulp.watch(path.watch.css, css)
    gulp.watch(path.watch.js, js)
    gulp.watch(path.watch.img, img)
}
const server = (done) => {
    browsersync.init({
        proxy: {
            target: 'http://localhost:3000/',
            ws: true
        },
        notify: false,
        open: false
    })
}
const reset = () => {
    return deleteAsync(path.clean, {force: true})
}

const mainTasks = gulp.parallel(js, scss, img)

const dev = gulp.series(reset, mainTasks, gulp.parallel(watcher, server))
const prod = gulp.series(reset, mainTasks)

export {dev}
export {prod}

gulp.task('default', dev)