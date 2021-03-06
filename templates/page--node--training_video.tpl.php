<?php
/**
 * @file
 * Adaptivetheme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * Adaptivetheme supplied variables:
 * - $site_logo: Themed logo - linked to front with alt attribute.
 * - $site_name: Site name linked to the homepage.
 * - $site_name_unlinked: Site name without any link.
 * - $hide_site_name: Toggles the visibility of the site name.
 * - $visibility: Holds the class .element-invisible or is empty.
 * - $primary_navigation: Themed Main menu.
 * - $secondary_navigation: Themed Secondary/user menu.
 * - $primary_local_tasks: Split local tasks - primary.
 * - $secondary_local_tasks: Split local tasks - secondary.
 * - $tag: Prints the wrapper element for the main content.
 * - $is_mobile: Bool, requires the Browscap module to return TRUE for mobile
 *   devices. Use to test for a mobile context.
 * - *_attributes: attributes for various site elements, usually holds id, class
 *   or role attributes.
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Core Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * Adaptivetheme Regions:
 * - $page['leaderboard']: full width at the very top of the page
 * - $page['menu_bar']: menu blocks placed here will be styled horizontal
 * - $page['secondary_content']: full width just above the main columns
 * - $page['content_aside']: like a main content bottom region
 * - $page['tertiary_content']: full width just above the footer
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see adaptivetheme_preprocess_page()
 * @see adaptivetheme_process_page()
 */
?>

<!-- Include styles for media player -->
      <link type="text/css" href="../core/css/player-core.css" rel="stylesheet" >
      <link type="text/css" href="../custom/css/player-theme.css" rel="stylesheet" >
  
    <!-- Include googles JSAPI and load jQuery from there -->
      <script type="text/javascript" src="http://www.google.com/jsapi"></script>
      <script type="text/javascript">
          google.load("jquery", "1.6.0");
          google.load("jqueryui", "1.8.13");
      </script>
      
      <!-- Include swfobject for embedding flash in the page -->
      <script type="text/javascript" src="../core/javascript/swfobject/swfobject.js"></script>
      <!-- Include the config file for the vimeo media player -->
      <script type="text/javascript" src="../custom/javascript/config/vimeo/vimeo.config.js"></script>
            <!-- Include the accessible media player script -->
            <script type="text/javascript" src="../core/javascript/mediaplayer_decorator.js"></script>
            <script type="text/javascript" src="../core/javascript/youtube_player.js"></script>
            <script type="text/javascript" src="../core/javascript/jquery.player.js"></script>
      <!-- Custom script for generating the vimeo player using the vimeo config -->
      <script type="text/javascript">
      $(document).ready(function(){
        // Find all of the links to videos on the vimeo site
        var $vimeo_links = $("a[href*='http://vimeo.com/']");
        // Iterate through the links to vimeo 
        // instantiating a player instance for each
        $.each($vimeo_links, function(i) {
          var $holder = $('<span />');
            $(this).parent().replaceWith($holder);
            // Find the captions file if it exists
            var $mycaptions = $(this).siblings('.captions');
            // Work out if we have captions or not
            var captionsf = $($mycaptions).length > 0 ? $($mycaptions).attr('href') : null;
            // Ensure that we extract the last part of the vimeo link (the video id)
            // and pass it to the player() method
            var link = $(this).attr('href').split("/")[3];
            // Initialise the player
            $holder.player({
                id:'vimeo'+i,
                url: 'http://vimeo.com/moogaloop.swf?clip_id=',
                media:link,
          captions:captionsf
            }, vimeoconfig);
        });
    });
      </script>

      
