<?php
/**
 * @file
 * Contains \Drupal\mymodule\Plugin\Derivative\MyModuleMenuLinkDerivative.
 */

namespace Drupal\bt_blog\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\page_manager\Entity\Page;

/**
 * Provides menu links of all Node entities with type "Page".
 */
class IpePageMenuLinkDerivative extends DeriverBase {

    /**
     * {@inheritdoc}
     */
    public function getDerivativeDefinitions($base_plugin_definition) {
        $links = array();
        $pages = [
            'blog' => 'Todas las entradas de blog del sitio'
        ];
        foreach ($pages as $page_name => $description) {
            $page = Page::load('ipe_' . $page_name);
            $peso = 4;
            $route_name = 'page_manager.page_view_ipe_' . $page_name . '_ipe_' . $page_name . '-panels_variant-0';
            if ($page->status()) {
                $links['main_' . $page->id()] = [
                        'title' => $page->label(),
                        'description' => $description,
                        'menu_name' => 'main',
                        'weight' => $peso,
                        'route_name' => $route_name,
                    ] + $base_plugin_definition;
            }
            $peso++;
        }
        return $links;
    }
}