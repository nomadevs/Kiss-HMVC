# ![Logo](assets/img/kisshmvc.png) (K.I.S.S.H.M.V.C.) Keep-It-Simple-Stupid-Hierarchical-Model-View-Controller (CodeIgniter's illegitimate lovechild ;-)

![License](https://img.shields.io/badge/Licence-MIT-green.svg)
![PHP](https://img.shields.io/badge/php-<%3D7.3.7-blue)
![Version](https://img.shields.io/badge/version-1.0.0-red)

> **UPDATES** - I've made some progress on my framework. A lot of improvements and fixed bugs. Still has some, however. I can't update the repository until I renew my data plan very soon. Planning on switching carriers for truly unlimited internet, but I digress. I'm also integrating SQLite3 in to the Database class as a "driver" for those interested in Dev testing. **[12/22/20]**

> **UPDATES** - I've begun working on this project again after a year. I recommend not using yet until a more stable version is released. Not everything works at the moment. Having to restudy my code again but it's coming back to me. **[12/20/20]**

*KissHMVC* is modeled after the [CodeIgniter](https://codeigniter.com/) framework which I personally like to use because it's simple to understand and isn't bloated like other frameworks. *KissHMVC* follows the same philosophy! KissHMVC uses some modified code from the CodeIgniter framework (**v3.1.11**) and includes any necessary attribution (i.e. copyrights, and licenses). It's also a mashup of my own code, code from around the web, studying everything to the best of my knowledge, a crap load of trial & error, and this is the result! If you trust my code feel free to use it but make sure to keep all licenses and copyrights intact if you plan to make derivatives of it. Especially, since my framework is also a derivative of CodeIgniter and shares the same license! **If you do want to make derivatives of my framework, please let me know so I can mention you on my website!** If you're worried about security be sure to look through my code and make any necessary changes to secure it yourself, if you spot anything I may have missed. I have covered security for the most part so it's fairly secure. However, don't rely on that! My code should be simple enough to understand. I believe code should be simple to read in case you come back to it years later but also for new coders that are still learning themselves.

I'm not claiming to be a PHP expert and like any framework there could be vulnerabilities as I've stated above. **You've been warned!** I'm also not entirely sure how stable my framework is or how well it will hold up to massive applications. But since some of the code used comes from CodeIgniter you should have no problems. I'd be interested to hear back from some of you that have attempted. The great thing about my framework is that it's the best of both worlds. You can use normal MVC which has the added bonus of loading *Controllers* inside other controllers, unlike CodeIgniter, which only lets you load *Models* and *Views* in controllers. Or, you have the option to use *Modules* ( another feature CI doesn't offer straight out of the box ) to organize your application.

If you're familiar with CodeIgniter then *KissHMVC* will be easy to learn. I'm not trying to compete with other frameworks although that may be a possibility in the future depending on any contributers that would like to help me make that a reality and also my ability to make progress on it myself. I'd also like to make a side note that there's a framework coming out in the beginning of 2021 called [Trongate](https://trongate.io/) by a YouTuber (David Connelly) which will also have similar syntax to CodeIgniter and also make use of Modules. So if you like CodeIgniter and Modules then you will also want to check that out and especially since that will be much safer to use than my framework at the moment.

Furthermore, I'm still working out the bugs, fine tuning things, and studying CodeIgniter's code to get a general idea of how it works so I can make the necessary changes in my framework minus things I don't want in my framework. So keep checking back often for updates as I continue to make progress! If you would like to contribute, give me coding tips, please contact me [here](#contact). I look forward to hearing from you and happy coding! =^)

## Table of Contents
- [Installation](#installation)
  - [Requirements](#requirements)
- [Documentation](#documentation)
- [Tutorials (Example Usage)](#tutorials-example-usage)
  - [Create a Page Controller](#create-a-page-controller)
  - [Create a Blog Module](#create-a-blog-module)
  - [Create a Template Module](#create-a-template-module)
- [Contribute](#contribute)
  - [Contact](#contact)
- [Changelog](#changelog)
- [License](#license)
- [Credits](#credits)

## Requirements
- Still testing compatability with 5.6 - 7.1+

## Documentation
A work in progress; Simply extract the zip folder you downloaded from this repository in to the root folder where you're hosting your website and navigate to: <https://www.your_website.com/user_guide> **OR** <https://localhost/user_guide> in your browser to view the documentation. However, documenation is lacking at the moment. I'll be making progress on it as soon as possible.

## Installation
Setup your *.htaccess* file by navigating to the root of the packaged files. Open the htaccess file and between the forward slashes ( */* ) put your folder or if you have no folder and you extracted to the root of your development server (e.g. *XAMPP*) just put a forward slash.

### For example:
If you're not using a folder you don't need to include the directory, so you can just put a forward slash ( e.g. ```RewriteBase /``` ), otherwise, set *RewriteBase* to ``RewriteBase /YOUR_FOLDER/`` like the example below.


#### *Htaccess Template*
```SQL // Apparently there's no syntax highlighting for .htaccess files, so I put 'sql' for the language, so I can comment below
## If you extracted your installation to a folder that would be located here (C:\xampp\htdocs\YOUR_FOLDER)
RewriteEngine On
Options -Indexes
RewriteBase /YOUR_FOLDER/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```
Then, in your **routes.php** file (*application/config/routes.php*) set your *default controller*.

```PHP
// application/config/routes.php
$route['default_controller']   = 'Your_Controller/index'; // Alternatively, you can specify a module here as well
```
Next, in your **config.php** file (*application/config/config.php*) set your *base_url* to:
```PHP
$config['base_url']  = 'http://YOUR_DOMAIN/'; // (With folder) http://localhost/YOUR_FOLDER/
```
Finally, open up your browser (make sure your server software is running), and navigate to: *http:// YOUR_DOMAIN /* and you should be presented with your newly created module or controller.

## Features
- You can use default MVC or make use of the caked in Modules.
- You can call controllers from within other controllers.
- Model written in to the core; An idea inspired by David Connely, except with a twist. The user will still be able to create models that overwrite the core Model.

## Planned / Ideas
- Ajax CRUD Library Class
- Upload and Search Library Classes
- And more...?!

# Tutorials (Example Usage)
## Create a Page Controller
```php
<?php
// application\controllers\Pages.php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Pages extends KISS_Controller
{
  
  public function __construct()
  {
    parent::__construct();
  }

  public function index( $page = 'home' ) // Don't forget to create a view file called 'home'!
  { 
    $data['page_title'] = ucfirst($page);
    $this->load->view($page, $data);
  }

}
```

Then, in your **routes.php** file (*application/config/routes.php*) set to this:

```php
<?php
// application\config\routes.php
defined('BASEPATH') OR exit('Direct script access not allowed');

$route['default_controller']   = 'Pages/index';
$route['(:any)']               = 'Pages/index/$1';
```

## Loading Module Views
(NOTE: This may change in the future [i.e. you would load views the same way as default MVC]).

Kiss-HMVC loads module views slightly different to avoid conflicts. To load a module view you simply specify
the module the view is contained in followed by the view you're trying to load. For example:

```PHP
$this->load->view('MODULE_FOLDER/VIEW_FILE');
```

## Create a Blog Module
```PHP
<?php
// application\modules\Blog\controllers\Blog.php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Blog extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
    // Set local timezone
    date_default_timezone_set('America/Vancouver');

    /** 
     * This is just an example, you don't have to load the configuration like 
     *  I am here.
     * You can autoload the database in (application/config/autoload.php) 
     * - OR - 
     * call it here, for example: $this->load->library('database'); (minus the 
     * config settings) 
     * 
     */
     $this->load->library('database', array(
          'db_host' => 'localhost',
          'db_user' => 'root',
          'db_pass' => '',
          'db_name' => 'YOUR_DATABASE_NAME'
    ));
    // Load text helper so we can use word_limiter() for posts excerpts in blog feed
    $this->load->helper('text');
    $this->load->model('Blog/Blog_model');
    $this->model = $this->Blog_model;
    $this->load->library('Custom_Dates'); /* I created a custom library that
    converts timestamps to human readable dates (application/library/Custom_Dates.php) */
  }

  public function index()
  {
    $data['posts'] = $this->model->get_posts()->result_array();
    $data['site_title'] = 'Blog';
    $data['page_title'] = 'Blog';
    $data['body_class'] = 'blog-page';
    $this->load->view('Blog/header',$data);
    $this->load->view('Blog/posts',$data);
    $this->load->view('Blog/footer',$data);
  }

  public function post($slug = NULL)
  {
    $data['post'] = $this->model->get_post($slug);
    $data['site_title'] = $data['post']['post_title'];
    $data['page_title'] = $data['post']['post_title'];
    $data['body_class'] = 'post-page';
    $this->load->view('Blog/header',$data);
    $this->load->view('Blog/post',$data);
    $this->load->view('Blog/footer',$data);
  }

```

Then, in your **routes.php** file (*application/config/routes.php*) set to this:

```php
<?php
// application\config\routes.php
defined('BASEPATH') OR exit('Direct script access not allowed');

$route['blog']             = 'Blog/index';
$route['blog/post/(:any)'] = 'Blog/post/$1';
```

Next, create a model file called *Blog_model.php* including a corresponding table in your database called *'posts'* (example below).

Create a file called *'posts.sql'*
```sql
# Copy & paste these contents (minus these comments) in to the file you just created, save it, and import
# in to your database by selecting your database name in phpMyAdmin (http://localhost/phpmyadmin), click 
# 'import' tab, click 'choose file' button, browse for your sql file, 
# select it by left-clicking once, and click 'open' button below in dialog
# box. Once that windows closes out, scroll down to the bottom of the current
# screen and click 'Go' button to submit changes.

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_body` text NOT NULL,
  `post_date` int(11) NOT NULL,
  `post_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT; 
```

```php
<?php
// application\modules\Blog\models\Blog_model.php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Blog_model extends KISS_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'posts';
  } 

  public function get_posts() 
  {
    return $this->db->query("SELECT * FROM $this->table ORDER BY id DESC");
  }  

  public function get_post( $slug )
  {
    return $this->db->query("SELECT * FROM $this->table WHERE post_slug = '$slug' ORDER BY post_date DESC")->row_array();
  }
}
```

Lastly, create two files, one called *post.php* and the other called *posts.php* and put them in your views folder.

### post.php (Displays a single post)
```php
<?php 
  // application\modules\Blog\views\post.php
  defined('BASEPATH') OR exit('Direct script access not allowed'); 
?>

  <h2><?php echo $post['post_title']; ?></h2>
  <date>
    <?php echo $this->Custom_Dates->get_nice_date($post['post_date'],'full_date_time'); ?>
  </date>
  <p><?php echo $post['post_body']; ?></p>

```
### posts.php (Displays all posts)
```php
<?php 
  // application\modules\Blog\views\posts.php
  defined('BASEPATH') OR exit('Direct script access not allowed'); 
?>
<h1>Blog</h1>
<?php foreach( $posts as $post ) : ?>
  <h2><a href="<?php echo base_url("blog/post/$post[post_slug]"); ?>"><?php echo $post['post_title']; ?></a></h2>
  <date>
    <?php echo $this->Custom_Dates->get_nice_date($post['post_date'],'full_date_time'); ?>
  </date>
  <p><?php echo word_limiter($post['post_body'],25,' [...]'); ?></p>
  <hr />
<?php endforeach; ?>
```

## Create a Template Module
Create a folder called **Templates** in the *Modules* folder (*application/modules*), and include 3 folders in that called (*controllers*, *models*, *views*). Or, simply copy the *COPYTHIS* folder which I've included to make things easier. Create a file (example below) called **Templates.php** in the *controllers* folder. Then, put your *header.php* and *footer.php* files in the *views* folder.

Create a folder called **Dashboard** in the *Modules* folder, and include 3 folders in that called (*controllers*, *models*, *views*). Or, just like above, simply copy the *COPYTHIS* folder. Create a file (example below) called **Dashboard.php** in the *controllers* folder and finally create another file in your *Views* folder called *dashboard.php*.

### Templates.php
```php
<?php
// application\modules\Templates\controllers\Templates.php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Templates extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(){}
  
  public function dashboard($data)
  {
    $this->load->view('Templates/header',$data);
    $this->load->view($data['view_module'].'/'$data['view_file'],$data);
    $this->load->view('Templates/header',$data);
  }

}
```
### header.php
```php
<?php
// application\modules\Templates\views\header.php
defined('BASEPATH') OR exit('Direct script access not allowed');
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <title><?php echo $site_title; ?></title>
  </head>
  <body class="<?php echo $body_class; ?>">
```
### footer.php
```php
<?php
// application\modules\Templates\views\footer.php
defined('BASEPATH') OR exit('Direct script access not allowed');
?>

    <footer>&copy; Copyright <?php echo date('Y'); ?></footer>
  </body>
</html>
```
### Dashboard.php
```php
<?php
// application\modules\Dashboard\controllers\Dashboard.php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Dashboard extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function index()
  {
    $data['site_title']  = 'Dashboard';
    $data['page_title']  = 'Dashboard';
    $data['body_class']  = 'dashboard-page';
    $data['view_file']   = 'dashboard';
    $data['view_module'] = 'Dashboard';
    $this->load->module('Templates/dashboard',$data);
  }

}
 ```     
### dashboard.php
```php
<?php
// application\modules\Dashboard\views\dashboard.php
defined('BASEPATH') OR exit('Direct script access not allowed');
?>
<h2><?php echo $page_title; ?></h2>
```
## Result
```HTML
<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>Dashboard</title>
  </head>
  <body class="dashboard-page">

    <h2>Dashboard</h2>

    <footer>© Copyright 2020</footer>
  </body>
</html>
```
## Changelog
You can view the *CHANGELOG* file for information.

## Contribute
You can view the *CONTRIBUTE* file for information.

## License
*KissHMVC* is licensed under an MIT License. You can view the *LICENSE* file for information.

## Credits
Inspired by CodeIgniter (<https://codeigniter.com>), David Connelly (<https://trongate.io/>), Jesse Boyer (<http://jream.com>), and John White (<https://github.com/Jontyy>). Also, StackOverflow, YouTube, and Other Online Resources.

## Contact
Feel free to get in touch with me via my website: <https://mywebfolio.me> and my email: <philosaphylas@gmail.com>!
