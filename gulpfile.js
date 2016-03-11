var gulp = require( 'gulp' );
var gutil = require( 'gulp-util' );
var ftp = require( 'vinyl-ftp' );
var less = require('gulp-less');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');

gulp.task( 'deploy', function () {

	console.log('User = ' + process.env.FTP_USER);

	var conn = ftp.create( {
		host:     'ftp.bristoljon.uk',
		user:     process.env.FTP_USER,
		password: process.env.FTP_PASS,
		parallel: 3,
		log:      gutil.log
	} );

	var globs = [
		'blog/**',
		'css/**',
		'fonts/**',
		'html/**',
		'img/**',
		'js/**',
		'php/**',
        'project/**',
		'projects/**',
		'*.ico',
		'*.php',
		'*.html',
		'*.ini',
		'*.css',
		'robots.txt',
		'sitemap.xml',
        '.htaccess'
	];

	// using base = '.' will transfer everything to /public_html correctly
	// turn off buffering in gulp.src for best performance

	return gulp.src( globs, { base: '.', buffer: false } )
		.pipe( conn.newer( 'bristoljon.uk/public_html' ) ) // only upload newer files
		.pipe( conn.dest( 'bristoljon.uk/public_html' ) );

} );

// Compiles LESS > CSS
gulp.task('build-less', function(){
    return gulp.src('./less/styles.less')
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(rename('styles.min.css'))
        .pipe(gulp.dest('./css'))
});
