/**
 * Package: dutapod-companion
 * Author: Leon Nguyen (sonnh2109@gmail.com)
*/


/**============================================================= **/
/**=== 1. Declare module variables ===  **/
/**============================================================= **/
/** Search for gulp package in nodejs directory **/
// File system
import { readdir } from 'fs';
import fs from 'fs';
import path from 'path';
const fsPromise = fs.promises;

// gulp task
import gulp from 'gulp';
import gulpBabel from 'gulp-babel';
import gulpCached from 'gulp-cached';
import gulpDebug from 'gulp-debug';
import * as sass from 'sass';

import gulpSassInstance from 'gulp-sass';
var gulpSass = gulpSassInstance( sass );

import gulpRenamer from 'gulp-rename';
import gulpAutoPrefixer from 'gulp-autoprefixer';
import autoPrefixer from 'autoprefixer';
// import sourceMaps from 'gulp-sourcemaps';
import gulpSourceMaps from 'gulp-sourcemaps';
import browserify from 'browserify';
import babelify from 'babelify';
import vinylSource from 'vinyl-source-stream';
import vinylBuffer from 'vinyl-buffer';
import gulpUglify from 'gulp-uglify';
import gulpPlumber from 'gulp-plumber';
import vinylSourceStream from 'vinyl-source-stream';
import * as glob from 'glob';
// var glob = require('glob');

// Tailwind variables
import gulpPostCSS from 'gulp-postcss';
import tailwindCSS from 'tailwindcss';

// 
import browserSyncInstance from 'browser-sync';

var browserSync = browserSyncInstance.create();
var browserReloader = browserSync.reload();



/**============================================================= **/
/**=== 2. Variables for relevant Gulp task === **/
/**============================================================= **/

/** 
 * 2.1. Variable naming explanation
 * - srcDir : Source Directory.
 * + This is a relative path starting from the current root plugin directory
 * - distDir : Distribution directory - where SCSS & ES6 JS are compiled to CSS & ES5 JS
 * **/

const resourcesInfo = {
    styles:{
        prelib:{
            srcBootstrapFile:'node_modules/bootstrap/scss/bootstrap.scss',
            srcDir:'./sources/scope-prelib/scss/',
            srcListFile:'./sources/scope-prelib/scss/*.scss',
            distDir:'./assets/scope-prelib/css/'
        },
        admin:{
            scrDir:'./sources/scope-admin/scss/',
            scrListFile:'./sources/scope-admin/scss/*.scss',
            distDir:'./assets/scope-admin/css/',
        },
        editor:{
            srcDir:'./sources/scope-editor/scss/',
            scrListFile:'./sources/scope-editor/scss/*.scss',
            distDir:'./assets/scope-editor/css/',
        },
        frontend:{
            srcDir:'./sources/scope-frontend/scss/',
            srcListFile:'./sources/scope-frontend/scss/**/*.scss',
            distDir:'./assets/scope-frontend/css/',
        }
    },
    scripts:{
        prelib:{
            srcDir:'./sources/scope-prelib/js/',
            srcListFile:'./sources/scope-prelib/js/*.js',
            distDir:'./assets/scope-prelib/js/'
        },
        admin:{
            srcDir:'./sources/scope-admin/js/',
            srcListFile:'./sources/scope-admin/js/*.js',
            distDir:'./assets/scope-admin/js/'
        },
        editor:{
            srcDir:'./sources/scope-editor/js/',
            srcListFile:'./sources/scope-editor/js/*.js',
            distDir:'./assets/scope-editor/js/'
        },
        frontend:{
            srcDir:'./sources/scope-frontend/js/',
            srcListFile:'./sources/scope-frontend/js/*.js',
            distDir:'./assets/scope-frontend/js/'
        }
    }
}

/**============================================================= **/
/**=== 3. Gulp tasks definition - defining elemental tasks === **/
/** All elemental tasks must be defined before declaring composite gulp tasks */
/**============================================================= **/


/**=== 3.1. Distribute all styles files - SCSS to CSS === **/

gulp.task( 'distribute-all-frontend-styles', distribute_all_frontend_styles );

/**=== 3.1.1. Distribute all prelib styles files for frontend display === **/

gulp.task('distribute-prelib-tailwindcss-styles', function( done ){
    
    let srcStyleFile = './sources/scope-prelib/scss/tailwindcss-full.scss';
    let distStyleDir = './assets/scope-prelib/css/';    

    distribute_prelib_tailwind_styles( srcStyleFile, distStyleDir );

    done();
});

