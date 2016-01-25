<?php

/**
 * @file
 * Contains Drupal\fastpaced_videos\Form\ImportSettingsForm.
 */

namespace Drupal\fastpaced_videos\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ImportSettingsForm.
 *
 * @package Drupal\fastpaced_videos\Form
 */
class ImportSettingsForm extends ConfigFormBase {

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
    return 'import_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('fastpaced_videos.importsettings');
    $form['import_max'] = array(
      '#type' => 'number',
      '#title' => $this->t('Import Max'),
      '#description' => $this->t('Maximum amount of nodes to import pre cron run'),
      '#default_value' => $config->get('import_max'),
    );
    $form['search_terms'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Search Terms'),
      '#maxlength' => 225,
      '#size' => 64,
      '#default_value' => $config->get('search_terms'),
    );
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
      ->set('import_max', $form_state->getValue('import_max'))
      ->set('search_terms', $form_state->getValue('search_terms'))
      ->save();
  }

}
