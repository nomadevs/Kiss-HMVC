<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>
<h1>Blog</h1>
<?php foreach( $posts as $post ) : ?>
  <h2><a href="<?php echo base_url("blog/post/$post[post_slug]"); ?>"><?php echo $post['post_title']; ?></a></h2>
  <date>
    <?php echo $this->Custom_Dates->get_nice_date($post['post_date'],'full_date_time'); ?>
  </date>
  <p><?php echo word_limiter($post['post_body'],25,'&nbsp;[ ... ]'); ?></p>
  <hr />
<?php endforeach; ?>