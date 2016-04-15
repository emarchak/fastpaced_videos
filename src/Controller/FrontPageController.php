<?php

/**
 * @file
 * Contains \Drupal\fastpaced_videos\Controller\FrontPageController.
 */

namespace Drupal\fastpaced_videos\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class FrontPageController.
 *
 * @package Drupal\fastpaced_videos\Controller
 */
class FrontPageController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;
  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entity_type_manager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Load.
   *
   * @return string
   *   Return Hello string.
   */
  public function load() {
    // Get our libraries to make this easier.
    $storage = $this->entity_type_manager->getStorage('node');
    $query = $storage->getQuery();
    $view = $this->entity_type_manager->getViewBuilder('node');

    // Fetch the 10 most recent nodes
    $nids = $query
      ->condition('status', NODE_PUBLISHED)
      ->condition('type', 'video')
      ->sort('created', 'DESC')
      ->pager(10)
      ->execute();
    $nodes = $storage->loadMultiple($nids);
    foreach($nodes as &$node) {
      $node = $view->view($node, 'teaser');
    }

    // Return the nodes to the template.
    return [
      '#theme' => 'fastpaced_gallery',
      '#videos' => $nodes
    ];
  }

}
