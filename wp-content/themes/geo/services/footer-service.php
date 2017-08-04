<?php
class Footer_Service {

	public $data;

	public function __construct($data, $post_id="", $extra_data="") {

		$this->data = $data;

		$this->load_view();
	}

	public function load_view() {

		$context = Timber::get_context();

		$context['data'] = $this->data;

		$context['site_title'] = get_bloginfo('name');
		$context['year'] = date("Y");

		Timber::render( theme_views . '/footer.twig', $context);
	}
}
