<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>

  <h2><?php echo $post['post_title']; ?></h2>
  <date>
    <?php echo $this->Custom_Dates->get_nice_date($post['post_date'],'full_date_time'); ?>
  </date>
  <p><?php echo $post['post_body']; ?></p>
