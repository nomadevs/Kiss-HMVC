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
      <h1><?php echo $page_title; ?> (A DUMBED DOWN VERSION OF CODEIGNITER)</h1>

      <div id="body">
        <p>KissHMVC is modeled after the <a href="https://codeigniter.com/" target="_blank">CodeIgniter</a> framework which I personally like to use because it's simple to understand and isn't bloated like other frameworks. KissHMVC follows the same philosophy! KissHMVC uses some modified code from the CodeIgniter framework (v3.1.11) and includes any necessary attribution (i.e. copyrights, and licenses). It's also a mashup of my own code, code from around the web, studying everything to the best of my knowledge, a crap load of trial & error, and this is the result! If you trust my code feel free to use it but make sure to keep all licenses and copyrights intact if you plan to make derivatives of it. Especially, since my framework is also a derivative of CodeIgniter and shares the same license! <u>If you do want to make derivatives of my framework, please let me know so I can mention you on my website!</u> If you're worried about security be sure to look through my code and make any necessary changes to secure it yourself, if you spot anything I may have missed. I have covered security for the most part so it's fairly secure. However, don't rely on that! My code should be simple enough to understand. I believe code should be simple to read in case you come back to it years later but also for new coders that are still learning themselves.</p>

        <p>I'm not claiming to be a PHP expert and like any framework there could be vulnerabilities as I've stated above. <strong>You've been warned!</strong> I'm also not entirely sure how stable my framework is or how well it will hold up to massive applications. But since some of the code used comes from CodeIgniter you should have no problems. I'd be interested to hear back from some of you that have attempted. The great thing about my framework is that it's the best of both worlds. You can use normal MVC which has the added bonus of loading Controllers inside other controllers, unlike CodeIgniter, which only lets you load Models and Views in controllers. Or, you have the option to use Modules &#40; another feature CI doesn't offer straight out of the box &#41; to organize your application.</p>

        <p>If you're familiar with CodeIgniter then KissHMVC will be easy to learn. I'm not trying to compete with other frameworks although that may be a possibility in the future depending on any contributers that would like to help me make that a reality and also my ability to make progress on it myself. I'd also like to make a side note that there's a framework coming out at the end of 2019 called <a href="https://trongate.io/" target="_blank">Trongate</a> by a YouTuber I follow which will also have similar syntax to CodeIgniter and also make use of Modules. So if you like CodeIgniter and Modules then you will also want to check that out and especially since that will be much safer to use than my framework at the moment.</p>

        <p>Furthermore, I'm still working out the bugs, fine tuning things, and studying CodeIgniter's code to get a general idea of how it works so I can make the necessary changes in my framework minus things I don't want in my framework. So keep checking back often for updates as I continue to make progress! If you would like to contribute, give me coding tips, please contact me here. I look forward to hearing from you and happy coding! =^)</p>

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