<?php
namespace MCElementorCustomSkins\Posts;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use ElementorPro\Modules\Posts\Skins\Skin_Classic as Skin_Classic;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Slide extends Skin_Classic {

	public function get_id() {
		return 'slide';
	}

	public function get_title() {
		return __( 'Slide', 'elementor-custom-skins' );
	}

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/posts/section_pagination/after_section_end', [ $this, 'register_pagination_controls' ] );
	}

	public function register_pagination_controls( Widget_Base $widget ) {

		// edit parent widget controls
		$this->parent = $widget;

		// update widget parent existing control
		$this->parent->update_control(
			'pagination_type',
			[
				'label' => __( 'Pagination', 'elementor-custom-skins' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'dots',
				'options' => [
					'dots' => __( 'Dots', 'elementor-custom-skins' ),
					'arrows' => __( 'Arrows', 'elementor-custom-skins' ),
					'dots_arrows' => __( 'Dots & Arrows', 'elementor-custom-skins' ),
				],
			]
		);

		// delete widget parent existing control
		$this->parent->remove_control( 'pagination_page_limit' );
		$this->parent->remove_control( 'pagination_align' );
	}

	protected function render_loop_header() {
		// enqueue slider script
		wp_enqueue_script( 'posts-skin-slide' );

		// add custom CSS classes
		$classes = [
			'elementor-posts-container',
			'elementor-posts',
			'swiper-wrapper',
			$this->get_container_class(),
		];

		$this->parent->add_render_attribute( 'container', [
			'class' => $classes,
		] );

		?>
		<div class="swiper-container swiper-container-horizontal">
			<div <?php echo $this->parent->get_render_attribute_string( 'container' ); ?>>
		<?php
	}

	protected function render_post_header() {
		// add "swiper-slide" class to posts
		?>
		<article <?php post_class( [ 'elementor-post elementor-grid-item swiper-slide' ] ); ?>>
		<?php
	}

	protected function render_loop_footer() {
		// display slider pagination
		?>
			</div>
			<?php
			$parent_settings = $this->parent->get_settings();
			$parent_pagination_type = $parent_settings['pagination_type'];

			if ( 'dots' === $parent_pagination_type || 'dots_arrows' === $parent_pagination_type ) {
				?>
				<div class="swiper-pagination swiper-pagination-bullets"></div>
				<?php
			}

			if ( 'arrows' === $parent_pagination_type || 'dots_arrows' === $parent_pagination_type ) {
				?>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
				<?php
			}
			?>
		</div>
		<?php
	}

}
