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
    return [
        '#type' => 'markup',
        '#markup' => $this->t('Implement method: load')
    ];
  }

}
