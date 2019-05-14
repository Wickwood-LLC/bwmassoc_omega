<?php

/**
 * @file
 * Default theme implementation to format an HTML mail.
 *
 * Copy this file in your default theme folder to create a custom themed mail.
 * Rename it to mimemail-message--[module]--[key].tpl.php to override it for a
 * specific mail.
 *
 * Available variables:
 * - $recipient: The recipient of the message
 * - $subject: The message subject
 * - $body: The message body
 * - $css: Internal style sheets
 * - $module: The sending module
 * - $key: The message identifier
 *
 * @see template_preprocess_mimemail_message()
 */

global $theme_key;
global $base_url;
$themes = list_themes();
$theme_object = $themes[$theme_key];
$settings = theme_get_setting($theme_key);
$logos = $base_url .'/'. $settings['logo_path']; //this is the logo path

/**
 * @file
 * Fallback-Template for HTML Mail messages.
 */

$css_file = realpath(path_to_theme()) . '/mail.css';
if (!empty($css_file) && file_exists($css_file)) {
  $css = file_get_contents($css_file);
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if ($css): ?>
    <style type="text/css">
      <!--
      <?php print $css ?>
      -->
    </style>
    <?php endif; ?>
  </head>
  <body id="mimemail-body" <?php if ($module && $key): print 'class="'. $module .'-'. $key .'"'; endif; ?>>
    <div id="center">
      <div id="main">
        <div></div>
        <table style="text-align: center; width: 590px;">
          <tbody>
            <tr>
              <td>
                <img id="logo" src="../logo.png" />
              </td>
            </tr>
          </tbody>
        </table>
        <div id="body"><?php print $body ?></div>
      </div>
    </div>
  </body>
</html>
