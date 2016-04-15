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
use Drupal\Core\Url;

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
    $search_url = $this->getSearchURL($search_terms);
    $response = $this->http_client->request('GET', $search_url);

    // Check the result of our search request.
    try {
      if ($response->getReasonPhrase() != 'OK') {
        throw new Exception(t(
          'Received status @status',
          array('$status' => $response->getReasonPhrase())
        ));
      }

      // If we have something, list the results.
      $data = $this->serialization_json->decode($response->getBody());
      $results = $data['items'];

      // Loop through the results.
      for ($i = 0; isset($results[$i]); $i++) {
        // Create the video URL.
        $video_url = $this->getVideoURl($results[$i]);

        // Check to see if we have the video url imported.
        $is_new = $this->uniqueField('field_video', $video_url);
        // If we don't have it imported, import it.
        if ($is_new) {}

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

  /**
   * @param string $search_terms
   * @return string
   */
  protected function getSearchURL($search_terms = '') {
    $search_url = '';
    $search_url = URL::fromUri(
      'https://www.googleapis.com/youtube/v3/search',
      [ 'query' => [
        'q'           => urlencode($search_terms),
        'part'        => 'snippet',
        'type'        => 'video',
        'safeSearch'  => 'strict',
        'maxResults'  => '50',
        'key'         => $_SERVER['GGL_API_KEY']
      ]])->toUriString();
    return $search_url;
  }

  /**
   * Helper method to return the video URL
   * @param array $item
   * @return string
   */

  protected function getVideoURL($item = []) {
    $video_url = '';

    $video_url = Url::fromUri(
      'https://www.youtube.com/watch',
      [ 'query' => [
        'v' => $item['id']['videoId']
      ]])->toUriString();

    return $video_url;
  }

  /**
   * Check if file is unique among nodes.
   *
   * @param string $field
   * @param string $value
   * @return bool
   */
  protected function uniqueField($field = '', $value = '') {
    $result = $this->entity_query->get('node')
      ->condition($field, $value, '=')
      ->execute();

    $unique = empty($result);

    return $unique;
  }

}
