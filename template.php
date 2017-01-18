<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * BWMAssoc Omega theme.
 */

/**
 * Implements hook_preprocess_page().
 */
function bwmassoc_omega_preprocess_page(&$vars) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.

	_bwmassoc_omega_local_tasks($vars);
}


/**
 * Override of theme('menu_local_task').
 */
function bwmassoc_omega_menu_local_task($variables) {
	
	// dpm($variables);

  $link = $variables['element']['#link'];
  $link_text = $link['title'];

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  // Render child tasks if available.
  $children = '';
  if (element_children($variables['element'])) {
    $children = drupal_render_children($variables['element']);
    $children = "<ul class='secondary-tabs links clearfix'>{$children}</ul>";
  }

  return '<li' . (!empty($variables['element']['#active']) ? ' class="active"' : '') . '>' . l($link_text, $link['href'], $link['localized_options']) . $children . "</li>\n";
}

function _bwmassoc_omega_local_tasks(&$vars) {
	// dpm($vars);
  if (!empty($vars['tabs']['#secondary']) && is_array($vars['tabs']['#primary'])) {
    foreach ($vars['tabs']['#primary'] as $key => $element) {
      if (!empty($element['#active'])) {
        $vars['tabs']['#primary'][$key] = $vars['tabs']['#primary'][$key] + $vars['tabs']['#secondary'];
        break;
      }
    }
  }
}

function bwmassoc_omega_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs tabs--primary  links--inline">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs tabs--secondary links--inline">';
    $variables['secondary']['#suffix'] = '</ul>';
    // $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

