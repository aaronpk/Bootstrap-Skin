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
		global $wgUser, $wgSitename, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;

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
  	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/site.js"></script>
    <?php if(isset($wgSiteCSS)) { ?>
    	<link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/<?php echo $wgSiteCSS ?>" />
    <?php } ?>
    <?php $this->html('headlinks') ?>
    <?php 
    
    if(isset($wgGoogleAnalyticsID)) { ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $wgGoogleAnalyticsID; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
      <?php
    }
    ?>
</head>
<body class="<?php echo Sanitizer::escapeClass('page-' . $this->data['title'])?>">

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>"><?php echo $wgSitename ?></a>

          <ul class="nav">
            <?php
              $titleBar = $this->getPageRawText('Bootstrap:TitleBar');
              $nav = array();
              foreach(explode("\n", $titleBar) as $line) {
                if(trim($line) == '') continue;
                
                if(preg_match('/^\*\s*\[\[(.+)\]\]/', $line, $match)) {
                  $nav[] = array('title'=>$match[1], 'link'=>$match[1]);
                }elseif(preg_match('/\*\*\s*\[\[(.+)\]\]/', $line, $match)) {
                  $nav[count($nav)-1]['sublinks'][] = $match[1];
                }elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
                  $nav[] = array('title'=>$match[1]);
                }
              }
              
              foreach($nav as $topItem) {
                $pageTitle = Title::newFromText($topItem['title']);
                if(array_key_exists('sublinks', $topItem)) {
                  echo '<li class="dropdown" data-dropdown="dropdown">';
                    echo '<a href="#" class="dropdown-toggle">' . $topItem['title'] . '</a>';
                    echo '<ul class="dropdown-menu">';
                    foreach($topItem['sublinks'] as $subLink) {
                      $pageTitle = Title::newFromText($subLink);
                      echo '<li><a href="' . $pageTitle->getLocalURL() . '">' . $subLink . '</a>';
                    }
                    echo '</ul>';
                  echo '</li>';
                } else {
                  echo '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</a></li>';
                }
              }
            ?>
          </ul>
          
			<?php

 			if($wgUser->isLoggedIn()) {
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
      } else {  // else if is logged in
        ?>
          <ul class="secondary-nav">
            <li><a href="/wiki/index.php?title=Special:UserLogin">Log In</a></li>
          </ul>
        <?php
      }
      ?>
          <form class="pull-right" action="/Special:Search" id="search-form">
          	<input type="text" placeholder="Search" name="search" onchange="$('#search-form').submit()" />
          </form>
          
        </div>
      </div>
    </div><!-- topbar -->

  

    <div class="container">

      <img src="http://localhost/aaronpk-banner.png" width="940" height="110" />

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

    </div><!-- container -->



    <div class="bottom">
      <div class="container">
        <?php
        $this->includePage('Bootstrap:Footer');
        ?>
      
        <footer>
          <p>&copy; <?php echo date('Y'); ?> by <a href="<?php echo (isset($wgCopyrightLink) ? $wgCopyrightLink : 'http://aaronparecki.com'); ?>"><?php echo (isset($wgCopyright) ? $wgCopyright : 'Aaron Parecki'); ?></a> 
          	&bull; Powered by <a href="http://mediawiki.org">MediaWiki</a> 
          	&bull; <a href="http://aaronparecki.com/MediaWiki_Bootstrap_Skin">Bootstrap Skin</a> by <a href="http://aaronparecki.com">Aaron Parecki</a>
          </p>
        </footer>
      </div><!-- container -->
    </div><!-- bottom -->

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
	
	function getPageRawText($title) {
    $pageTitle = Title::newFromText($title);
    if(!$pageTitle->exists()) {
      return 'Create the page [[Bootstrap:TitleBar]]';
    } else {
      $article = new Article($pageTitle);
      return $article->getRawText();
    }
	}
	
	function includePage($title) {
    global $wgParser, $wgUser;
    $pageTitle = Title::newFromText($title);
    if(!$pageTitle->exists()) {
      echo 'The page [[' . $title . ']] was not found.';
    } else {
      $article = new Article($pageTitle);
      $wgParserOptions = new ParserOptions($wgUser);
      $parserOutput = $wgParser->parse($article->getRawText(), $pageTitle, $wgParserOptions);
      echo $parserOutput->getText();
    }
	}
}

