var gulp = require( 'gulp' );
var gutil = require( 'gulp-util' );
var ftp = require( 'vinyl-ftp' );

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
		'projects/**',
		'*.ico',
		'*.php',
		'*.html',
		'*.ini',
		'*.css',
		'robots.txt',
		'sitemap.xml'
	];

	// using base = '.' will transfer everything to /public_html correctly
	// turn off buffering in gulp.src for best performance

	return gulp.src( globs, { base: '.', buffer: false } )
		.pipe( conn.newer( 'bristoljon.uk/public_html' ) ) // only upload newer files
		.pipe( conn.dest( 'bristoljon.uk/public_html' ) );

} );