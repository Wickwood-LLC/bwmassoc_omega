<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * BWMAssoc Omega theme.
 */

/**
 * Implements hook_preprocess_page().
 */
function bwmassoc_omega_preprocess_page(&$vars)
{
    // You can use preprocess hooks to modify the variables before they are passed
    // to the theme function or template file.

    _bwmassoc_omega_local_tasks($vars);
    dpm($vars);

    if (in_array(arg(0), array('articles', 'news', 'press-releases', 'faqs'))) {
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/blog_view_panel_pages.css', array('group' => CSS_THEME));
    } else if (arg(0) == 'categories') {
        // Categories view pages
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/blog_view_panel_pages.css', array('group' => CSS_THEME));
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/categories_view_panel_pages.css', array('group' => CSS_THEME));
    } else if (arg(0) == 'taxonomy' && arg(1) == 'term' && preg_match('/^\d+$/', arg(2)) && empty(arg(3))) {
        // Categories term view pages
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/blog_view_panel_pages.css', array('group' => CSS_THEME));
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/categories_view_panel_pages.css', array('group' => CSS_THEME));
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/category_term_pages.css', array('group' => CSS_THEME));
    } else if (empty(request_path()) || in_array(request_path(), array('biweekly-calculator', 'as-seen-on-tv', 'how-does-it-work', 'compare-biweeklies', 'contact-bwmassoc'))) {
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/homepage.css', array('group' => CSS_THEME));
    }
    // Pages: /biweekly-calculator/access-registration, /biweekly-calculator/access-registration?submitted=1
    // Aslo see bwmassoc_omega_ctools_render_alter().
    else if (in_array(request_path(), array('biweekly-calculator/access-registration', 'referral-registration'))) {
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/registration_form.css', array('group' => CSS_THEME));
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/homepage.css', array('group' => CSS_THEME));
    } else if ((arg(0) == 'node' && preg_match('/^\d+$/', arg(1)) && empty(arg(2)))) {
        // Node view page.
        // Get node being displayed.
        $node = menu_get_object();
        dpm($node);
        if (in_array($node->type, array('article_post', 'panopoly_news_article', 'press_release', 'panopoly_faq'))) {
            drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/blog_view_panel_pages.css', array('group' => CSS_THEME));

            if (in_array($node->type, array('article_post', 'panopoly_news_article', 'panopoly_faq'))) {
                drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/articles_news_faqs.css', array('group' => CSS_THEME));
            } else if (in_array($node->type, array('press_release'))) {
                drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/press_release_nodes.css', array('group' => CSS_THEME));
            }
        } else if ($node->type == 'page') {
            drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/homepage.css', array('group' => CSS_THEME));
        }
    } else if (arg(0) == 'user') {
        // login and password reset pages.
        if ((arg(1) == 'login' || arg(1) == 'password')) {
            drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/login.css', array('group' => CSS_THEME));
        }
        // pages:
        //  /user
        //  /user/[uid]/edit
        else if (empty(arg(1)) || preg_match('/^\d+$/', arg(1)) || (preg_match('/^\d+$/', arg(1)) && arg(2) == 'edit')) {
            drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/user_pages.css', array('group' => CSS_THEME));
        }
    }
    // Page /admin/people/create
    else if (arg(0) == 'admin' && arg(1) == 'people' && arg(2) == 'create') {
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/user_pages.css', array('group' => CSS_THEME));
    }
}

/**
 * Implements hook_views_pre_render()
 */
function bwmassoc_omega_views_pre_render(&$view)
{
    if ($view->name == 'card_cycles') {
        drupal_add_css(drupal_get_path('theme', 'dgr_rubik') . '/css/view_card_cycles.css', array('group' => CSS_THEME));
    }
}

/**
 * Override of theme('menu_local_task').
 */
