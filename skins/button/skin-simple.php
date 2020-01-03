<?php
namespace MCElementorCustomSkins\Button;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Simple extends Skin_Base {

	/**
	 * Skin base constructor.
	 *
	 * Initializing the skin base class by setting parent widget and registering
	 * controls actions.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param Widget_Base $parent
	 */
	public function __construct( Widget_Base $parent ) {
		// define parent widget (button)
		$this->parent = $parent;

		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
		add_action( 'elementor/element/button/section_button/before_section_end', [ $this, 'add_controls' ] );
		add_action( 'elementor/element/button/section_button/after_section_end', [ $this, 'update_controls' ] );
	}

	/**
	 * Get skin ID.
	 *
	 * Retrieve the skin ID.
	 *
	 * @since 1.0.0
	 * @access public
	 * @abstract
	 */
	public function get_id() {
		return 'skin-simple';
	}

	/**
	 * Get skin title.
	 *
	 * Retrieve the skin title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @abstract
	 */
	public function get_title() {
		return __( 'Simple', 'elementor-custom-skins' );
	}

	/**
	 * Add skin controls
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_controls() {

		// start injection of skin control before the Link widget control
		$this->parent->start_injection( [
			'at' => 'before',
			'of' => 'link',
		] );

		$this->add_control(
			'button_custom_attr',
			[
				'label' => __( 'Button attribute', 'elementor-custom-skins' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'elementor-custom-skins' ),
					'first-attr' => __( 'First attribute', 'elementor-custom-skins' ),
					'second-attr' => __( 'Second attribute', 'elementor-custom-skins' )
				]
			]
		);
		$this->add_control(
			'button_custom_attr_value',
			[
				'label' => __( 'Attribute value', 'elementor-custom-skins' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->parent->end_injection();
	}


	/**
	 * Update parent widget controls
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function update_controls() {
		
		// add skin condition on widget Icon controls => show if skin != skin-simple
		$this->parent->update_control(
			'selected_icon',
			[
				'condition' => [
					'_skin!' => 'skin-simple',
				],
			]
		);
		$this->parent->update_control(
			'icon_align',
			[
				'condition' => [
					'selected_icon[value]!' => '',
					'_skin!' => 'skin-simple',
				],
			]
		);
		$this->parent->update_control(
			'icon_indent',
			[
				'condition' => [
					'selected_icon[value]!' => '',
					'_skin!' => 'skin-simple',
				],
			]
		);
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render() {
		$settings = $this->parent->get_settings();

		// get skin settings values
		$button_custom_attr = $this->get_instance_value( 'button_custom_attr' );
		$button_custom_attr_value = $this->get_instance_value( 'button_custom_attr_value' );

		$this->parent->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->parent->add_link_attributes( 'button', $settings['link'] );
			$this->parent->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		// add button attributes from skin settings values
		if ( ! empty( $button_custom_attr ) && ! empty( $button_custom_attr_value ) ) {
			$this->parent->add_render_attribute( 'button', $button_custom_attr, $button_custom_attr_value );
		}

		$this->parent->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->parent->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->parent->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->parent->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->parent->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->parent->get_render_attribute_string( 'button' ); ?>>
				<?php echo $settings['text']; ?>
			</a>
		</div>
		<?php
	}


	/**
	 * Return empty for _content_template to force PHP rendering and update editor template
	 * _content_template isn't supported in Skin
	 * @return string The JavaScript template output.
	 */

	public function skin_print_template( $content, $button ) {
		if( 'button' == $button->get_name() ) {
			return '';
		}
	  	return $content;
	}

}