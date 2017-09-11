<?php
namespace Drupal\sheet_integration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\file\Entity\File;

$module_handler = \Drupal::service('module_handler');
$path = $module_handler->getModule('sheet_integration')->getPath();
define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', \Drupal::service('file_system')->realpath(file_default_scheme() . "://").'/sheets.googleapis.com-php-formint.json');
define('CLIENT_SECRET_PATH',  $_SERVER['DOCUMENT_ROOT'].'/'.$path.'/client_secret.json');

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
function getClient() {
  require_once $_SERVER['DOCUMENT_ROOT']. '/modules/sheet_integration/vendor/autoload.php';    
  define('SCOPES', implode(' ', array(
          \Google_Service_Sheets::SPREADSHEETS)
    ));   
    $client = new \Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
    // Load previously authorized credentials from a file.
    $credentialsPath = CREDENTIALS_PATH;
    if (file_exists($credentialsPath)) 
    {
      $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } 
    else 
    {
      //Request authorization from the user.
      $authUrl = $client->createAuthUrl();
        if(get1('code')){
          $authCode=get1('code');
         }
        else{
         $response= new RedirectResponse($authUrl);
         $response->send();
         return;
         }
        $authCode=get1('code');
        //Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        if(!file_exists($credentialsPath)) 
        {           
          mkdir(dirname($credentialsPath), 0777, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
        $config = \Drupal::service('config.factory')->getEditable('sheet_int_form.settings');
        //Set and save new message value.
        $config->set('code', $authCode)->save();
        $myconfig = \Drupal::config('sheet_int_form.settings');
    }
    $client->setAccessToken($accessToken);
        // Store the refresh token credentials to disk.
        // if(!file_exists(dirname($credentialsPath))) {
        //   mkdir(dirname($credentialsPath), 0700, true);
        // }
        //file_put_contents($credentialsPath, json_encode($accessToken));
        // printf("Credentials saved to %s\n", $credentialsPath);
    return $client;
  }
  $client = getClient();
  $client = getClient();
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
    'client' => $form_state->getValue('client'),          
  ))->execute();
  }
}  
/**
 * Implements get1() for fetching code from url.
**/
}
function get1($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}


?>