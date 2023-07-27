<?php

namespace Drupal\ckeditor5_embedded_content_media\Plugin\EmbeddedContent;

use Drupal\ckeditor5_embedded_content\EmbeddedContentInterface;
use Drupal\ckeditor5_embedded_content\EmbeddedContentPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Plugin iframes.
 *
 * @EmbeddedContent(
 *   id = "media",
 *   label = @Translation("Media"),
 *   description = @Translation("Renders a media entity."),
 * )
 */
class Media extends EmbeddedContentPluginBase implements EmbeddedContentInterface {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'media_ref' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $media = \Drupal::entityTypeManager()->getViewBuilder('media')->view($this->configuration['media_ref']);
    return [
      '#theme' => 'ckeditor5_embedded_content_media_media',
      '#media' => $media,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['media_ref'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => t('Upload your image'),
      '#default_value' => $this->configuration['media_ref'],
      '#description' => t('Upload or select your profile image.'),
    ];

    return $form;
  }

}
