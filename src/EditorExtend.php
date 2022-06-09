<?php


namespace DagLabTheme;


/**
 * Class EditorExtend
 * @package DagLabTheme
 */
class EditorExtend {
	/**
	 *
	 */
	public static function bootstrap() {
		$self = new self();

		add_filter( 'mce_buttons_2', [ $self, 'add_style_select_button' ] );
		add_filter( 'tiny_mce_before_init', [ $self, 'custom_style_config' ] );
	}

	/**
	 * @param $init_array
	 *
	 * @return mixed
	 */
	public function custom_style_config($init_array) {
		$style_formats = [
			[
				'title' => 'CTA Button',
				'block' => 'div',
				'classes' => 'editor-cta-button',
				'wrapper' => true,
			],
		];
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = \json_encode( $style_formats );

		return $init_array;
	}

	/**
	 * @param $buttons
	 *
	 * @return mixed
	 */
	public function add_style_select_button( $buttons ) {
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}
}
