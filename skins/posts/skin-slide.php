<?php
namespace MCElementorCustomSkins\Posts;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Skin_Base as Elementor_Skin_Base;
use ElementorPro\Modules\Posts\Skins\Skin_Classic;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Slide extends Skin_Classic {

	public function get_id() {
		return 'slide';
	}

	public function get_title() {
		return __( 'custom', 'elementor-pro' );
	}
	/*public function render() { 
		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		//$this->render_loop_header();

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			$this->render_post();
		}

		//$this->render_loop_footer();

		wp_reset_postdata();

		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}
	public function render_amp() {

	}

	protected function render_row_header() {
		?>
		<div class="elementor-post__text row">
		<?php
	}

	protected function render_row_footer() {
		?>
		</div>
		<?php
	}

	protected function render_custom_content() {
		?>
		Custom_content
		<?php
	}*/

	protected function render_thumbnail() {
		$thumbnail = $this->get_instance_value( 'thumbnail' );

		if ( 'none' === $thumbnail && ! Plugin::elementor()->editor->is_edit_mode() ) {
			return;
		}

		$settings = $this->parent->get_settings();
		$setting_key = $this->get_control_id( 'thumbnail_size' );
		$settings[ $setting_key ] = [
			'id' => get_post_thumbnail_id(),
		];
		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );

		if ( empty( $thumbnail_html ) ) {
			$thumbnail_html = '<img src="'.plugins_url( 'default.jpg', __FILE__ ).'"/>';
		}
		?>
		<a class="elementor-post__thumbnail__link" href="<?php echo get_permalink(); ?>">
			<div class="elementor-post__thumbnail">
				<?php echo $thumbnail_html; 

				$this->render_post_content(); ?>
			</div>
		</a>
		<?php
	}

	protected function render_post_content() {
		?>
		<div class="elementor-post__post-content">
			<?php
			$this->render_text_header();
			$this->render_title();
			$this->render_meta_data();
			$this->render_excerpt();
			$this->render_read_more();
			$this->render_text_footer();
			?>
		</div>
		<?php
	}

	protected function render_post() {
		$this->render_post_header();
		$this->render_thumbnail();
		$this->render_post_footer();
	}
}
