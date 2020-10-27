<?php

namespace Drupal\map_integration\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Map entity type entity.
 *
 * @ConfigEntityType(
 *   id = "map_entity_type",
 *   label = @Translation("Map entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\map_integration\MapEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\map_integration\Form\MapEntityTypeForm",
 *       "edit" = "Drupal\map_integration\Form\MapEntityTypeForm",
 *       "delete" = "Drupal\map_integration\Form\MapEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\map_integration\MapEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "map_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "map_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/map_entity_type/{map_entity_type}",
 *     "add-form" = "/admin/structure/map_entity_type/add",
 *     "edit-form" = "/admin/structure/map_entity_type/{map_entity_type}/edit",
 *     "delete-form" = "/admin/structure/map_entity_type/{map_entity_type}/delete",
 *     "collection" = "/admin/structure/map_entity_type"
 *   }
 * )
 */
class MapEntityType extends ConfigEntityBundleBase implements MapEntityTypeInterface {

  /**
   * The Map entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Map entity type label.
   *
   * @var string
   */
  protected $label;

}
