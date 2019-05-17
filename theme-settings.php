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
  // You can use this hook to append your own theme settings to the theme
  // settings form for your subtheme. You should also take a look at the
  // 'extensions' concept in the Omega base theme.

  $test = theme_get_setting('email_logo');

  $form['email_logo'] = array(
    '#type'     => 'managed_file',
    '#title'    => t('Email logo'),
    '#description' => t('Upload a logo image to be used within emails'),
    // '#required' => TRUE,
    '#upload_location' => file_default_scheme() . '://theme/logo/',
    '#default_value' => theme_get_setting('email_logo'),
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );
}
