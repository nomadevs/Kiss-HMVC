<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>

<nav class="navbar navbar-default navbar-custom" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo base_url(); ?>"><!--<img src="<?php //echo base_url('assets/img/kisshmvc.png'); ?>" alt="KissHMVC Logo" width="52" height="47">-->KissHMVC</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url('home'); ?>">Pages Controller</a></li>
                <li><a href="<?php echo base_url('blog'); ?>">Blog Module</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-fw fa-ellipsis-h"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">...</a></li>
                    <li><a href="#">...</a></li>
                    <li><a href="#">...</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Link Group Title</li>
                    <li><a href="#">...</a></li>
                    <li><a href="#">...</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!--/.container-fluid -->
        </nav>