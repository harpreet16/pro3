<?php

namespace Drupal\sheet_integration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;



class SheetconfigForm extends ConfigFormBase {

  public function getFormId() {
    return 'sheet_int_form';
  }
  protected function getEditableConfigNames() {
    return [
      'sheet_int_form.settings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // kint($form);
    $form['sheet_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Sheet Id'),
    ); 
    $form['cid'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Contact_form_id'),
    ); 
    $form['client']= array(
      '#type' => 'hidden',
      '#value' => 'default,' 
      ); 
     $form['token_info']= array(
      '#type' => 'hidden',
      '#value' => 'default,' 
      ); 
    $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
  ); 

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) { 
     
      $this->config('sheet_int_form.settings')
      // Set the submitted configuration setting
      ->set('sheet_id', $form_state->getValue('sheet_id'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('cid', $form_state->getValue('cid'))
      ->save();
    //   db_insert('sheetint')
    // ->fields(array(
    //   'sheet_id' => $form_state->getValue('sheet_id'),
    //   'cid' => $form_state->getValue('cid'),          
    // ))->execute();
      // parent::submitForm($form, $form_state);
      // $form_state->redirect==NULL;
  }


}
?>