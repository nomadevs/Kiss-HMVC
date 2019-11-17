<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>

<h2><?php echo $page_title; ?></h2>
<?php echo anchor('', 'Click here'); ?>
<?php echo form_open('',['id'=>'test-form']); ?>

<?php echo form_input(['placeholder'=>'username', 'class'=>'form-control', 'name'=>'username']); ?>
<?php echo form_error('username','<p class="text-danger">','</p>'); ?>

<?php echo form_input(['placeholder'=>'email', 'class'=>'form-control', 'name'=>'email']); ?>
<?php echo form_error('email','<p class="text-danger">','</p>'); ?>
<?php echo form_submit(['value'=>'Submit', 'name'=>'Submit', 'class'=>'form-control']); ?>
<?php echo form_close(); ?>
<?php //echo validation_errors(); ?>