<?php
/**
 * @file
 * Contains \Drupal\form_in_cntr\Controller\MyExposedListBuilderr.
 */
namespace Drupal\form_in_cntr\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder; 
use Drupal\Core\Form\FormBuilderInterface; 
use Drupal\Core\Render\Renderer;

class MyExposedListBuilder extends EntityListBuilder {

  public function render() {
    //Exposed form
    $form = \Drupal::formBuilder()->getForm('Drupal\form_in_cntr\Form\MyEntityExposedFilters');
    $build['form'] = $form;

    //Result table
    $build += parent::render();
    return $build;
  }

  /**
   * Loads entity IDs using a pager sorted by the entity id.
   */
  protected function getEntityIds() {
    $form_id = \Drupal::request()->get('form_id');
    if ($form_id && $form_id === 'my_test_form_id') {
      $query = \Drupal::entityQuery($this->entityTypeId);
      $text = \Drupal::request()->get('text');
      $query->condition('text', $text, 'CONTAINS');
      if ($this->limit) {
        $query->pager($this->limit);
      }
      $res = $query->execute();
    }
    else {
      $res = parent::getEntityIds();
    }
    return $res;
  }
}
?>
