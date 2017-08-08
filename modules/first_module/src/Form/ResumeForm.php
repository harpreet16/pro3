<?php
namespace Drupal\first_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ResumeForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'example_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'example.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('example.settings');

    $form['script'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Script'),
      '#default_value' => $config->get('script'),
    );  

    $form['url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Url'),
      '#default_value' => $config->get('url'),
    ); 
     // echo "hello"; 


    return parent::buildForm($form, $form_state);
   
        // $height = $myConfig->get('large_video_height');
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->config('example.settings')
      // Set the submitted configuration setting
      ->set('script', $form_state->getValue('script'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('url', $form_state->getValue('url'))
      ->save();

    parent::submitForm($form, $form_state);


  }


}



?>