<div id="page" class="container <?php print $classes; ?>">

  <!-- region: Leaderboard -->
  <?php print render($page['leaderboard']); ?>

  <header<?php print $header_attributes; ?>>
  <div class="background"></div>
    <div class="inner">

    <?php if ($site_logo || $site_name || $site_slogan): ?>
      <!-- start: Branding -->
      <div<?php print $branding_attributes; ?>>

        <?php if ($site_logo): ?>
          <div id="logo">
            <?php print $site_logo; ?>
          </div>
        <?php endif; ?>

        <?php if ($site_name || $site_slogan): ?>
          <!-- start: Site name and Slogan hgroup -->
          <hgroup<?php print $hgroup_attributes; ?>>

            <?php if ($site_name): ?>
              <h1<?php print $site_name_attributes; ?>><?php print $site_name; ?></h1>
            <?php endif; ?>

            <?php if ($site_slogan): ?>
              <h2<?php print $site_slogan_attributes; ?>><?php print $site_slogan; ?></h2>
            <?php endif; ?>

          </hgroup><!-- /end #name-and-slogan -->
        <?php endif; ?>

      </div></a><!-- /end #branding -->
    <?php endif; ?>

    <!-- region: Header -->
    <?php print render($page['header']); ?>
    </div>

  </header>

  <!-- Navigation elements -->
  <?php print render($page['menu_bar']); ?>
  <?php if ($primary_navigation): print $primary_navigation; endif; ?>
  <?php if ($secondary_navigation): print $secondary_navigation; endif; ?>

  <!-- Breadcrumbs -->
  <?php if ($breadcrumb): print $breadcrumb; endif; ?>

  

  <!-- region: Secondary Content -->
  <?php print render($page['secondary_content']); ?>

  <div id="columns" class="columns clearfix">
    <div id="content-column" class="content-column" role="main">
      <div class="content-inner">

        <!-- region: Highlighted -->
        <!-- Messages and Help -->
        <?php print $messages; ?>
        <?php print render($page['help']); ?>
        <?php print render($page['highlighted']); ?>

        <<?php print $tag; ?> id="main-content"><div class="inner">

          <?php print render($title_prefix); // Does nothing by default in D7 core ?>

          <?php if ($title || $primary_local_tasks || $secondary_local_tasks || $action_links = render($action_links)): ?>
            <header<?php print $content_header_attributes; ?>>
            <p>Training video <img class="icon" src="/sites/all/themes/ftw/icons/training.png" alt=""></p>

              <?php if ($title): ?>
                <h1 id="page-title">
                  
                  <?php print $title; ?>

                </h1>
              <?php endif; ?>

              <?php if ($primary_local_tasks || $secondary_local_tasks || $action_links): ?>
                <div id="tasks">

                  <?php if ($primary_local_tasks): ?>
                    <ul class="tabs primary clearfix"><?php print render($primary_local_tasks); ?></ul>
                  <?php endif; ?>

                  <?php if ($secondary_local_tasks): ?>
                    <ul class="tabs secondary clearfix"><?php print render($secondary_local_tasks); ?></ul>
                  <?php endif; ?>

                  <?php if ($action_links = render($action_links)): ?>
                    <ul class="action-links clearfix"><?php print $action_links; ?></ul>
                  <?php endif; ?>

                </div>
              <?php endif; ?>

            </header>
          <?php endif; ?>

          <!-- region: Intro Content -->
          <?php if ($content = render($page['intro_content'])): ?>
            <div id="intro_content" class="region">
              <?php print $content; ?>
            </div>
          <?php endif; ?>

          <!-- region: Main Content -->
          <?php if ($content = render($page['content'])): ?>
            <div id="content" class="region">
              <?php print $content; ?>
            </div>
          <?php endif; ?>

          <!-- region: Help Content -->
          <?php if ($content = render($page['help_content'])): ?>
            <div id="help_content" class="region">
              <?php print $content; ?>
            </div>
          <?php endif; ?></div>

          <!-- Feed icons (RSS, Atom icons etc -->
          <?php print $feed_icons; ?>

          <?php print render($title_suffix); // Prints page level contextual links ?>

        </<?php print $tag; ?>><!-- /end #main-content -->

        <!-- region: Content Aside -->
        <?php print render($page['content_aside']); ?>

      </div><!-- /end .content-inner -->
    </div><!-- /end #content-column -->

    <!-- regions: Sidebar first and Sidebar second -->
    <?php $sidebar_first = render($page['sidebar_first']); print $sidebar_first; ?>
    <?php $sidebar_second = render($page['sidebar_second']); print $sidebar_second; ?>

  </div><!-- /end #columns -->

  <!-- region: Tertiary Content -->
  <?php print render($page['tertiary_content']); ?>

  <!-- region: Footer -->
  <?php if ($page['footer']): ?>
    <footer<?php print $footer_attributes; ?>>
      <?php print render($page['footer']); ?>
    </footer>
  <?php endif; ?>

</div>
