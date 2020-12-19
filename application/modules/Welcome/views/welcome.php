<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
      <title><?php echo $page_title; ?></title>
    <style>
      ::selection { background-color: #E13300; color: white; }
      ::-moz-selection { background-color: #E13300; color: white; }

      body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
      }

      a {
        color: #dd4814;
        background-color: transparent;
        font-weight: normal;
      }

      u {
        color: #dd4814;
      }

      h1 {
        color: #dd4814;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 19px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
      }

      code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 12px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #dd4814;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
      }

      #body {
        margin: 0 15px 0 15px;
      }

      #footer {
        color: #dd4814;
        text-align: right;
        font-size: 11px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
      }

      #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
      }
    </style>
  </head>
  <body class="<?php echo $body_class; ?>">
    <div id="container">
      <h1><?php echo $page_title; ?></h1>

      <div id="body">
        
        <p>KissHMVC dynamically rendered this page.</p>

        <p>If you would like to edit this page you can do so by navigating here:</p>
        <code>application/modules/Welcome/views/welcome.php</code>

        <p>The module controller for this page is located here:</p>
        <code>application/modules/Welcome/controllers/Welcome.php</code>

        <p>To get stated, vist the <a href="./user_guide/">User Guide</a>.</p>
		
      </div>
      <footer id="footer" class="footer">KissHMVC Version <strong><?php echo KISS_VERSION; ?></strong></footer>
    </div>
  </body>
</html>
