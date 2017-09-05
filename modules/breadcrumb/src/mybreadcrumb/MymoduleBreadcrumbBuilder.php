<?php
namespace Drupal\breadcrumb\mybreadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;

class MymoduleBreadcrumbBuilder implements BreadcrumbBuilderInterface{
   /**
    * {@inheritdoc}
    */
   public function applies(RouteMatchInterface $attributes) {
       $parameters = $attributes->getParameters()->all();
       // kint($parameters);
       if (!empty($parameters['node'])) {
           return $parameters['node']->getType() == 'events';
       }
   }

   /**
    * {@inheritdoc}
    */
   public function build(RouteMatchInterface $route_match) {
        // kint($route_match);
       $breadcrumb = new Breadcrumb();
       $breadcrumb->addLink(Link::createFromRoute('Home','<front>'));
       $breadcrumb->addLink(Link::createFromRoute('Events','view.events.page_1'));
       // kint($breadcrumb);
       return $breadcrumb;
   }

}
?>