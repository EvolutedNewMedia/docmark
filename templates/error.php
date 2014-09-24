<?php echo $helper->includeTemplate('header.php'); ?>

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
                    <?php echo $helper->includeTemplate('menu.php'); ?>

                    <div class="well well-sidebar">

                        <div class="copyright">
                            Copyright &copy; Turn 24 Ltd <?php echo date('Y'); ?>.
                        </div>

                        <div class="poweredby">
                        Built with DocMark
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-column content-area col-sm-9">
                <div class="content-page">

                    <?php echo $helper->includeTemplate('breadcrumb.php'); ?>

                    <article>
                        <div class="page-header">
                            <h1>Page not found!</h1>
                        </div>

                        <p>Looks like we couldn't find the page you were looking for!</p>

                        <p>Please use the menu to the left to find the page you need.</p>

                    </article>
                </div>
            </div>
        </div>
    </div>

<?php echo $helper->includeTemplate('footer.php'); ?>