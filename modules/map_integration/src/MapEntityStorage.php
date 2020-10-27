<?php

namespace Drupal\map_integration;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class MapEntityStorage extends SqlContentEntityStorage implements MapEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MapEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {map_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {map_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MapEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {map_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('map_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
