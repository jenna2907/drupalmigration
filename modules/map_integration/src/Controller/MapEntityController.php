<?php

namespace Drupal\map_integration\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\map_integration\Entity\MapEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MapEntityController.
 *
 *  Returns responses for Map entity routes.
 */
class MapEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Map entity revision.
   *
   * @param int $map_entity_revision
   *   The Map entity revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($map_entity_revision) {
    $map_entity = $this->entityTypeManager()->getStorage('map_entity')
      ->loadRevision($map_entity_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('map_entity');

    return $view_builder->view($map_entity);
  }

  /**
   * Page title callback for a Map entity revision.
   *
   * @param int $map_entity_revision
   *   The Map entity revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($map_entity_revision) {
    $map_entity = $this->entityTypeManager()->getStorage('map_entity')
      ->loadRevision($map_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $map_entity->label(),
      '%date' => $this->dateFormatter->format($map_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Map entity.
   *
   * @param \Drupal\map_integration\Entity\MapEntityInterface $map_entity
   *   A Map entity object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MapEntityInterface $map_entity) {
    $account = $this->currentUser();
    $map_entity_storage = $this->entityTypeManager()->getStorage('map_entity');

    $langcode = $map_entity->language()->getId();
    $langname = $map_entity->language()->getName();
    $languages = $map_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $map_entity->label()]) : $this->t('Revisions for %title', ['%title' => $map_entity->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all map entity revisions") || $account->hasPermission('administer map entity entities')));
    $delete_permission = (($account->hasPermission("delete all map entity revisions") || $account->hasPermission('administer map entity entities')));

    $rows = [];

    $vids = $map_entity_storage->revisionIds($map_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\map_integration\MapEntityInterface $revision */
      $revision = $map_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $map_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.map_entity.revision', [
            'map_entity' => $map_entity->id(),
            'map_entity_revision' => $vid,
          ]));
        }
        else {
          $link = $map_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.map_entity.translation_revert', [
                'map_entity' => $map_entity->id(),
                'map_entity_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.map_entity.revision_revert', [
                'map_entity' => $map_entity->id(),
                'map_entity_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.map_entity.revision_delete', [
                'map_entity' => $map_entity->id(),
                'map_entity_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['map_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
