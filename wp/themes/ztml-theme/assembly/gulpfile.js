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
import webpcss from "gulp-webpcss"
import autoprefixer from "gulp-autoprefixer"
import groupCssMediaQueries from "gulp-group-css-media-queries"
import webHtmlNosvg from "gulp-webp-html-nosvg"


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
        html: `${buildFolder}/`,
        css: `${buildFolder}/styles/`,
        js: `${buildFolder}/js`,
        img: `${buildFolder}/images/`,
        svg: `${buildFolder}/images/`,
        fonts: `${buildFolder}/fonts/`,
    },
    src: {
        files: `${srcFolder}/files/**/*.*`,
        html: `${srcFolder}/*.html`,
        css: `${srcFolder}/styles/style.scss`,
        js: `${srcFolder}/scripts/index.js`,
        img: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,webp}`,
        svg: `${srcFolder}/images/**/*.svg`,
        fonts: `${srcFolder}/fonts/*.*`,
    },
    watch: {
        files: `${srcFolder}/files/**/*.*`,
        html: `${srcFolder}/*.html`,
        css: `${srcFolder}/styles/**/*.css`,
        js: `${srcFolder}/js/**/*.js`,
        img: `${srcFolder}/images/**/*.{jpg,jpeg,png,gif,webp,svg}`,
    },
    clean: buildFolder,
    srcFolder: srcFolder,
    rootFolder: rootFolder
}

const templateDir = './src/scripts/pages/';

const readdirSync = (path, fName = null, dirName= null, result = {}) => {
    if (fs.statSync(path).isDirectory()) {
        const list = fs.readdirSync(path)
        dirName = fName
        list.forEach(fileName => {
            readdirSync(nodePath.join(path, fileName),fileName,dirName, result)
        })
    }else {
        if (fName === 'index.js') {
            const posixPath =(winPath)=> winPath.replace(/\\/g, '/')
            result[dirName] = `./${posixPath(path)}`
        }
    }

    return result
}
const webpackentryPoints = {
    'main': './src/scripts/index.js',
    ...readdirSync(templateDir)
};
console.log(webpackentryPoints)


const webpackConf = {
    mode: isDev ? 'development' : 'production',
    optimization: {
        minimize: false
    },
    entry: webpackentryPoints,
    output: {
        filename: isProd? '[name].min.js':'[name].js',
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

const html = () => {
    return gulp.src(path.src.html)
        .pipe(ifPlugin(isProd, webHtmlNosvg()))
        .pipe(ifPlugin(isProd, versionNumber({
            value: '%DT%',
            append: {
                key: '_v',
                cover: 0,
                to: [
                    'css',
                    'js'
                ]
            },
            output: {
                file: './version.json'
            }
        })))
        .pipe(gulp.dest(path.build.html))
        .pipe(browsersync.stream())
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
        .pipe(ifPlugin(isProd, webpcss({webpClass: ".webp", noWebpClass: ".no-webp"})))
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
        .pipe(ifPlugin(isProd, newer(path.build.img)))
        .pipe(ifPlugin(isProd, webp()))
        .pipe(ifPlugin(isProd, gulp.dest(path.build.img)))
        .pipe(ifPlugin(isProd, gulp.src(path.src.img)))
        .pipe(ifPlugin(isProd, newer(path.build.img)))
        .pipe(ifPlugin(isProd, imagemin([
            gifsicle({interlaced: true}),
            mozjpeg({quality: 75, progressive: true}),
            optipng({optimizationLevel: 5}),
        ])))
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
    gulp.watch(path.watch.html, html)
    gulp.watch(path.watch.css, css)
    gulp.watch(path.watch.js, js)
    gulp.watch(path.watch.img, img)
}
const server = (done) => {
    browsersync.init({
        server: {
            baseDir: `${path.build.html}`
        },
        notify: true,
        port: 3000
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