<?php
class Home_Service {

	public $data;

	public function __construct($data, $post_id="", $extra_data="") {

		$this->data = $data;

		$this->load_view();

	}

	public function load_view() {

		$context = Timber::get_context();
		$context['data'] = $this->data;
		$context['theme_url'] = get_template_directory_uri();

		$game_args = array('post_type' => 'games');
		$games = new WP_Query($game_args);

		$games_array = array();
		if( $games->have_posts() ) {
			while($games->have_posts()) {
				$games->the_post();

				$games_array[] = array(
					'title' => get_the_title(),
					'image' => get_field('image'),
					'permalink' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		$context['games'] = $games_array;

		Timber::render( theme_views . '/home.twig', $context);
	}
}