/** Can use to distribute any style file with @tailwind base, components directives */
function distribute_prelib_tailwind_styles(srcStyleFile, distStyleDir){
    return gulp.src( srcStyleFile )
        .pipe( gulpPlumber() )
        .pipe( gulpSourceMaps.init() )
        .pipe(
            gulpSass(
                {
                    includePath:['node_modules/bootstrap/scss'],
                    errorLogToConsole: true
                }
            )
            .on( 'error', console.error.bind( console ) )
        )
        .pipe( gulpPostCSS( [ tailwindCSS() , autoPrefixer( { cascade: false } ) ] ) )        
        .pipe( gulp.dest( distStyleDir ) )
        .pipe( browserSync.stream() );
}

/**=== 3.1.2. Distribute all styles files for frontend display === **/

function distribute_all_frontend_styles( done ){
    /** 1. Distribute all frontend display SCSS to CSS in beauty format */
    distribute_all_scss_to_css_beauty_format(
        resourcesInfo.styles.frontend.srcListFile,
        resourcesInfo.styles.frontend.distDir
    );

    done();
};//distribute_all_frontend_styles


/**=== 3.1-extra Helper functions Distribute all styles files - SCSS to CSS === **/
/** 1. Distribute all SCSS to CSS */
function distribute_all_scss_to_css_beauty_format( scssSourceDir, cssDistDir){
    /**
     * Temporary remove the ".pipe( gulpSourceMaps.write('./') )" before gulp.dest
    */
    return gulp.src( scssSourceDir )
        .pipe( gulpPlumber() )
        .pipe( gulpSourceMaps.init() )
        .pipe(
            gulpSass(
                {
                    includePath:['node_modules/bootstrap/scss'],
                    errorLogToConsole: true
                }
            )
            .on( 'error', console.error.bind( console ) )
        )
        .pipe(
            gulpAutoPrefixer( { cascade: false } )
        )
        .pipe( gulp.dest( cssDistDir ) )
        .pipe( browserSync.stream() );

}//distribute_all_scss_to_css_beauty_format

/** 2. Distribute single file SCSS to CSS */
function distribute_single_scss_to_css_beauty_format( scssSrcFilePath, cssDistDir ){
    /**
     * Temporary remove the ".pipe( gulpSourceMaps.write('./') )" before gulp.dest
    */
    return gulp.src( scssSrcFilePath )
        .pipe( gulpPlumber() )
        .pipe( gulpSourceMaps.init() )
        .pipe(
            gulpSass(
                {
                    includePath:['node_modules/bootstrap/scss'],
                    errorLogToConsole: true
                }
            )
            .on( 'error', console.error.bind( console ) )
        )
        .pipe( 
            gulpRenamer( 
                function(filePath){ 
                    filePath.basename += "-import"; 
                    filePath.extname = ".css";
                } 
            ) 
        )
        .pipe( gulp.dest( cssDistDir ) )
        .pipe( browserSync.stream() );

}//distribute_single_scss_to_css_beauty_format

/** 3. Distribute all SCSS to minified CSS */
function distribute_all_scss_to_css_minified_format( scssSourceDir, cssDistDir ){
    /**
     * Temporary remove the ".pipe( gulpSourceMaps.write('./') )" before gulp.dest
    */
    return gulp.src( scssSourceDir )
        .pipe( gulpPlumber() )
        .pipe( gulpSourceMaps.init() )
        .pipe(
            gulpSass(
                {
                    includePath:['node_modules/bootstrap/scss'],
                    errorLogToConsole: true,
                    outputStyle:'compressed'
                }
            )
            .on( 'error', console.error.bind( console ) )
        )
        .pipe(
            gulpAutoPrefixer( { cascasde: false } )
        )
        .pipe( gulpRenamer( { suffix: '.min' } ) )
        .pipe( gulp.dest( cssDistDir ) )
        .pipe( browserSync.stream() );
}//distribute_all_scss_to_css_minified_format



/**=== 3.2. Distribute all script files - JS ES6 to Vanilla JS === **/

gulp.task( 'distribute-all-frontend-scripts', distribute_all_frontend_scripts_recursively_2 );
/** 3.2.1. Distribute all frontend JS ES 6 to vanilla JS */
/** 3.2.1.1. Distribute all frontend JS ES 6 to vanilla JS in general JS directory */
/** Need to specify each JS ES6 files manually */
/*
gulp.task( 'distribute-all-frontend-scripts', distribute_all_frontend_scripts );

function distribute_all_frontend_scripts( done ){

    distribute_all_modern_js_to_vanilla_js(
        resourcesInfo.scripts.frontend.srcDir,
        resourcesInfo.scripts.frontend.srcListFile,
        resourcesInfo.scripts.frontend.distDir
    );
    
    done();
};
*/


