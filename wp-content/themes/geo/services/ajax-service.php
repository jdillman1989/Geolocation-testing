<?php

/**
 * Centralizes the WordPress AJAX calls.
 */
class AJAX_Service {

  public $request_data;

  public function __construct() {

    // Listen for AJAX calls.
    add_action( 'wp_ajax_onyx_ajax', array($this, 'route_request') );
    add_action( 'wp_ajax_nopriv_onyx_ajax', array($this, 'route_request') );

  }

  /**
   * Take the AJAX request and send it where it's going based on $_POST['onyx_request']
   */
  public function route_request() {


    if( !$_POST['onyx_request'] ) {
      die();
    }

    $this->request_data = $_POST;


    // Load a method from this class that has specific instructions on how to load this request.
    echo $this->{$_POST['onyx_request']}();

    die();


  }

  /**
   * Get the jobs for the job search through an API.
   */
  public function do_job_search() {

    $job_search = new Job_Search_Service;
    return $job_search->do_search($this->request_data['search_term']);

  }

}