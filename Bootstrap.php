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
	 * @var Cached skin object
	 */
	var $skin;

    /**
     * Template filter callback for Bootstrap skin.
     * Takes an associative array of data set from a SkinTemplate-based
     * class, and a wrapper for MediaWiki's localization database, and
     * outputs a formatted page.
     *
     * @access private
     */
    function execute() {
		global $wgUser, $wgSitename, $wgCopyrightLink, $wgCopyright;
		
		$this->skin = $this->data['skin'];

        // Suppress warnings to prevent notices about missing indexes in $this->data
        wfSuppressWarnings();
?><!DOCTYPE html>
<html xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<head>
    <meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
    <title><?php $this->text('pagetitle') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/site.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/js/bootstrap-tabs.js"></script>
	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/js/bootstrap-dropdown.js"></script>
    <?php $this->html('headlinks') ?>
</head>
<body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#"><?php echo $wgSitename ?></a>

          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          
			<?php
			if ( count( $this->data['personal_urls'] ) > 0 ) {
			?>
				<ul<?php $this->html('userlangattributes') ?> class="nav secondary-nav">
					<li class="dropdown" data-dropdown="dropdown">
						<a class="dropdown-toggle" href="#"><?php echo $wgUser->getName(); ?></a>
						<ul class="dropdown-menu">
							<?php foreach($this->data['personal_urls'] as $item): ?>
								<li <?php echo $item['attributes'] ?>><a href="<?php echo htmlspecialchars($item['href']) ?>"<?php echo $item['key'] ?><?php if(!empty($item['class'])): ?> class="<?php echo htmlspecialchars($item['class']) ?>"<?php endif; ?>><?php echo htmlspecialchars($item['text']) ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>
			<?php
			}
			?>
	
			<?php
			if ( count( $this->data['content_actions']) > 0 ) {
			?>
	        <ul class="nav secondary-nav">
	        	<li class="dropdown" data-dropdown="dropdown">
	        		<a class="dropdown-toggle" href="#">Page</a>
	        		<ul class="dropdown-menu">
			            <?php $lastkey = end(array_keys($this->data['content_actions'])) ?>
			            <?php foreach($this->data['content_actions'] as $key => $action) { ?>
			               <li id="ca-<?php echo Sanitizer::escapeId($key) ?>" <?php
			                   if($action['class']) { ?>class="<?php echo htmlspecialchars($action['class']) ?>"<?php } ?>
			               ><a href="<?php echo htmlspecialchars($action['href']) ?>"><?php
			                   echo htmlspecialchars($action['text']) ?></a> <?php
			                   if($key != $lastkey) //echo "&#8226;" ?></li>
			            <?php } ?>
	        		</ul>
	        	</li>
	        </ul>
	        <?php
	        }
	        ?>

          <form class="pull-right" action="/Special:Search" id="search-form">
          	<input type="text" placeholder="Search" name="search" onchange="$('#search-form').submit()" />
          </form>
          
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="sidebar" style="position: absolute;">
        <div class="well">

<?php foreach( $this->data['sidebar'] as $bar => $cont ) { if(count($cont) == 0) continue; ?>
        <div class='portlet' id='p-<?php echo Sanitizer::escapeId( $bar ) ?>'<?php echo $this->skin->tooltip('p-'.$bar) ?>>
                <h5><?php $out = wfMsg( $bar ); if( wfEmptyMsg( $bar, $out ) ) echo $bar; else echo $out; ?></h5>
                <div class='pBody'>
                        <ul>
<?php                       foreach( $cont as $key => $val ) { ?>
                                <li id="<?php echo Sanitizer::escapeId( $val['id'] ) ?>"<?php
                                        if( $val['active'] ) { ?> class="active" <?php }
                                ?>><a href="<?php echo htmlspecialchars( $val['href'] ) ?>"<?php echo $this->skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars( $val['text'] ) ?></a></li>
<?php                       } ?>
                        </ul>
                </div>
        </div>
        <?php } ?>
        		        
<!--
          <h5>Sidebar</h5>
          <ul>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
          </ul>
-->

        </div>
      </div>
      <div class="content">

		<?php if( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="alert-message warning"><?php $this->html('sitenotice') ?></div><?php } ?>


        <div class="page-header">
          <h1><?php $this->html( 'title' ) ?> <small><?php $this->html('subtitle') ?></small></h1>
        </div>	

        <!-- Main hero unit for a primary marketing message or call to action -->
<!--
        <div class="hero-unit">
          <h1>Hello, world!</h1>
          <p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
          <p><a class="btn primary large">Learn more &raquo;</a></p>
        </div>
-->

		<?php $this->html( 'bodytext' ) ?>

        <!-- Example row of columns -->
        <!--
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
		-->
<!--         <hr> -->


        <!-- Example row of columns -->
<!--
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
-->

        <footer>
          <p>&copy; <?php echo date('Y'); ?> by <a href="<?php echo (isset($wgCopyrightLink) ? $wgCopyrightLink : 'http://aaronparecki.com'); ?>"><?php echo (isset($wgCopyright) ? $wgCopyright : 'Aaron Parecki'); ?></a> 
          	&bull; Powered by <a href="http://mediawiki.org">MediaWiki</a> 
          	&bull; <a href="http://twitter.github.com/bootstrap">Bootstrap Skin</a> by <a href="http://aaronparecki.com">Aaron Parecki</a>
          </p>
        </footer>
      </div>
    </div>    

</body>
</html>
<?php
	}
	

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function renderNavigation( $elements ) {
		global $wgVectorUseSimpleSearch, $wgVectorShowVariantName, $wgUser;

		// If only one element was given, wrap it in an array, allowing more
		// flexible arguments
		if ( !is_array( $elements ) ) {
			$elements = array( $elements );
		// If there's a series of elements, reverse them when in RTL mode
		} else if ( wfUILang()->isRTL() ) {
			$elements = array_reverse( $elements );
		}
		// Render elements
		foreach ( $elements as $name => $element ) {
			echo "\n<!-- {$name} -->\n";
			switch ( $element ) {
				case 'NAMESPACES':
?>
<div id="p-namespaces" class="vectorTabs<?php if ( count( $this->data['namespace_urls'] ) == 0 ) echo ' emptyPortlet'; ?>">
	<h5><?php $this->msg('namespaces') ?></h5>
	<ul<?php $this->html('userlangattributes') ?>>
		<?php foreach ($this->data['namespace_urls'] as $link ): ?>
			<li <?php echo $link['attributes'] ?>><span><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></a></span></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'VARIANTS':
?>
<div id="p-variants" class="vectorMenu<?php if ( count( $this->data['variant_urls'] ) == 0 ) echo ' emptyPortlet'; ?>">
	<?php if ( $wgVectorShowVariantName ): ?>
		<h4>
		<?php foreach ( $this->data['variant_urls'] as $link ): ?>
			<?php if ( stripos( $link['attributes'], 'selected' ) !== false ): ?>
				<?php echo htmlspecialchars( $link['text'] ) ?>
			<?php endif; ?>
		<?php endforeach; ?>
		</h4>
	<?php endif; ?>
	<h5><span><?php $this->msg('variants') ?></span><a href="#"></a></h5>
	<div class="menu">
		<ul<?php $this->html('userlangattributes') ?>>
			<?php foreach ( $this->data['variant_urls'] as $link ): ?>
				<li<?php echo $link['attributes'] ?>><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
				break;
				case 'VIEWS':
?>
<div id="p-views" class="vectorTabs<?php if ( count( $this->data['view_urls'] ) == 0 ) echo ' emptyPortlet'; ?>">
	<h5><?php $this->msg('views') ?></h5>
	<ul<?php $this->html('userlangattributes') ?>>
		<?php foreach ( $this->data['view_urls'] as $link ): ?>
			<li<?php echo $link['attributes'] ?>><span><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo (array_key_exists('img',$link) ?  '<img src="'.$link['img'].'" alt="'.$link['text'].'" />' : htmlspecialchars( $link['text'] ) ) ?></a></span></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'ACTIONS':
?>
<div id="p-cactions" class="vectorMenu<?php if ( count( $this->data['action_urls'] ) == 0 ) echo ' emptyPortlet'; ?>">
	<h5><span><?php $this->msg('actions') ?></span><a href="#"></a></h5>
	<div class="menu">
		<ul<?php $this->html('userlangattributes') ?>>
			<?php foreach ($this->data['action_urls'] as $link ): ?>
				<li<?php echo $link['attributes'] ?>><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
				break;
				case 'PERSONAL':
?>
<div id="p-personal" class="<?php if ( count( $this->data['personal_urls'] ) == 0 ) echo ' emptyPortlet'; ?>">
	<h5><?php $this->msg('personaltools') ?></h5>
	<ul<?php $this->html('userlangattributes') ?>>
		<?php foreach($this->data['personal_urls'] as $item): ?>
			<li <?php echo $item['attributes'] ?>><a href="<?php echo htmlspecialchars($item['href']) ?>"<?php echo $item['key'] ?><?php if(!empty($item['class'])): ?> class="<?php echo htmlspecialchars($item['class']) ?>"<?php endif; ?>><?php echo htmlspecialchars($item['text']) ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'SEARCH':
?>
<div id="p-search">
	<h5<?php $this->html('userlangattributes') ?>><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h5>
	<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
		<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
		<?php if ( $wgVectorUseSimpleSearch && $wgUser->getOption( 'vector-simplesearch' ) ): ?>
		<div id="simpleSearch">
			<?php if ( $this->data['rtl'] ): ?>
			<button id="searchButton" type='submit' name='button' <?php echo $this->skin->tooltipAndAccesskey( 'search-fulltext' ); ?>><img src="<?php echo $this->skin->getSkinStylePath('images/search-rtl.png'); ?>" alt="<?php $this->msg( 'searchbutton' ) ?>" /></button>
			<?php endif; ?>
			<input id="searchInput" name="search" type="text" <?php echo $this->skin->tooltipAndAccesskey( 'search' ); ?> <?php if( isset( $this->data['search'] ) ): ?> value="<?php $this->text( 'search' ) ?>"<?php endif; ?> />
			<?php if ( !$this->data['rtl'] ): ?>
			<button id="searchButton" type='submit' name='button' <?php echo $this->skin->tooltipAndAccesskey( 'search-fulltext' ); ?>><img src="<?php echo $this->skin->getSkinStylePath('images/search-ltr.png'); ?>" alt="<?php $this->msg( 'searchbutton' ) ?>" /></button>
			<?php endif; ?>
		</div>
		<?php else: ?>
		<input id="searchInput" name="search" type="text" <?php echo $this->skin->tooltipAndAccesskey( 'search' ); ?> <?php if( isset( $this->data['search'] ) ): ?> value="<?php $this->text( 'search' ) ?>"<?php endif; ?> />
		<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="<?php $this->msg( 'searcharticle' ) ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-go' ); ?> />
		<input type="submit" name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg( 'searchbutton' ) ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-fulltext' ); ?> />
		<?php endif; ?>
	</form>
</div>
<?php

				break;
			}
			echo "\n<!-- /{$name} -->\n";
		}
	}	
}

