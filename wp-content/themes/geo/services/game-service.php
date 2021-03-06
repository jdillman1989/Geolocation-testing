<?php
class Game_Service {

	public $post_id;
	public $data;

	public function __construct($data, $post_id="", $extra_data="") {

		$this->data = $data;
		$this->post_id = $post_id;
		$this->load_view();
	}

	public function load_view() {

		$context = Timber::get_context();
		$context['data'] = $this->data;

		$context['title'] = get_the_title($this->post_id);
		$context['id'] = $this->post_id;

		Timber::render( theme_views . '/game.twig', $context);
	}
}
