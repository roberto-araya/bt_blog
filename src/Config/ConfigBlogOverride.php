<?php

namespace Drupal\bt_blog\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigBlogOverride implements ConfigFactoryOverrideInterface {

  private $createContent;
  private $deleteContent;
  private $deleteOwnContent;
  private $editContent;
  private $viewsAdminContent;
  private $viewsFullAdminContent;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->createContent = $configFactory->get('user.role.bt_create_content');
    $this->deleteContent = $configFactory->get('user.role.bt_delete_content');
    $this->deleteOwnContent = $configFactory->get('user.role.bt_delete_own_content');
    $this->editContent = $configFactory->get('user.role.bt_edit_publish_content');
    $this->viewsAdminContent = $configFactory->get('views.view.bt_admin_content');
    $this->viewsFullAdminContent = $configFactory->get('views.view.bt_full_admin_content');
  }

  /**
   * {@inheritdoc}
   */
  public function loadOverrides($names) {
    $overrides = array();

    // Add blog permissions to bt_create_content role.
    if (in_array('user.role.bt_create_content', $names)) {
      $blog_permissions = [
        'create blog_post content',
        'edit own blog_post content',
        'revert blog_post revisions',
        'view blog_post revisions',
      ];
      $content_role = $this->createContent;
      $permissions = array_merge($content_role->get('permissions'), $blog_permissions);
      $overrides['user.role.bt_create_content']['permissions'] = $permissions;
    }
    // Add blog permissions to bt_delete_content role.
    if (in_array('user.role.bt_delete_content', $names)) {
      $blog_permissions = [
        'delete any blog_post content',
        'delete blog_post revisions',
      ];
      $content_role = $this->deleteContent;
      $permissions = array_merge($content_role->get('permissions'), $blog_permissions);
      $overrides['user.role.bt_delete_content']['permissions'] = $permissions;
    }
    // Add blog permissions to bt_delete_own_content role.
    if (in_array('user.role.bt_delete_own_content', $names)) {
      $blog_permissions = [
        'delete own blog_post content',
      ];
      $content_role = $this->deleteOwnContent;
      $permissions = array_merge($content_role->get('permissions'), $blog_permissions);
      $overrides['user.role.bt_delete_own_content']['permissions'] = $permissions;
    }
    // Add blog permissions to bt_edit_publish_content role.
    if (in_array('user.role.bt_edit_publish_content', $names)) {
      $blog_permissions = [
        'edit any blog_post content',
      ];
      $content_role = $this->editContent;
      $permissions = array_merge($content_role->get('permissions'), $blog_permissions);
      $overrides['user.role.bt_edit_publish_content']['permissions'] = $permissions;
    }
    $blog_values = [
      'blog_post' => 'blog_post',
    ];
    // Add blog filter values to views.view.bt_admin_content view.
    if (in_array('views.view.bt_admin_content', $names)) {
      $views = $this->viewsAdminContent;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $blog_values);
      $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
      $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
    }
    // Add blog filter values to views.view.bt_full_admin_content view.
    if (in_array('views.view.bt_full_admin_content', $names)) {
      $views = $this->viewsFullAdminContent;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $blog_values);
      $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
      $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
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
