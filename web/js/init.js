(function($){
  $(function(){
     var window_width = $(window).width();

    // Floating-Fixed table of contents
    if ($('nav').length) {
      $('.toc-wrapper').pushpin({ top: $('nav').height() });
    }
    else if ($('#index-banner').length) {
      $('.toc-wrapper').pushpin({ top: $('#index-banner').height() });
    }
    else {
      $('.toc-wrapper').pushpin({ top: 0 });
    }


    // Detect touch screen and enable scrollbar if necessary
    function is_touch_device() {
      try {
        document.createEvent("TouchEvent");
        return true;
      } catch (e) {
        return false;
      }
    }
    if (is_touch_device()) {
      $('#nav-mobile').css({ overflow: 'auto'})
    }

    // Set checkbox on forms.html to indeterminate
    var indeterminateCheckbox = document.getElementById('indeterminate-checkbox');
    if (indeterminateCheckbox !== null)
      indeterminateCheckbox.indeterminate = true;


    // Plugin initialization
    $('.button-collapse').sideNav({'edge': 'left'});

  }); // end of document ready

})(jQuery); // end of jQuery name space
