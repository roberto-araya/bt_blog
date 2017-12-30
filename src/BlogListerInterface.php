<?php

/**
 * @file
 * Contains \Drupal\book\BlogListerInterface.
 */

namespace Drupal\bt_blog;

use Drupal\user\UserInterface;

/**
 * Provides an interface defining a blog lister.
 */
interface BlogListerInterface {

  /**
   * Returns a title for a user blog
   *
   */
  public function userBlogTitle(UserInterface $user);

}
