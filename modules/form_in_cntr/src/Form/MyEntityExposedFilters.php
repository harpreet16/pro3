<?php
namespace Drupal\form_in_cntr\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class MyEntityExposedFilters extends FormBase {

  public function getFormId() {
    return 'my_test_form_id';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    kint($form);
    $form = array();
    $form['filters']['text'] = array(
      '#title' => $this->t('Text'),
      '#type' => 'textfield',
      '#default_value' => \Drupal::request()->get('text'),
    );
    $form['filters']['submit_apply'] = [
      '#type' => 'submit',
      '#value' => t('Filter'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle Submit on MyExposedListBuilder.
  }
}
?>