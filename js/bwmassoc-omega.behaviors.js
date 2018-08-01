(function ($) {

  /**
   * The recommended way for producing HTML markup through JavaScript is to write
   * theming functions. These are similiar to the theming functions that you might
   * know from 'phptemplate' (the default PHP templating engine used by most
   * Drupal themes including Omega). JavaScript theme functions accept arguments
   * and can be overriden by sub-themes.
   *
   * In most cases, there is no good reason to NOT wrap your markup producing
   * JavaScript in a theme function.
   */
  Drupal.theme.prototype.bwmassocOmegaExampleButton = function (path, title) {
    // Create an anchor element with jQuery.
    return $('<a href="' + path + '" title="' + title + '">' + title + '</a>');
  };

  /**
   * Behaviors are Drupal's way of applying JavaScript to a page. In short, the
   * advantage of Behaviors over a simple 'document.ready()' lies in how it
   * interacts with content loaded through Ajax. Opposed to the
   * 'document.ready()' event which is only fired once when the page is
   * initially loaded, behaviors get re-executed whenever something is added to
   * the page through Ajax.
   *
   * You can attach as many behaviors as you wish. In fact, instead of overloading
   * a single behavior with multiple, completely unrelated tasks you should create
   * a separate behavior for every separate task.
   *
   * In most cases, there is no good reason to NOT wrap your JavaScript code in a
   * behavior.
   *
   * @param context
   *   The context for which the behavior is being executed. This is either the
   *   full page or a piece of HTML that was just added through Ajax.
   * @param settings
   *   An array of settings (added through drupal_add_js()). Instead of accessing
   *   Drupal.settings directly you should use this because of potential
   *   modifications made by the Ajax callback that also produced 'context'.
   */
  Drupal.behaviors.bwmassocOmegaExampleBehavior = {
    attach: function (context, settings) {
      // By using the 'context' variable we make sure that our code only runs on
      // the relevant HTML. Furthermore, by using jQuery.once() we make sure that
      // we don't run the same piece of code for an HTML snippet that we already
      // processed previously. By using .once('foo') all processed elements will
      // get tagged with a 'foo-processed' class, causing all future invocations
      // of this behavior to ignore them.
      $('.some-selector', context).once('foo', function () {
        // Now, we are invoking the previously declared theme function using two
        // settings as arguments.
        var $anchor = Drupal.theme('bwmassocOmegaExampleButton', settings.myExampleLinkPath, settings.myExampleLinkTitle);

        // The anchor is then appended to the current element.
        $anchor.appendTo(this);
      });

      var b = document.documentElement;
      b.setAttribute('data-useragent',  navigator.userAgent);
      b.setAttribute('data-platform', navigator.platform );
      b.className += ((!!('ontouchstart' in window) || !!('onmsgesturechange' in window))?' touch':'');

      $(window).load(function(){
        if ($("html").hasClass("touch") && $(".tabs--primary li a.active").has(".secondary-tabs")) {
          $(".tabs--primary li a.active").removeAttr("href"); //disable link
          $(".tabs--primary li a.active").off("click");
          $(".tabs--primary li a.active").on("click", function() {
            $('ul.secondary-tabs').slideToggle();
          });
        }
      });
    }
  };

  Drupal.behaviors.collapseBlock = {
    attach: function (context, settings) {
      $('.panelizer-view-mode.node-embedded-to-profile>h3').off("click");       // This is to prevent the yoyo effect wherein the block opens and closes immediately
      $('.panelizer-view-mode.node-embedded-to-profile>h3').on("click", function() {
        var $this = $(this);
        $this.parents('.panelizer-view-mode.node-embedded-to-profile').find('.panel-display').first().slideToggle();
        $this.toggleClass('open');
      });
    }
  };

  Drupal.behaviors.responsiveEqualHeight = {    
    attach: function (context, settings) {
      equalheight = function(container){

        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
        $(container).each(function() {

          $el = $(this);
          $($el).height('auto')
          topPostion = $el.position().top;

          if (currentRowStart != topPostion) {
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
              rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
          } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
          }
          for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
          }
        });
      }

      $(document).ready(function() {
        if ($(window).width() > 943) {
          equalheight('.featured-display .views-row');
        }
        else {
          $('.featured-display .views-row').css({
            'height': 'auto',
          })
        }
      });

      $(document).on("DOMNodeInserted", function() {
        if ($(window).width() > 943) {
          equalheight('.featured-display .views-row');
        }
        else {
          $('.featured-display .views-row').css({
            'height': 'auto',
          })
        }
      });

      $(window).resize(function(){
        if ($(window).width() > 943) {
          equalheight('.featured-display .views-row');
        }
        else {
          $('.featured-display .views-row').css({
            'height': 'auto',
          })
        }
      });
    }
  };

  Drupal.behaviors.stickyHeader = {
    attach: function (context, settings) {
      var stickyTop;
      var headerWidth;
      var headerHeight;
      var windowTop;
      var currentPosition;
      var $header;
      var topSpacing;

      $header = $('.l-branding');
      topSpacing = $('#admin-menu').height();
      headerHeight = $header.height();        // gets the height of our header

      $(document).ready(sticky);
      $(window).on("resize mresize", sticky);

      function sticky() {
        headerWidth = $header.width();          // gets the width of the container
        $header.css({
          // width: "initial",
        });
        if ($('sticky-header')) {
          $header.removeClass('sticky-header');
        }
        headerHeight = $header.height();        // gets the height of our header

        stickyTop = $header.offset().top;       // tells how far our target element is from the top of the page
        windowTop = $(window).scrollTop();    // tells how far our screen is currently from the top of the page
        currentPosition = stickyTop - windowTop + headerHeight;    // tells how far our target element is from where our screen is currently
        topSpacing = $('#admin-menu').height();

        $('#header').css({
          "margin-bottom": '0',
        });

        // console.log('Distance from top of page: ' + stickyTop);
        // console.log('Position on load ' + currentPosition);

        if (currentPosition < 0) {   // if target element goes above the screen
          $header.addClass('sticky-header');

          $('#header').css({
            'margin-bottom': headerHeight,
          });
        }
        else {
          $header.removeClass('sticky-header');

          $('#header').css({
            'margin-bottom': '0',
          });
        }

        if ($('#admin-menu').length) {
          if (currentPosition < 0) {   // if target element goes above the screen
            $header.css({
              top: topSpacing,
            });
          }
          else {
            $header.css({
              top: '0',
            });
          }
        }

        // console.log("Top spacing is " + topSpacing);
      }

      $(window).scroll(function(){ // scroll event 
        windowTop = $(window).scrollTop();    // tells how far our screen is currently from the top of the page
        currentPosition = stickyTop - windowTop + headerHeight;    // tells how far our target element is from where our screen is currently

        // console.log('Distance from top of page: ' + stickyTop);
        // console.log('Current position: ' + currentPosition);

        if (currentPosition < 0) {   // if target element goes above the screen
          $header.addClass('sticky-header');

          $('#header').css({
            'margin-bottom': headerHeight,
          })
        }
        else if (currentPosition >= 0) {
          $header.removeClass('sticky-header');

          $('#header').css({
            'margin-bottom': '0',
          })
        }

        if ($('#admin-menu').length) {
          if (currentPosition < 0) {   // if target element goes above the screen
            $header.css({
              top: topSpacing,
            });   //stick it at the top
          }
          else {
            $header.css({
              top: '0',
            });
          }
        }

        // console.log("Top spacing is " + topSpacing);
      });
    }
  };

})(jQuery);
