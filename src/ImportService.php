<?php

/**
 * @file
 * Contains \Drupal\fastpaced_videos\ImportService.
 */

namespace Drupal\fastpaced_videos;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * Class ImportService.
 *
 * @package Drupal\fastpaced_videos
 */
class ImportService {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entity_query;
  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager, QueryFactory $entity_query) {
    $this->entity_type_manager = $entity_type_manager;
    $this->entity_query = $entity_query;
  }

  /**
   * Check if file is unique among nodes.
   *
   * @param string $field
   * @param string $value
   * @return bool
   */
  public function uniqueField($field = '', $value = '') {

    $result = $this->entity_query->get('node')
      ->condition($field, $value, '=')
      ->execute();

    $unique = empty($result);

    return $unique;
  }


  /**
   * Create node and populate fields.
   *
   * @param string $title
   * @param array $fields
   * @param string $type
   * @param int $uid
   */
  public function createNode($title = '', $fields = [], $type = 'video', $uid = 1) {

    $node = $this->entity_type_manager->getStorage('node')->create([
      'type'  => $type,
      'title' => $title,
      'uid'   => $uid,
    ]);
    foreach ($fields as $field => $value) {
      $node->set($field, $value);
    }
    $node->save();
  }

}
