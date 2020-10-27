<?php

namespace Drupal\map_integration\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MapEntityTypeForm.
 */
class MapEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $map_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $map_entity_type->label(),
      '#description' => $this->t("Label for the Map entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $map_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\map_integration\Entity\MapEntityType::load',
      ],
      '#disabled' => !$map_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $map_entity_type = $this->entity;
    $status = $map_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Map entity type.', [
          '%label' => $map_entity_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Map entity type.', [
          '%label' => $map_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($map_entity_type->toUrl('collection'));
  }

}
