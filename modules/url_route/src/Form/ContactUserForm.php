<?php
namespace Drupal\url_route\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Node\NodeInterface;
/**
 * Configure example settings for this site.
 */
class ContactUserForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mycustom';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $config = $this->config('example.settings');
    dpm($node->title->value);
    // dpm($node);
    dpm($node->type->target_id);
    dpm($node->langcode->value);
    dpm($node->uuid->value);
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
    );  

    $form['messg'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
    ); 
     // echo "hello"; 


    return parent::buildForm($form, $form_state);
   
        // $height = $myConfig->get('large_video_height');
  }

  /** 
   * {@inheritdoc}
   */
 


}



?>