function bwmassoc_omega_menu_local_task($variables)
{

    // dpm($variables);

    $link      = $variables['element']['#link'];
    $link_text = $link['title'];

    if (!empty($variables['element']['#active'])) {
        // Add text to indicate active tab for non-visual users.
        $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

        // If the link does not contain HTML already, check_plain() it now.
        // After we set 'html'=TRUE the link will not be sanitized by l().
        if (empty($link['localized_options']['html'])) {
            $link['title'] = check_plain($link['title']);
        }
        $link['localized_options']['html'] = true;
        $link_text                         = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
    }

    // Render child tasks if available.
    $children = '';
    if (element_children($variables['element'])) {
        $children = drupal_render_children($variables['element']);
        $children = "<ul class='secondary-tabs links clearfix'>{$children}</ul>";
    }

    return '<li' . (!empty($variables['element']['#active']) ? ' class="active"' : '') . '>' . l($link_text, $link['href'], $link['localized_options']) . $children . "</li>\n";
}

function _bwmassoc_omega_local_tasks(&$vars)
{
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

function bwmassoc_omega_menu_local_tasks(&$variables)
{
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

/*******    Moving field descriptions before the field     *******/
function bwmassoc_omega_field_multiple_value_form($variables)
{
    $element = $variables['element'];
    $output  = '';

    if ($element['#cardinality'] > 1 || $element['#cardinality'] == FIELD_CARDINALITY_UNLIMITED) {
        $table_id    = drupal_html_id($element['#field_name'] . '_values');
        $order_class = $element['#field_name'] . '-delta-order';
        $required    = !empty($element['#required']) ? theme('form_required_marker', $variables) : '';

        $header = array(
            array(
                'data'    => '<label>' . t('!title !required', array('!title' => $element['#title'], '!required' => $required)) . "</label>",
                'colspan' => 2,
                'class'   => array('field-label'),
            ),
            t('Order'),
        );
        $rows = array();

        // Sort items according to '_weight' (needed when the form comes back after
        // preview or failed validation)
        $items = array();
        foreach (element_children($element) as $key) {
            if ($key === 'add_more') {
                $add_more_button = &$element[$key];
            } else {
                $items[] = &$element[$key];
            }
        }
        usort($items, '_field_sort_items_value_helper');

        // Add the items as table rows.
        foreach ($items as $key => $item) {
            $item['_weight']['#attributes']['class'] = array($order_class);
            $delta_element                           = drupal_render($item['_weight']);
            $cells                                   = array(
                array('data' => '', 'class' => array('field-multiple-drag')),
                drupal_render($item),
                array('data' => $delta_element, 'class' => array('delta-order')),
            );
            $rows[] = array(
                'data'  => $cells,
                'class' => array('draggable'),
            );
        }

        $output = '<div class="form-item">';
        $output .= $element['#description'] ? '<div class="description">' . $element['#description'] . '</div>' : '';
        $output .= theme('table', array('header' => $header, 'rows' => $rows, 'attributes' => array('id' => $table_id, 'class' => array('field-multiple-table'))));
        $output .= '<div class="clearfix">' . drupal_render($add_more_button) . '</div>';
        $output .= '</div>';

        drupal_add_tabledrag($table_id, 'order', 'sibling', $order_class);
    } else {
        foreach (element_children($element) as $key) {
            $output .= drupal_render($element[$key]);
        }
    }

    return $output;
}

function bwmassoc_omega_html_head_alter(&$head_elements)
{

    foreach ($head_elements as $key => $item) {
        if (strpos($key, 'metatag_viewport') !== false) {
            unset($head_elements[$key]);
        }
    }

    $head_elements['omega-viewport']['#attributes']['content'] = 'width=device-width, initial-scale=1.0, user-scalable=yes';
}

/**
 * Implements hook_ctools_render_alter()
 */
function bwmassoc_omega_ctools_render_alter(&$info, &$page, &$context)
{
    // Load homepage.css on panelizer page with "bwmassoc-page" CSS class.
    if ($context['handler']->name == 'node_view_panelizer' && !empty($info['classes_array']) && in_array('bwmassoc-page', $info['classes_array'])) {
        drupal_add_css(drupal_get_path('theme', 'bwmassoc_omega') . '/css/homepage.css', array('group' => CSS_THEME));
    }
}
