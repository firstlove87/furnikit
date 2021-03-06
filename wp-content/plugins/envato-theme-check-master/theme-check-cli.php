<?php
<<<<<<< HEAD
/**
 * Run Envato Theme Check from the command line
 */
include 'checkbase.php';
include 'main.php';

class ThemeCheckCLI extends WP_CLI_Command {
	function __construct()
	{
=======
// Run Envato Theme Check from the command line

include 'checkbase.php';
include 'main.php';
class ThemeCheckCLI extends WP_CLI_Command {

	function __construct() {
>>>>>>> 674f046c8a700a1d191a9a7e0c4dd8425cb4f6a4
		parent::__construct();
		$this->fetcher = new \WP_CLI\Fetchers\Theme;
	}
	/**
<<<<<<< HEAD
	* Show a list of the current themes
	*
	* ## OPTIONS
	*
	* [--errors=<errors>]
	* : set true to return only themes with errors, false for only without errors. Default: false
	*
	* [--allowed=<allowed>]
	* : (Multisite) set true to return only themes allowed on this site, false for only those not allowed,
	* 'site' for only site-allowed, 'network' for only network-allowed.
	*
	* [--blog_id=<id>]
	* : (Multisite) Blog ID, if different than current
	*
	* @subcommand list
	*/
	public function list_themes( $args = array(), $assoc_args = array() )
	{
		$defaults       = array( 'errors' => false, 'allowed' => null, 'blog_id' => 0 );
		$args           = wp_parse_args( $assoc_args, $defaults );
		$args['errors'] = 'true' === $args['errors'];

		if ( ( 'true' == $args['allowed'] ) || ( 'false' == $args['allowed'] ) )
			$args['allowed'] = 'true' === $args['allowed'];

		$themes = wp_get_themes( $args );

		foreach ( $themes as $slug => $theme )
		{
			WP_CLI::line( $slug . ': ' . $theme->get('Name') );
		}
	}
	/**
	* Check a theme
	*
	* <theme>
	* : The theme slug to check
	*
	* [--format=<format>]
	* : set to true to format as json. Default: false
	*
	*/
	public function check( $args = array(), $assoc_args = array() )
	{
		global $themechecks;

		checkcount();

		// prevent undefined index errors
		$assoc_args['format'] = '';

		// empty array for the json format
		$required_json    = array();
		$warnings_json    = array();
		$recommended_json = array();
		$errors_json      = array();
		$result_json      = array();

		$theme = $this->fetcher->get_check( $args[0] );
		$files = $theme->get_files( null, -1 );
		$css   = $php = $other = array();

		foreach( $files as $key => $filename )
		{
			if ( substr( $filename, -4 ) == '.php' )
			{
				$php[ $filename ] = php_strip_whitespace( $filename );
			}
			else if ( substr( $filename, -4 ) == '.css' )
			{
				$css[ $filename ] = file_get_contents( $filename );
			}
			else
			{
				$other[ $filename ] = ( ! is_dir( $filename ) ) ? file_get_contents( $filename ) : '';
			}
		}

		$success = run_themechecks($php, $css, $other);
		$errors  = array();

		foreach ( $themechecks as $check )
		{
			if ( $check instanceof themecheck )
			{
				$error = $check->getError();

				if ( ! empty( $error ) )
				{
=======
	 * Show a list of the current themes
	 *
	 * ## OPTIONS
	 *
	 * [--errors=<errors>]
	 * : set true to return only themes with errors, false for only without errors. Default: false
	 *
	 * [--allowed=<allowed>]
	 * : (Multisite) set true to return only themes allowed on this site, false for only those not allowed,
	 * 'site' for only site-allowed, 'network' for only network-allowed.
	 *
	 * [--blog_id=<id>]
	 * : (Multisite) Blog ID, if different than current
	 *
	 * @subcommand list
	 */
	public function list_themes( $args = array(), $assoc_args = array() ) {
		$defaults = array( 'errors' => false, 'allowed' => null, 'blog_id' => 0 );
		$args = wp_parse_args( $assoc_args, $defaults );
		$args['errors'] = 'true' === $args['errors'];
		if ( ( 'true' == $args['allowed'] ) || ( 'false' == $args['allowed'] ) )
			$args['allowed'] = 'true' === $args['allowed'];
		$themes = wp_get_themes( $args );
		foreach ( $themes as $slug => $theme ) {
			WP_CLI::line( $slug . ': ' . $theme->get('Name') );
		}
	}

	/**
	 * Check a theme
	 *
	 * <theme>
	 * : The theme slug to check
	 *
	 * [--format=<format>]
	 * : set to true to format as json. Default: false
	 *
	 */
	public function check( $args = array(), $assoc_args = array() ) {

		global $checkcount, $themechecks;

		// empty array for the json format
		$required_json = array();
		$warnings_json = array();
		$recommended_json = array();
		$errors_json = array();
		$result_json = array();

		$theme = $this->fetcher->get_check( $args[0] );
		$files = $theme->get_files( null, -1 );
		$css = $php = $other = array();
		foreach( $files as $key => $filename ) {
			if ( substr( $filename, -4 ) == '.php' ) {
				$php[ $filename ] = php_strip_whitespace( $filename );
			} else if ( substr( $filename, -4 ) == '.css' ) {
				$css[ $filename ] = file_get_contents( $filename );
			} else {
				$other[ $filename ] = ( ! is_dir( $filename ) ) ? file_get_contents( $filename ) : '';
			}
		}
		$success = run_themechecks($php, $css, $other);
		$errors = array();
		foreach ( $themechecks as $check ) {
			if ( $check instanceof themecheck ) {
				$error = $check->getError();
				if ( ! empty( $error ) ) {
>>>>>>> 674f046c8a700a1d191a9a7e0c4dd8425cb4f6a4
					$errors = array_merge( $error, $errors );
				}
			}
		}
<<<<<<< HEAD

		$errors = array_unique( $errors );
		$errors = array_map( 'strip_tags', $errors );
		rsort( $errors );

		// assume to pass unless we see a required or warning message.
		$pass = true;

		foreach ( $errors as $error )
		{
			list( $type, $message ) = explode( ':', $error, 2 );

			if ( 'REQUIRED' == trim( $type ) )
			{
				if ( 'true' == $assoc_args['format'] )
				{
					array_push( $required_json, "REQUIRED: " . trim( $message ) );
				}
				else
				{
					WP_CLI::warning( '%rREQUIRED:%n ' . trim( $message ) );
				}
				$pass = false;
			}
			elseif ( 'WARNING' == trim( $type ) )
			{
				if ( 'true' == $assoc_args['format'] )
				{
					array_push( $warnings_json, "WARNING: " . trim( $message ) );
				}
				else
				{
					WP_CLI::warning( '%yWARNING:%n ' . trim( $message ) );
				}
				$pass = false;

			}
			elseif ( 'RECOMMENDED' == trim( $type ) )
			{
				if ( 'true' == $assoc_args['format'] )
				{
					array_push( $recommended_json, "RECOMMENDED: " . trim( $message ) );
				}
				else
				{
					WP_CLI::warning( '%cRECOMMENDED:%n ' . trim( $message ) );
				}
			}
			else
			{
				if ( 'true' == $assoc_args['format'] )
				{
					array_push( $errors_json, "ERROR: " . trim( $error ) );
				}
				else
				{
=======
		$errors = array_unique( $errors );
		$errors = array_map( 'strip_tags', $errors );
		rsort( $errors );
		// We assume to pass unless we see a required or warning message.
		$pass = true;
		foreach ( $errors as $error ) {
			list( $type, $message ) = explode( ':', $error, 2 );
			if ( 'REQUIRED' == trim( $type ) ) {

				if( 'true' == $assoc_args['format'] ) {
					array_push($required_json, "Required: ".trim( $message ));
				} else {
					WP_CLI::warning( '%rRequired:%n '.trim( $message ) );
				}
				$pass = false;

			} elseif ( 'WARNING' == trim( $type ) ) {

				if( 'true' == $assoc_args['format'] ) {
					array_push($warnings_json, "Warning: ".trim( $message ));
				} else {
					WP_CLI::warning( '%yWarning:%n '.trim( $message ) );
				}
				$pass = false;

			} elseif ( 'RECOMMENDED' == trim( $type ) ) {
				if( 'true' == $assoc_args['format'] ) {
					array_push($recommended_json, "Recommended: ".trim( $message ));
				} else {
					WP_CLI::warning( '%cRecommended:%n '.trim( $message ) );
				}
			} else {
				if( 'true' == $assoc_args['format'] ) {
					array_push($errors_json, "Error: ".trim( $error ));
				} else {
>>>>>>> 674f046c8a700a1d191a9a7e0c4dd8425cb4f6a4
					WP_CLI::warning( $error );
				}
			}
		}

<<<<<<< HEAD
		WP_CLI::line();

		if ( empty( $errors ) )
		{
			if ( 'true' == $assoc_args['format'] )
			{
				array_push( $result_json, "SUCCESS" );
				array_push( $result_json, "THEME PASSED REVIEW" );
			}
			else
			{
				WP_CLI::success( "THEME PASSED REVIEW" );
			}
		}
		elseif ( true === $pass )
		{
			if ( 'true' == $assoc_args['format'] )
			{
				array_push(	$result_json, "SUCCESS" );
				array_push( $result_json, "THEME PASSED REVIEW WITH RECOMMENDED CHANGES" );
			}
			else
			{
				WP_CLI::success( "THEME PASSED REVIEW WITH RECOMMENDED CHANGES" );
			}
		}
		else
		{
			if ( 'true' == $assoc_args['format'] )
			{
				array_push( $result_json, "FAIL" );
				array_push( $result_json, "THEME DID NOT PASS REVIEW" );
			}
			else
			{
				WP_CLI::line( WP_CLI::colorize( "%RFAIL:%n THEME DID NOT PASS REVIEW" ) );
			}
		}

		if ( 'true' == $assoc_args['format'] )
		{
			$output = array (
				'result'      => $result_json,
				'required'    => $required_json,
				'recommended' => $recommended_json,
				'warnings'    => $warnings_json,
				'errors'      => $errors_json
			);
			echo htmlspecialchars_decode( json_encode( $output, JSON_UNESCAPED_SLASHES ) );
		}
	}
	/**
	* Check for the active theme
	*
	* [--format=<format>]
	* : set to true to format as json. Default: false
	*
	*/
	public function active( $args = array(), $assoc_args = array() )
	{
		$active_theme      = wp_get_theme();
		$theme_folder_name = $active_theme->template;

		$this->check( array($theme_folder_name), $assoc_args);
	}
}

class ThemeCheckCLILogger extends WP_CLI\Loggers\Regular {
	public function _line( $message, $label, $color, $handle = STDOUT )
	{
		if ( ! empty( $label ) )
		{
=======

		WP_CLI::line();
		if ( empty( $errors ) ){
			if( 'true' == $assoc_args['format'] ) {
				array_push($result_json, "Success");
				array_push($result_json, "Theme passed review.");
			} else {
				WP_CLI::success( "Theme passed review." );
			}
		} elseif ( true === $pass ){
			if( 'true' == $assoc_args['format'] ) {
				array_push($result_json, "Success");
				array_push($result_json, "Theme passed review with some recommended changes.");
			} else {
				WP_CLI::success( "Theme passed review with some recommended changes." );
			}
		} else {
			if( 'true' == $assoc_args['format'] ) {
				array_push($result_json, "Fail");
				array_push($result_json, "Theme did not pass review.");
			} else {
				WP_CLI::line( WP_CLI::colorize( "%RFail:%n Theme did not pass review." ) );
			}
		}

		if( 'true' == $assoc_args['format'] ) {

			$output = array (
				'result' => $result_json,
				'required' => $required_json,
				'recommended' => $recommended_json,
				'warnings' => $warnings_json,
				'errors' => $errors_json
			);

			echo htmlspecialchars_decode( json_encode($output, JSON_UNESCAPED_SLASHES ));
		}



	}

	/**
	 * Check for the active theme
	 *
	 * [--format=<format>]
	 * : set to true to format as json. Default: false
	 *
	 */
	public function active( $args = array(), $assoc_args = array() ) {
		$active_theme = wp_get_theme();
		$theme_folder_name = $active_theme->template;
		$this->check( array($theme_folder_name), $assoc_args);
	}

}

class ThemeCheckCLILogger extends WP_CLI\Loggers\Regular {
	public function _line( $message, $label, $color, $handle = STDOUT ) {
		if ( ! empty( $label ) ) {
>>>>>>> 674f046c8a700a1d191a9a7e0c4dd8425cb4f6a4
			$label = \cli\Colors::colorize( "$color$label:%n ", $this->in_color );
		}
		$this->write( $handle, "{$label}{$message}\n" );
	}
<<<<<<< HEAD

	function warning( $message )
	{
		$this->_line( WP_CLI::colorize( $message ), '', '', STDERR );
	}
}
WP_CLI::set_logger( new ThemeCheckCLILogger( true ) );

=======
	function warning( $message ) {
		$this->_line( WP_CLI::colorize( $message ), '', '', STDERR );
	}
}

WP_CLI::set_logger( new ThemeCheckCLILogger( true ) );
// Here we define the command name we want to use.
>>>>>>> 674f046c8a700a1d191a9a7e0c4dd8425cb4f6a4
WP_CLI::add_command( 'theme review', 'ThemeCheckCLI' );