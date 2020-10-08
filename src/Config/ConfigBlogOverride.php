<?php

namespace Drupal\bt_blog\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigBlogOverride implements ConfigFactoryOverrideInterface {

  /**
   * View configuration object of bt_content.
   *
   * @var viewsAdminContent
   */
  private $viewsAdminContent;

  /**
   * Editorial workflow configuration object.
   *
   * @var workflow
   */
  private $workflow;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->viewsAdminContent = $configFactory->get('views.view.bt_content');
    $this->workflow = $configFactory->get('workflows.workflow.editorial');
  }

  /**
   * {@inheritdoc}
   */
  public function loadOverrides($names) {
    $overrides = [];

    $blog_values = [
      'blog_post' => 'blog_post',
    ];

    // Add article filter values to views.view.bt_content view.
    if (in_array('views.view.bt_content', $names)) {
      $views = $this->viewsAdminContent;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $blog_values);
      $overrides['views.view.bt_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
    }

    if (in_array('workflows.workflow.editorial', $names)) {
      $workflow = $this->workflow;
      $entity_types_values = $workflow->get('type_settings.entity_types');
      if (is_array($entity_types_values) && array_key_exists('node', $entity_types_values)) {
        $entity_types_values['node'][] = 'blog_post';
        $overrides['workflows.workflow.editorial']['type_settings']['entity_types']['node'] = $entity_types_values['node'];
      }
      else {
        $values = ['blog_post'];
        $overrides['workflows.workflow.editorial']['type_settings']['entity_types']['node'] = $values;
      }
    }
    return $overrides;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheSuffix() {
    return 'ConfigBlogOverride';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }

}
