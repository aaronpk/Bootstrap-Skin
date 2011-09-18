<?php
/**
 * Bootstrap - A basic MediaWiki skin based on Twitter's excellent Bootstrap CSS framework
 *
 * @Version 1.0.0
 * @Author Aaron Parecki <aaron@parecki.com>
 * @Copyright Aaron Parecki 2011 - http://aaronparecki.com/
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

require_once('includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinBootstrap extends SkinTemplate {
    /** Using Bootstrap */
    function initPage( &$out ) {
        SkinTemplate::initPage( $out );
        $this->skinname  = 'bootstrap';
        $this->stylename = 'bootstrap';
        $this->template  = 'BootstrapTemplate';
    }
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class BootstrapTemplate extends QuickTemplate {
    /**
     * Template filter callback for Bootstrap skin.
     * Takes an associative array of data set from a SkinTemplate-based
     * class, and a wrapper for MediaWiki's localization database, and
     * outputs a formatted page.
     *
     * @access private
     */
    function execute() {
?><!DOCTYPE html>
<html xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<head>
    <meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
    <title><?php $this->text('pagetitle') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/site.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/js/bootstrap-tabs.js"></script>
    <?php $this->html('headlinks') ?>
</head>
<body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Project name</a>

          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <p class="pull-right">Logged in as <a href="#">username</a></p>

        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="sidebar">
        <div class="well">
          <h5>Sidebar</h5>
          <ul>

            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
          </ul>
          <h5>Sidebar</h5>

          <ul>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>

            <li><a href="#">Link</a></li>
          </ul>
          <h5>Sidebar</h5>
          <ul>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
          </ul>

        </div>
      </div>
      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h1>Hello, world!</h1>
          <p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
          <p><a class="btn primary large">Learn more &raquo;</a></p>

        </div>

        <!-- Example row of columns -->
        <div class="row">
          <div class="span6">
            <h2>Heading</h2>
            <p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>

          </div>
          <div class="span5">
            <h2>Heading</h2>
             <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
         </div>
          <div class="span5">

            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
        </div>

        <hr>

        <!-- Example row of columns -->
        <div class="row">
          <div class="span6">
            <h2>Heading</h2>
            <p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>

          <div class="span5">
            <h2>Heading</h2>
             <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
         </div>
          <div class="span5">
            <h2>Heading</h2>

            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
          </div>
        </div>

        <footer>
          <p>&copy; Company 2011</p>

        </footer>
      </div>
    </div>    

</body>
</html>
<?php
	}
}

