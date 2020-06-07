<?php

namespace Drupal\tailwindcss_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Base class of layouts.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutBase extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $backgroundClasses = array_keys($this->getBackgroundClassOptions());
    $containerClasses = array_keys($this->getContainerClassOptions());

    return [
      'background' => array_shift($backgroundClasses),
      'container' => array_shift($containerClasses),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['container'] = [
      '#type' => 'select',
      '#title' => $this->t('Container Width'),
      '#default_value' => $this->configuration['container'],
      '#options' => $this->getContainerClassOptions(),
      '#description' => $this->t('Choose a container width.'),
    ];

    $form['background'] = [
      '#type' => 'select',
      '#title' => $this->t('Background Color'),
      '#default_value' => $this->configuration['background'],
      '#options' => $this->getBackgroundClassOptions(),
      '#description' => $this->t('Choose a background color.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['background'] = $form_state->getValue('background');
    $this->configuration['container'] = $form_state->getValue('container');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    $build['#attributes']['class'] = [];
    $build['#settings']['wrapper_classes'] = '';

    if (!empty($this->configuration['container'])) {
      $containerClasses = $this->getContainerClasses($this->configuration['container']);

      foreach ($containerClasses as $containerClass) {
        $build['#attributes']['class'][] = $containerClass;
      }
    }

    if (!empty($this->configuration['background'])) {
      $backgroundClasses = $this->getBackgroundClasses($this->configuration['background']);

      $build['#settings']['wrapper_classes'] = implode(' ', $backgroundClasses);
    }

    return $build;
  }

  /**
   * Gets the background class options for the configuration form.
   *
   * The first option will be used as the default 'background'
   * configuration value.
   *
   * @return string[]
   *   The class options array where the keys are strings that will be added to
   *   the CSS classes and the values are the human readable labels.
   */
  protected function getBackgroundClassOptions() {
    return [
      '' => 'White',
      'bg-dark-indigo' => 'Dark Indigo',
      'gray' => 'Gray',
    ];
  }

  /**
   * Gets classes for a background class key.
   *
   * @param string $option
   *   The background class key.
   *
   * @return mixed
   *   Returns an array of background classes.
   */
  protected function getBackgroundClasses($option) {
    $classMap = [
      'bg-dark-indigo' => [
        'bg-indigo-800',
      ],
      'gray' => [
        'bg-gray-100',
      ],
    ];

    return $classMap[$option];
  }

  /**
   * Gets the container class options for the configuration form.
   *
   * The first option will be used as the default 'container'
   * configuration value.
   *
   * @return string[]
   *   The class options array where the keys are strings that will be added to
   *   the CSS classes and the values are the human readable labels.
   */
  protected function getContainerClassOptions() {
    return [
      'fixed' => 'Fixed',
      'fluid' => 'Full',
    ];
  }

  /**
   * Gets classes for a container class key.
   *
   * @param string $option
   *   The container class key.
   *
   * @return mixed
   *   Returns an array of container classes.
   */
  protected function getContainerClasses($option) {
    $classMap = [
      'fixed' => [
        'container',
        'mx-auto',
        'flex',
        'flex-wrap',
      ],
      'fluid' => [
        'flex',
        'flex-wrap',
      ],
    ];

    return $classMap[$option];
  }

}
