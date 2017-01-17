<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * BWMAssoc Omega theme.
 */

/**
 * Override of theme('menu_local_task').
 */
function bwmassoc_omega_menu_local_task($variables) {
	
	dpm($variables);

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
	dpm($vars);
  if (!empty($vars['secondary_local_tasks']) && is_array($vars['primary_local_tasks'])) {
    foreach ($vars['primary_local_tasks'] as $key => $element) {
      if (!empty($element['#active'])) {
        $vars['primary_local_tasks'][$key] = $vars['primary_local_tasks'][$key] + $vars['secondary_local_tasks'];
        break;
      }
    }
  }
}

