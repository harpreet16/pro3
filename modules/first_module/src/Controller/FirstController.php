<?php


/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstController.
 */
 
namespace Drupal\first_module\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class FirstController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world'),

    );   

  }
   public function roles() {
  	    $role = \Drupal\user\Entity\Role::loadMultiple();
   		// kint($role);
   		$site_languages = \Drupal::languageManager()->getLanguages();
   		// kint($site_languages);
   		$str = null;
   		foreach ($role as $key => $value) {
   			$str = $str."<br>".$key;
   		}	
   		foreach ($site_languages as $key1 => $value) {
   			$str1 = $str1."<br>".$key1;
   		}
   		return array('#type'=>'markup',  '#markup' => $str.$str1);
   		// return array('#type'=>'markup',  '#markup' => $str1);
  }
}