/** 3.2.0. Distribute all script files in a directory recursively */
/** Method 1 - Using wildcard source directory */
gulp.task('distribute-all-frontend-scripts-recursively-1', distribute_all_frontend_scripts_recursively_1);

function distribute_all_frontend_scripts_recursively_1( done ){
    let srcListFile = './sources/scope-frontend/js/**/*.js';
    let distDir = './assets/scope-frontend/js/';

    /* 1st way to instant call anonymous function to compile JS recursively */
    /*
    ( function( srcListFile, distDir  ){
        return gulp.src( srcListFile )
            .pipe( gulpSourceMaps.init() )          // Initialize source maps
            .pipe( gulpCached('js') )               // Cache processed files
            .pipe( gulpBabel({ presets:['@babel/preset-env'] }) )   // transpile ES6+ to ES5
            .pipe( gulpSourceMaps.write('.') )      // Write source maps
            .pipe( gulp.dest( distDir ) );      //Output compiled files
    }( srcListFile, distDir ) );

    // .pipe( uglify() ) // possible to add to minify the JS compilation
    // .pipe( gulpSourceMaps.init( { loadMaps: true } ) )
    */

    /* 2nd way to instant call anonymous function to compile JS recursively */
    // Define variable function to compile JS recursively
    /*
    const compileJsRecursively = function( srcListFile, distDir  ){
        return gulp.src( srcListFile )
            .pipe( gulpSourceMaps.init() )          // Initialize source maps
            .pipe( gulpCached('js') )               // Cache processed files
            .pipe( gulpBabel({ presets:['@babel/preset-env'] }) )   // transpile ES6+ to ES5
            .pipe( gulpSourceMaps.write({ addComment: true, includeContent: true }) )      // Write source maps
            .pipe( gulp.dest( distDir ) );      //Output compiled files
    }( srcListFile, distDir );
    */
    const compileJsRecursively = function( srcListFile, distDir  ){
        return gulp.src( srcListFile )
            .pipe( gulpSourceMaps.init() )          // Initialize source maps
            .pipe( gulpCached('js') )               // Cache processed files
            .pipe( gulpBabel({ presets:['@babel/preset-env'] }) )   // transpile ES6+ to ES5
            .pipe( gulpSourceMaps.init( { loadMaps: true } ) )      // Write source maps
            .pipe( gulp.dest( distDir ) );      //Output compiled files
    }( srcListFile, distDir );

    done();
}//distribute_all_frontend_scripts_recursively

/** Method 2: utilize all defined functions */
gulp.task('distribute-all-frontend-scripts-recursively-2', distribute_all_frontend_scripts_recursively_2);


/** root directory: resourcesInfo.scripts.frontend.srcDir 
 * - Need to build for each sub directory founded:
 * + srcDir (i.e: "./sources/scope-frontend/js/" )
 * + srcListFile (i.e: "./sources/scope-frontend/js/*.js" )
 * + distDir (i.e: "./assets/scope-frontend/js/" )
*/
function distribute_all_frontend_scripts_recursively_2( done ){

    const getAllSubDirectories = async function( srcDir ){
        let subDirList = [];
        let dirItems = await fsPromise.readdir( srcDir, {withFileTypes: true} );

        for( let dirItem of dirItems ){
            if( dirItem.isDirectory() ){
                let fullPathDirectory = path.join( srcDir, dirItem.name );
                subDirList.push( fullPathDirectory );
                // Recursively get sub directories inside this directory
                const nestedSubDirectories = await getAllSubDirectories( fullPathDirectory );
                subDirList = subDirList.concat( nestedSubDirectories );
            }
        }

        return subDirList;
        // return dirItems.filter( dirItem => dirItem.isDirectory() ).map( dirItem => dirItem.name );
    } 

    /** 1. Distribute all JS files in the outer directory */
    distribute_all_modern_js_to_vanilla_js(
        resourcesInfo.scripts.frontend.srcDir,
        resourcesInfo.scripts.frontend.srcListFile,
        resourcesInfo.scripts.frontend.distDir
    );

    /** 2. Iterate through each sub directory, and distribute all JS files */
    getAllSubDirectories( resourcesInfo.scripts.frontend.srcDir )
        .then( subDirectories => ( 
            function( subDirectories ){ 
                    const subDirList = Object.values( subDirectories );// OK

                    // console.log( subDirList );
                    for( let [index, subDir] of Object.entries( subDirectories ) ){
                        let srcDir = subDir;//OK
                        let srcListFile = path.join( subDir, '*.js' );//OK
                        // console.log(`Current srcListFile : ${srcListFile}`);
                        let distDir = srcDir.replace( /^sources[\/\\]/, 'assets\\' );// OK with hardcode
                        // let distDir = srcDir.replace( `/^sources[\/\${path.sep}]/`, `assets\${path.sep}` );
                        // Append the prefix to indicate the relative directory
                        srcDir = `.\\${srcDir}\\`;
                        srcListFile = `.\\${srcListFile}`;
                        distDir = `.\\${distDir}\\`;

                        // Replate the default path separator (path.sep) with the path separator that gulp task can intepret: 
                        srcDir = srcDir.replaceAll('\\','\/');
                        srcListFile = srcListFile.replaceAll('\\','\/');
                        distDir = distDir.replaceAll('\\','\/');

                        distribute_all_modern_js_to_vanilla_js( srcDir, srcListFile, distDir );
                    }
            
                }
            )( subDirectories ) 
        )
        .catch( err => console.error( err ) );

    /*
    getAllSubDirectories( resourcesInfo.scripts.frontend.srcDir )
        .then( subDirectory => console.log( subDirectory ) )
        .catch( err => console.error( err ) );
    */

    done();
}//distribute_all_frontend_scripts_recursively_2


