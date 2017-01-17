<?php

/**
 * Implements hook_preprocess_page().
 */
function bwmassoc_omega_preprocess_page(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

	_bwmassoc_omega_local_tasks($vars);
}
