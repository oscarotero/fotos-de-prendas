"use strict";

let path    = require("path"),
    webpack = require("webpack"),
    bower   = require("bower-webpack-plugin");

module.exports = {
    context: __dirname + '/assets/js',
    entry: {
        main: './main.js'
    },
    output: {
        path: __dirname + '/public/js',
        filename: '[name].js'
    },
    resolve: {
        modulesDirectories: ['bower_components'],
        alias: {
            'fancybox': 'fancybox/source/jquery.fancybox.js',
            'jquery-filedrop': 'jquery-filedrop/jquery.filedrop.js'
        }
    },
    plugins: [
        new bower({
            excludes: /\.css$/
        })
    ]
};
