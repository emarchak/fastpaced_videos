<?php

/**
 * @file
 * Contains \Drupal\fastpaced_videos\ImportService.
 */

namespace Drupal\fastpaced_videos;

use GuzzleHttp\Client;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Component\Serialization\Json;

/**
 * Class ImportService.
 *
 * @package Drupal\fastpaced_videos
 */
class ImportService {

  /**
   * GuzzleHttp\Client definition.
   *
   * @var GuzzleHttp\Client
   */
  protected $http_client;

  /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entity_query;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;

  /**
   * Drupal\Component\Serialization\Json definition.
   *
   * @var Drupal\Component\Serialization\Json
   */
  protected $serialization_json;
  /**
   * Constructor.
   */
  public function __construct(Client $http_client, QueryFactory $entity_query, EntityTypeManager $entity_type_manager, ConfigFactory $config_factory, Json $serialization_json) {
    $this->http_client = $http_client;
    $this->entity_query = $entity_query;
    $this->entity_type_manager = $entity_type_manager;
    $this->config_factory = $config_factory;
    $this->serialization_json = $serialization_json;
  }

}
