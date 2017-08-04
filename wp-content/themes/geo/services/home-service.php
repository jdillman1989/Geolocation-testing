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

		Timber::render( theme_views . '/home.twig', $context);
	}
}