/**=== 3.2-extra Helper functions Distribute all scripts files - JS ES6 to Vanilla JS === **/
/** 1. Distribute a single modern JS file to vanilla JS file */
function distribute_single_esnext_js_to_vanilla_js( jsSrcFileDir, jsSrcFileName, jsDistDir ){
    /**
     * Temporary remove the ".pipe( gulpSourceMaps.write('./') )" before gulp.dest
    */

    let jsFileAbsPath = `${jsSrcFileDir}${jsSrcFileName}`;

    // return browserify( { entries: [ jsSrcFileDir + jsSrcFileName ] } )
    return browserify( { entries: [ jsFileAbsPath ] } )
        .transform( babelify, { presets: ["@babel/preset-env"] } )
        .bundle()
        .pipe( vinylSource( jsSrcFileName ) )
        .pipe( gulpPlumber() )
        .pipe( gulpRenamer( { extname: ".js"} ) )
        .pipe( vinylBuffer() )
        .pipe( gulpSourceMaps.init( { loadMaps: true } ) )
        .pipe( gulp.dest( jsDistDir ) )
        .pipe( browserSync.stream() );
}//distribute_single_modern_js_to_vanilla_js

/** 2. Distribute all modern JS files to vanilla JS */
function distribute_all_modern_js_to_vanilla_js( jsSrcFileDir, srcListFile, jsDistDir ){
    // the srcListFile must have glob format, such as: ""./sources/scope-frontend/js/*.js"
    
    /** 1. Obtain a list of javascript file in array 
     * Sample format: sources\scope-frontend\js\wc-custom-product-page.js
    */
    const jsSrcFilesArray = glob.sync( srcListFile );//OK

    for( let jsSrcFilePath of jsSrcFilesArray ){
        // Get the source file name from jsSrcFileRelativePath
        let jsSrcFileName = jsSrcFilePath.replace( /^.*[\\/]/, '' );//OK
     
        distribute_single_esnext_js_to_vanilla_js( jsSrcFileDir, jsSrcFileName, jsDistDir );
    }//End of for loop "let jsSrcFilePath of jsSrcFilesArray"

}//distribute_all_modern_js_to_vanilla_js


/**=== 4, Global tasks === */

/** 4.1. Distribute all prelib resources */
gulp.task(
    'distribute-all-prelib-resources',
    gulp.series( 
        'distribute-prelib-tailwindcss-styles'
    )
);

/** 4.2. Distribute all frontend resources **/


/*
gulp.task(
    'distribute-all-frontend-resources',
    gulp.series( 
        'distribute-all-frontend-styles', 
        'distribute-all-frontend-scripts',
        'distribute-all-frontend-scripts-page',
        'distribute-all-frontend-scripts-post',
        'distribute-all-frontend-shortcode-scripts',
        'distribute-all-frontend-woocommerce-scripts'
    )
);
*/

gulp.task(
    'distribute-all-frontend-resources',
    gulp.series( 
        'distribute-all-frontend-styles', 
        'distribute-all-frontend-scripts-recursively'
    )
);

/** 4.2. Distribute all admin resources **/

/** 4.3. Distribute all editor resources **/

/**============================================================= **/
/**=== 5. Troubleshotting === **/
/**============================================================= **/




