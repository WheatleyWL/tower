<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>tower</title>

    <!-- Bootstrap core CSS -->
    <link href="/admin_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin_assets/css/flatpickr.min.css" rel="stylesheet">
    <link href="/admin_assets/css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/admin_assets/css/dashboard.css" rel="stylesheet">
    <link href="/admin_assets/libs/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="container text-center pt-5 pb-5">
        <h1>Welcome to Tower!</h1>
        <span>Minimalistic and highly customizable Laravel admin panel.</span>
    </div>

    <h5>Why am I seeing this?</h5>
    <p>This is the default Tower home page. It is displayed when you first install the package and open /admin
    in browser! While this does display that package is working there's still some configuration to be done.</p>

    <h5>What's next?</h5>
    <p>First, you should define a <b>Project Template</b>. Templates are Tower's way of defining overal layout
        of the admin panel as well as defining menus and other content. For more info on Templates consult the
        documentation.
        <br><br>A simplest template would look like this:</p>
    <pre class="pre-scrollable"><code>&lt;?php
namespace App\Admin\Templates;

use zedsh\tower\Menu\BaseMenu;
use zedsh\tower\Templates\BaseTemplate;

class ProjectTemplate extends BaseTemplate
{
    public function getMenu()
    {
        return new BaseMenu([]);
    }
}
</code></pre>
    <p>This will define a new template, with an empty menu.</p>
    <p>Next we need to tell Tower that we have our own template to work with so it can display a proper home page
    instead of the one you are currently looking through.</p>
    <p>To do so, go to your project's <mark>AppServiceProvider</mark>, locate <mark>boot</mark> method and provide
    Tower with your newly created ProjectTemplate using <mark>TowerAdmin</mark> facade:</p>
    <pre class="pre-scrollable"><code>/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    TowerAdmin::setProjectTemplateClass(App\Admin\Templates\ProjectTemplate::class);
}</code></pre>
    <p>And that's it! After doing this and refreshing the page you should see a proper Tower home page.
    <br>You are now ready to build an awesome admin panel.</p>

    <h5>Useful links</h5>
    <p>
        <a href="https://github.com/zedsh/tower">Tower GitHub repository</a>
        <br><a href="https://github.com/zedsh/tower/issues">Issues</a>
        <br><a href="https://github.com/zedsh/tower">Documentation</a>
    </p>
</div>
</body>
</html>
