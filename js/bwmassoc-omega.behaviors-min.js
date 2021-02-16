!function(a){
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
Drupal.theme.prototype.bwmassocOmegaExampleButton=function(e,t){
// Create an anchor element with jQuery.
return a('<a href="'+e+'" title="'+t+'">'+t+"</a>")},
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
// Drupal.behaviors.bwmassocOmegaExampleBehavior = {
//   attach: function (context, settings) {
//     // By using the 'context' variable we make sure that our code only runs on
//     // the relevant HTML. Furthermore, by using jQuery.once() we make sure that
//     // we don't run the same piece of code for an HTML snippet that we already
//     // processed previously. By using .once('foo') all processed elements will
//     // get tagged with a 'foo-processed' class, causing all future invocations
//     // of this behavior to ignore them.
//     $('.some-selector', context).once('foo', function () {
//       // Now, we are invoking the previously declared theme function using two
//       // settings as arguments.
//       var $anchor = Drupal.theme('bwmassocOmegaExampleButton', settings.myExampleLinkPath, settings.myExampleLinkTitle);
//       // The anchor is then appended to the current element.
//       $anchor.appendTo(this);
//     });
//     var b = document.documentElement;
//     b.setAttribute('data-useragent',  navigator.userAgent);
//     b.setAttribute('data-platform', navigator.platform );
//     b.className += ((!!('ontouchstart' in window) || !!('onmsgesturechange' in window))?' touch':'');
//     $(window).load(function(){
//       if ($("html").hasClass("touch") && $(".tabs--primary li a.active").has(".secondary-tabs")) {
//         $(".tabs--primary li a.active").removeAttr("href"); //disable link
//         $(".tabs--primary li a.active").off("click");
//         $(".tabs--primary li a.active").on("click", function() {
//           $('ul.secondary-tabs').slideToggle();
//         });
//       }
//     });
//   }
// };
Drupal.behaviors.collapseBlock={attach:function(e,t){a(".panelizer-view-mode.node-embedded-to-profile>h3").off("click"),// This is to prevent the yoyo effect wherein the block opens and closes immediately
a(".panelizer-view-mode.node-embedded-to-profile>h3").on("click",function(){var e=a(this);e.parents(".panelizer-view-mode.node-embedded-to-profile").find(".panel-display").first().slideToggle(),e.toggleClass("open")})}},Drupal.behaviors.compareModals={attach:function(e,t){a("td a").click(function(e){e.preventDefault();var o=a("#"+a(this).data("target")+" .layer-content"),t=a("#"+a(this).data("target")+" .layer-title").text();// the content to be displayed in the dialog
// the title of the dialog
o.dialog({autoOpen:!1,modal:!0,title:t,close:function(e,t){o.dialog("destroy")}}).dialog("open")})}}}(jQuery);