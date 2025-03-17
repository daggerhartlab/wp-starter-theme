<?php

namespace DagLabTheme\Acf;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Class StaticContentTemplates
 *
 * @package DagLabTheme\Acf
 */
class StaticContentTemplates {

	/**
	 * Register hooks.
	 */
	public static function register() {
		$static = new static();

		add_filter('acf/load_field/name=template', [$static, 'templateChoices']);
	}

	/**
	 * Templates base directory.
	 *
	 * @return string
	 */
	public static function templatesDirectory() {
		return get_stylesheet_directory() . '/templates/components/static-content';
	}

	/**
	 * Dynamically provide template options for static content.
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	public function templateChoices(array $field) {
		// Don't modify the choices unless we're viewing the page edit form.
		if (!isset($_GET['action'], $_GET['post']) || $_GET['action'] !== 'edit') {
			return $field;
		}
		if (get_post_type($_GET['post']) !== 'page') {
			return $field;
		}
		// Don't modify choices during post save.
		if (isset($_REQUEST['save'])) {
			return $field;
		}

		$choices = $this->getStaticTemplates();
		if (!empty($choices)) {
			$field['choices'] = $choices;
		}

		return $field;
	}

	/**
	 * Get a list of templates as an array for field choices.
	 *
	 * @return array
	 */
	protected function getStaticTemplates() {
		$content_dir = static::templatesDirectory();
		$dir = new RecursiveDirectoryIterator($content_dir);
		$ite = new RecursiveIteratorIterator($dir);
		$files = new RegexIterator($ite, "/^.*\.(twig|html)$/", RegexIterator::GET_MATCH);
		$choices = [];
		foreach($files as $file) {
			$relative_path = str_replace($content_dir . '/', '', $file[0]);
			$choices[$relative_path] = $relative_path;
		}
		ksort($choices);
		return $choices;
	}

}
