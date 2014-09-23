<?php echo $helper->includeTemplate('header.php', array('siteTitle' => $site['title'], 'pageTitle' => $pageTitle)); ?>

    <?php /*if ($params['repo']) { ?>
        <a href="https://github.com/<?php echo $params['repo']; ?>" target="_blank" id="github-ribbon" class="hidden-print"><img src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
    <?php }*/ ?>
    <div class="container-fluid fluid-height wrapper">
        <div class="navbar navbar-fixed-top hidden-print">
            <div class="container-fluid">
                <a class="brand navbar-brand pull-left" href="/">
                    <?php echo $site['title']; ?>
                </a>
            </div>
        </div>
        <div class="row columns content">
            <div class="left-column article-tree col-sm-3 hidden-print">
                <!-- For Mobile -->
                <div class="responsive-collapse">
                    <button type="button" class="btn btn-sidebar" id="menu-spinner-button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="sub-nav-collapse" class="sub-nav-collapse">
                    <!-- Navigation -->
                    <?php echo $helper->includeTemplate('menu.php', array('menu' => $menu, 'helper' => $helper)); ?>

                    <?php //if (!empty($params['links']) || !empty($params['twitter'])) { ?>
                        <div class="well well-sidebar">

                            <!-- Links -->
                            <?php /* foreach ($params['links'] as $name => $url) echo '<a href="' . $url . '" target="_blank">' . $name . '</a><br>'; ?>
                            <?php if ($params['toggle_code']) echo '<a href="#" id="toggleCodeBlockBtn" onclick="toggleCodeBlocks();">Show Code Blocks Inline</a><br>'; ?>

                            <!-- Twitter -->
                            <?php foreach ($params['twitter'] as $handle) { ?>
                                <div class="twitter">
                                    <hr/>
                                    <iframe allowtransparency="true" frameborder="0" scrolling="no" style="width:115px; height:20px;" src="https://platform.twitter.com/widgets/follow_button.html?screen_name=<?php echo $handle;?>&amp;show_count=false"></iframe>
                                </div>
                            <?php } */ ?>

                                <div class="copyright">
                                    Copyright &copy; Turn 24 Ltd <?php echo date('Y'); ?>.
                                </div>

                                <div class="poweredby">
                                Built with DocMark
                                </div>
                        </div>
                    <?php //} ?>
                </div>
            </div>
            <div class="right-column content-area col-sm-9">
                <div class="content-page">

                    <?php echo $helper->includeTemplate('breadcrumb.php', array('breadcrumb' => $breadcrumb)); ?>

                    <article>
                        <div class="page-header">
                            <h1><?php echo $pageTitle; ?></h1>
                        </div>

                        <?php echo $page; ?>

                    </article>
                </div>
            </div>
        </div>
    </div>

<?php echo $helper->includeTemplate('footer.php'); ?>