<?php

namespace DagLabTheme;

use DagLabTheme\Acf\StaticContentTemplates;

/**
 * Main theme setup class.
 */
class TimberSite extends \Timber\Site {

	/**
	 * Theme's folder name.
	 *
	 * @return string
	 */
	public static function themeName() {
		return basename( get_stylesheet_directory() );
	}

	/**
	 * Theme's directory.
	 *
	 * @return string
	 */
	public static function themeDir() {
		return get_stylesheet_directory();
	}

	/**
	 * Theme's url.
	 *
	 * @return string
	 */
	public static function themeUrl() {
		return get_stylesheet_directory_uri();
	}

	/**
	 * Version assets based on last time stylesheet has changed.
	 *
	 * @return int|null
	 */
	public static function assetsVersion() {
		static $version = NULL;
		if ( $version ) {
			return $version;
		}

		if ( file_exists( static::themeDir() . '/assets/style.css' ) ) {
			$version = filemtime( static::themeDir() . '/assets/style.css' ) ?: NULL;
		}

		return $version;
	}

	/**
	 * Singleton instance.
	 *
	 * @return static
	 */
	public static function instance() {
		static $instance = NULL;
		if (is_null($instance)) {
			$instance = new static();
		}
		return $instance;
	}

	/**
	 * Add timber support.
	 */
	private function __construct() {
		add_action( 'after_setup_theme', [$this, 'theme_supports']);
		add_filter( 'timber/context', [$this, 'add_to_context']);
		add_filter( 'timber/twig', [$this, 'add_to_twig']);
		add_action( 'wp_enqueue_scripts', [$this,'enqueue_scripts_and_styles']);
		add_action( 'after_setup_theme', [$this,'register_menus']);

		parent::__construct();
	}

	/**
	 * This is where you add some context
	 *
	 * @param array $context
	 *   Note: context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu_primary']  = new \Timber\Menu('primary');
		$context['menu_footer_column_1'] = new \Timber\Menu('footer-column-1');
		$context['menu_footer_column_2'] = new \Timber\Menu('footer-column-2');
		$context['site']  = $this;
		$context['assets_url'] = static::themeUrl() . '/assets';
		$context['static_content_directory'] = StaticContentTemplates::templatesDirectory();
		$context['logo_url'] = get_stylesheet_directory_uri() . '/assets/images/logo.png';
		
		return $context;
	}

	/**
	 * @return void
	 */
	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', [
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		] );

		add_theme_support( 'menus' );
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param \Twig\Environment $twig get extension.
	 */
	public function add_to_twig( \Twig\Environment $twig ) {
		$twig->addExtension( new \Twig\Extension\StringLoaderExtension() );

		// Better debugging.
		if ( function_exists( 'dump' ) && class_exists( '\\HelloNico\\Twig\\DumpExtension' ) ) {
			$twig->addExtension( new \HelloNico\Twig\DumpExtension() );
		}
		
		return $twig;
	}

	/**
	 * Enqueue the Timber stylesheet
	 */
	public function enqueue_scripts_and_styles() {
		wp_enqueue_style( static::themeName() . '-styles' , static::themeUrl() . '/assets/css/style.css', [], static::assetsVersion() );

		// custom scripts
		wp_enqueue_script( static::themeName() . '-js', static::themeUrl() . '/assets/js/scripts.js', ['jquery', 'slick-js', 'bootstrap-js-cdn']);

		// fonts
		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Hind:wght@400;600;700&display=swap', false);

		// slick
		wp_enqueue_style( 'slick-css', static::themeUrl() . "/assets/vendor/slick/slick.css", [ static::themeName() . '-styles' ] );
		wp_enqueue_style( 'slick-theme-css', static::themeUrl() . "/assets/vendor/slick/slick-theme.css", [ static::themeName() . '-styles', 'slick-css' ] );
		wp_enqueue_script( 'slick-js', static::themeUrl() . "/assets/vendor/slick/slick.min.js", [ 'jquery' ] );

		// bootstrap js
		wp_enqueue_script( 'bootstrap-js-cdn', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js", [ 'jquery' ] );
	}


	/**
	 * Register menus.
	 */
	public function register_menus() {
		register_nav_menus( [
			'primary' => 'Primary Menu',
			'footer-column-1' => 'Footer Menu Column 1',
			'footer-column-2' => 'Footer Menu Column 2'
		] );
	}

}
