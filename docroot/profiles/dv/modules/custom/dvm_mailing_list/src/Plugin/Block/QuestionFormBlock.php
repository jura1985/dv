<?php
namespace Drupal\dvm_mailing_list\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\group\Entity\Group;

/**
 * Provides a 'Demo' block.
 *
 * @Block(
 *   id = "question_form_block",
 *   admin_label = @Translation("Question form block"),
 * )
 */
class QuestionFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $values = array('type' => 'question');

    $node = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->create($values);

    $form = \Drupal::entityTypeManager()
      ->getFormObject('node', 'default')
      ->setEntity($node);

    $form = \Drupal::formBuilder()->getForm($form);

    return $form;
  }

  public function access(AccountInterface $account, $return_as_object = FALSE) {
    $group = \Drupal::routeMatch()->getParameter('group');
    return $group->hasPermission('edit group', $account);
  }

}
