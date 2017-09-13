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
    drupal_set_message(t('You do not have access to spreadsheet services yet. Visit /sheetintegration.com and Generate token'));
    //dpm(CREDENTIALS_PATH);
  }
  else{
    $db = \Drupal::database();
    $result = $db->select('key_value', 'n')->condition('collection', "config.entity.key_store.contact_form", "=")->fields('n')->execute()->fetchAll();
    foreach($result as $row){
        $str_new=substr_replace(unserialize($row->value)[0], 'contact_message_', 0 , 13);    
        $str_new=$str_new.'_form';
        $formarray[]=$str_new;       
    }
    //print_r($formarray);
    $form['sheet_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Google Spreadsheet Id'),
    ); 
    $form['cid'] = array(
      '#type' => 'select',
      '#options' => $formarray,
      '#title' => $this->t('Drupal Contact Form Id'),
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
$sql1="SELECT * from sheet_integration where cid='".$form_state->getValue('cid')."' or sheet_id='".$form_state->getValue('sheet_id')."'";
$result1=db_query($sql1);
$result1->allowRowCount = TRUE;
$num_of_results = $result1->rowCount();
  if($num_of_results == 0 && $form_state->getValue('sheet_id')!=NULL && $form_state->getValue('cid')!=NULL){
     db_insert('sheet_integration')
    ->fields(array(
    'sheet_id' => $form_state->getValue('sheet_id'),
    'cid' => ($form['cid']['#options'][$form_state->getValue('cid')]),
    'client' => \Drupal::config('access_token_form.settings')->get('client'),          
  ))->execute();
  }
  else if($num_of_results==1 && $form_state->getValue('sheet_id')!=NULL && $form_state->getValue('cid')!=NULL){
    db_update('sheet_integration')
  ->fields([
    'sheet_id' => $form_state->getValue('sheet_id'),
  ])
  ->condition('cid', ($form['cid']['#options'][$form_state->getValue('cid')]), '=')
  ->execute();
  }
  $form_state->setRedirect('sheet_integration.display');
}  

}



?>