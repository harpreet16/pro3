<?php
namespace Drupal\sheet_integration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
define('CREDENTIALS_PATH', \Drupal::service('file_system')->realpath(file_default_scheme() . "://").'/sheets.googleapis.com-php-formint.json');

class SheetconfigForm extends ConfigFormBase {
public function getFormId() {
  return 'sheet_int_form';
}
protected function getEditableConfigNames() {
  return [
    'sheet_int_form.settings',
  ];
}
/**
 * Implements function buildform().
**/
public function buildForm(array $form, FormStateInterface $form_state) {
  if(!file_exists(CREDENTIALS_PATH)){
    drupal_set_message(t('You do not have access to spreadsheet services.Visit /generatetoken.com and Generate token'));
    //dpm(CREDENTIALS_PATH);
  }
  else{
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
      '#value' => serialize($client), 
    ); 
    $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
    ); 
    return $form;
  }
}
/**
 * Implements submitForm().
**/
public function submitForm(array &$form, FormStateInterface $form_state ) { 
$sql1="SELECT * from sheet_integration where cid='".$form_state->getValue('cid')."'";
$result1=db_query($sql1);
$result1->allowRowCount = TRUE;
$num_of_results = $result1->rowCount();
 if($num_of_results == 0){
     db_insert('sheet_integration')
    ->fields(array(
    'sheet_id' => $form_state->getValue('sheet_id'),
    'cid' => $form_state->getValue('cid'),
    'client' => \Drupal::config('access_token_form.settings')->get('client'),          
  ))->execute();
  }
  else{
    db_update('sheet_integration')
  ->fields([
    'sheet_id' => $form_state->getValue('sheet_id'),
  ])
  ->condition('cid', $form_state->getValue('cid'), '=')
  ->execute();
  }
}  

}



?>