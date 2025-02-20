<?php

namespace Drupal\map_integration\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Map entity entities.
 */
class MapEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
