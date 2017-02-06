<?php

namespace Drupal\dvm_mailing_list;

use Drupal\group\Entity\GroupContent;
use Drupal\node\Entity\Node;
use Drupal\group\Entity\Group;



class BatchMailingList {

  public static function addMembers($uids, &$context) {


  }

  public static function getMembership($gids, &$context) {
    if (!isset($context['sandbox']['progress'])) {
      $context['sandbox']['progress'] = 0;
      $context['sandbox']['current_node'] = 0;

      foreach ($gids as $gid) {
        $gid = $gid['target_id'];
        /** @var Group $group */
        $group = Group::load($gid);

        $membership = $group->getMembers([$group->bundle().'-organisation']);

        foreach ($membership as $membershipgc) {
          /** @var GroupContent $membershipgc */
          $org_uid[] = $membershipgc->getEntity()->id();

        }



      }
      $context['sandbox']['max'] = count($data['gid']);
    }
  }

  public static function addIssues($nids, &$context) {


  }

  public static function cleanupIssues(&$context) {


  }

  public static function cleanupMembers(&$context) {


  }


  public static function deleteNodeExampleFinishedCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One post processed.', '@count posts processed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }


}
