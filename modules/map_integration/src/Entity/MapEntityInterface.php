<?php

namespace Drupal\map_integration\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Map entity entities.
 *
 * @ingroup map_integration
 */
interface MapEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Map entity name.
   *
   * @return string
   *   Name of the Map entity.
   */
  public function getName();

  /**
   * Sets the Map entity name.
   *
   * @param string $name
   *   The Map entity name.
   *
   * @return \Drupal\map_integration\Entity\MapEntityInterface
   *   The called Map entity entity.
   */
  public function setName($name);

  /**
   * Gets the Map entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Map entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Map entity creation timestamp.
   *
   * @param int $timestamp
   *   The Map entity creation timestamp.
   *
   * @return \Drupal\map_integration\Entity\MapEntityInterface
   *   The called Map entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Map entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Map entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\map_integration\Entity\MapEntityInterface
   *   The called Map entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Map entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Map entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\map_integration\Entity\MapEntityInterface
   *   The called Map entity entity.
   */
  public function setRevisionUserId($uid);

}
