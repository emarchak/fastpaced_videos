<?php

/**
 * @file
 * Contains Drupal\fastpaced_videos\Form\ConfigForm.
 */

namespace Drupal\fastpaced_videos\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\fastpaced_videos\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'fastpaced_videos.importsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('fastpaced_videos.importsettings');
    $form['search_terms'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Terms'),
      '#description' => $this->t('Terms to search for'),
      '#maxlength' => 255,
      '#size' => 64,
      '#default_value' => $config->get('search_terms'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('fastpaced_videos.importsettings')
      ->set('search_terms', $form_state->getValue('search_terms'))
      ->save();
  }

}
