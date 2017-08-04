$('#careersSearchForm').on('submit', function(e) {
  e.preventDefault();

  $('#careersSearchResults').html('<img src="/wp-content/themes/onyx/assets/img/loader.gif">');

  var search_term = $('#careersSearchInput').val(),
  ajax_args = {
    action: 'onyx_ajax',
    onyx_request: 'do_job_search',
    search_term: search_term
  };

  onyx_ajax(ajax_args, 'job_search_callback');
});

function job_search_callback(results) {
  $('#careersSearchResults').html(results);
}

$('#careersSearchForm').submit();