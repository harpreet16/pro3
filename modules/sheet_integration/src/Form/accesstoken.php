<?php
/**
 * @file
 * Contains \Drupal\sheet_integration\Form.
 */
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
class accesstoken extends ConfigFormBase {
public function getFormId() {
  return 'access_token_form';
}
protected function getEditableConfigNames() {
  return [
    'access_token_form.settings',
  ];
}
/**
 * Implements function buildform().
**/
public function buildForm(array $form, FormStateInterface $form_state) {
if(file_exists(CREDENTIALS_PATH)){
  drupal_set_message(t('You have already acquired your client credentials'));
}
else{ 
function getClient() {
  require_once $_SERVER['DOCUMENT_ROOT']. '/modules/sheet_integration/vendor/autoload.php';    
  if(get1('code')){ 
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
    $authCode=get1('code');
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);     
    if(!file_exists($credentialsPath)) 
    {           
      mkdir(dirname($credentialsPath), 0777, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    drupal_set_message(t('Your credentials have been saved to '.$credentialsPath));
    //printf("Credentials saved to %s\n", $credentialsPath);       
  }
  $client->setAccessToken($accessToken);
  return $client;
}
}
$client=getClient();
$client=getClient();
$config = \Drupal::service('config.factory')->getEditable('access_token_form.settings');
$config->set('client', serialize($client))->save();
  $form['submit'] = array(
  '#type' => 'submit',
  '#value' => 'Generate Token',
  ); 
  return $form;
}
}
/**
 * Implements submitForm().
**/
public function submitForm(array &$form, FormStateInterface $form_state ) { 
require_once $_SERVER['DOCUMENT_ROOT']. '/modules/sheet_integration/vendor/autoload.php';    
  define('SCOPES', implode(' ', array(
          \Google_Service_Sheets::SPREADSHEETS)
    ));
  $credentialsPath = CREDENTIALS_PATH;  
  if(!file_exists($credentialsPath)){   
    $client = new \Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
      //Request authorization from the user.
      $authUrl = $client->createAuthUrl();
       $response= new RedirectResponse($authUrl);
       $response->send();
       }
}

}
 function get1($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}



?>