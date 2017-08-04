
/**
 * Returns a JSON object based on the args passed.
 * @param  {object} args An object to pass to the AJAX call. Must have action and onyx_request set.
 * @param  {string} callback The function name to call to do something with the results.
 * @return {object}      The results in what ever format they are returned in via PHP.
 */
function onyx_ajax(args, callback) {

  $.ajax({
    type: 'post',
    url: onyx.ajax,
    data: args,
    success: function(r) {
      window[callback](r);
    }

  });

}