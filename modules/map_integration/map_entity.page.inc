<?php

/**
 * @file
 * Contains map_entity.page.inc.
 *
 * Page callback for Map entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Map entity templates.
 *
 * Default template: map_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_map_entity(array &$variables) {
  // Fetch MapEntity Entity Object.
  $map_entity = $variables['elements']['#map_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
