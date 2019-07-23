<?php

/**
 * @file
 * Theme settings file for the BWMAssoc Omega theme.
 */

require_once dirname(__FILE__) . '/template.php';

/**
 * Implements hook_form_FORM_alter().
 */
function bwmassoc_omega_form_system_theme_settings_alter(&$form, &$form_state) {
  form_load_include($form_state, 'inc', 'system', 'system.admin');
  // You can use this hook to append your own theme settings to the theme
  // settings form for your subtheme. You should also take a look at the
  // 'extensions' concept in the Omega base theme.

  $form['email_logo'] = array(
    '#type' => 'media',
    '#title' => t('Email logo'),
    '#default_value' => theme_get_setting('email_logo'),
    '#description' => t('Upload a logo image to be used within emails.'),
    '#theme' => 'media_widget', // Without that, you only get text input
    '#media_options' => array(
      'global' => array(
        'file_extensions' => 'png gif jpg jpeg',
        'max_filesize'    => '2 MB',
        'uri_scheme'      => 'public',
        'types'           => array('image'),
        'schemes'         => array(
          'public' => 'public',
        ),
      ),
    ),
  );
  $form_state['build_info']['files'][] = drupal_get_path('theme', 'bwmassoc_omega') . '/theme-settings.php';
  $form['#submit'][] = 'bwmassoc_omega_form_system_theme_settings_submit';
}

function bwmassoc_omega_form_system_theme_settings_submit(&$form, &$form_state) {
  $image_fid = $form_state['values']['email_logo'];
  $image = file_load($image_fid);
  if (is_object($image)) {
    // Check to make sure that the file is set to be permanent.
    if ($image->status == 0) {
      // Update the status.
      $image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($image);
      // Add a reference to prevent warnings.
      file_usage_add($image, 'bwmassoc_omega', 'theme', 1);
     }
  }
}

function bwmassoc_omega_form_variable_realm_variable_theme_form_submit(&$form, &$form_state) {

}
