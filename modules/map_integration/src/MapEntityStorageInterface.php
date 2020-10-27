<?php

namespace Drupal\map_integration;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\map_integration\Entity\MapEntityInterface;

/**
 * Defines the storage handler class for Map entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Map entity entities.
 *
 * @ingroup map_integration
 */
interface MapEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Map entity revision IDs for a specific Map entity.
   *
   * @param \Drupal\map_integration\Entity\MapEntityInterface $entity
   *   The Map entity entity.
   *
   * @return int[]
   *   Map entity revision IDs (in ascending order).
   */
  public function revisionIds(MapEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Map entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Map entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\map_integration\Entity\MapEntityInterface $entity
   *   The Map entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MapEntityInterface $entity);

  /**
   * Unsets the language for all Map entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
