/* eslint-disable no-undef */
(function( $ ) {
  var url = ccAutocomplete.url;
  $( '.cc-autocomplete' ).autocomplete({
    source: function(request, response) {
      $.ajax({
        type: 'GET',
        url: url,
        data: {
          action: 'cc_autocomplete_search',
          term: request.term,
          post_type: $(this.element).data('postType'),
        },
        success: function(data) {
          var parsed_data = JSON.parse(data);
          response(parsed_data);
        },
      });
    },
    create: function() {
      $(this).data('ui-autocomplete')._renderItem = function( ul, item ) {
        return $( '<li>' )
          .append( '<a href="' + item.link + '" rel="search">' + item.label + '</a>' )
          .appendTo( ul );
      };
    },
    minLength: 1,
  });
})( jQuery );
