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
use Psr\Log\LoggerInterface;

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
   * Psr\Log\LoggerInterface definition.
   *
   * @var Psr\Log\LoggerInterface;
   */

  protected $logger;

  /**
   * Constructor.
   */
  public function __construct(Client $http_client, QueryFactory $entity_query, EntityTypeManager $entity_type_manager, ConfigFactory $config_factory, Json $serialization_json, LoggerInterface $logger) {
    $this->http_client = $http_client;
    $this->entity_query = $entity_query;
    $this->entity_type_manager = $entity_type_manager;
    $this->config_factory = $config_factory;
    $this->serialization_json = $serialization_json;
    $this->logger = $logger;
  }

  /**
   * Import the fast paced videos.
   */
  public function import() {
    $imported = 0;
    // Get our search parameters.
    $config = $this->config_factory->getEditable('fastpaced_videos.importsettings');
    $search_terms = $config->get('search_terms');
    $this->logger
      ->info('Searching for @terms', ['@terms' => $search_terms]);

    // Query YouTube based on our search results.

    // Check the result of our search request.
    try {

      // If we have something, list the results.
      $results = [];

      // Loop through the results.
      for ($i = 0; isset($results[$i]); $i++) {

        // Increment our imported count on successful import.
        $imported++;

      }

    } catch (RequestException $e) {

      watchdog_exception('fastpaced_videos', $e);
    }

    // Log how many videos we’ve imported.
    $this->logger
      ->info('Imported @count fast paced videos', ['@count' => $imported]);
  }

}
