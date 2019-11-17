<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $site_title; ?></title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/kiss-theme.css'); ?>" rel="stylesheet" />
  </head>
  <body class="<?php echo $body_class; ?>">
  	<div class="container">

<?php $this->load->view('navbar'); ?>