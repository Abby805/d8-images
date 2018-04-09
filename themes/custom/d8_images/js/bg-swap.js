(function ($, Drupal, debounce) {
  'use strict';

  Drupal.behaviors.bgSwap = {
    attach: function (context) {

      var $responsiveBgs = $('.has-responsive-bg', context);

      if (!$responsiveBgs.length) {
        return;
      }

      // A boolean for whether the current size is large or small
      var smallViewport = $(document).width() < 768;

      // Grab the image urls from the data-attributes
      var smallCSS = 'background-image: url("' + $responsiveBgs.data('bg-sm') + '");';
      var largeCSS = 'background-image: url("' + $responsiveBgs.data('bg-lg') + '");';

      // We set it to the small image by default, so if it's a large viewport
      // we swap it out on load.
      if (!smallViewport) {
        $responsiveBgs.attr('style', largeCSS);
      }


      var swapBg = debounce(function() {
        // Is it currently small?
        var isSmall = $(document).width() < 768;

        // If its new state matches the existing state, no further action needed
        if (isSmall == smallViewport) {
          return;
        }

        // If they don't match, the new state now becomes the global state
        smallViewport = isSmall;

        // Set it to the appropriate image for the new state
        if (isSmall) {
          $responsiveBgs.attr('style', smallCSS);
        }
        else {
          $responsiveBgs.attr('style', largeCSS);
        }
      }, 250);

      window.addEventListener('resize', swapBg);
    },
  };
})(jQuery, Drupal, Drupal.debounce);
