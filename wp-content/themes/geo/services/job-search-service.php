<?php

/**
 * Performs a job search.
 */
class Job_Search_Service {

  /**
   * Runs a curl request to hit a 3rd party API and retrieve results based on keyword.
   * @param  string $search_term The keyword the user is searching jobs by.
   * @return html              A list of results to inject into the DOM.
   */
  public function do_search($search_term) {

    $html = '';

    // Live URL
    $curl_url = "https://silkroad-openhire.silkroad.com/api/index.cfm";

    // Test URL
    $curl_stage_url = "https://silkroad-staging-openhire.silkroad.com/api/index.cfm";

    $data = array(
        'fuseaction' => 'app.getJobListings',
        'FORMAT' => 'xml',
        'JOBPLACEMENT' => 'external',
        'KEYWORD' => $search_term,
        'VERSION' => '1'
    );

    $url = sprintf( '%s?%s', $curl_url, http_build_query( $data ) );

    $request = curl_init();
    curl_setopt_array( $request, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ) );

    $response = curl_exec( $request );
    curl_close( $request );

    $xml = simplexml_load_string( $response, 'SimpleXMLElement', LIBXML_NOCDATA );

    $job_max = 3;
    $job_count = 0;

    if( $xml->job->count() > 0 ) :
        foreach ($xml->job as $item) :
            if( $job_count < $job_max ) :
                $url            = $item->applyUrl;
                $title            = $item->title;
                $region            = $item->jobLocation->region;
                $municipality    = $item->jobLocation->municipality;

                $html .= '<a href="'.$url.'">'.$title.' - '.$municipality.', '.$region.'</a>';

            endif;

            $job_count++;
        endforeach;
    else :
        $html .= '<p>No Jobs found using the search term "'.$search_term.'".</p>';
    endif;

    return $html;

  }

}