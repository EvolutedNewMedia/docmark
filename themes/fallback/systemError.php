<?php
    $this->layout(
        $theme . '::layouts/main'
    );
?>

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
                <?php
                    $this->insert(
                        $theme . '::elements/menu'
                    );
                ?>

                <div class="well well-sidebar">

                    <div class="copyright">
                        Copyright &copy; Turn 24 Ltd <?=date('Y')?>.
                    </div>

                    <div class="poweredby">
                    Built with DocMark
                    </div>
                </div>
            </div>
        </div>
        <div class="right-column content-area col-sm-9">
            <div class="content-page">

                <?php
                    $this->insert(
                        $theme . '::elements/breadcrumb'
                    );
                ?>

                <article>
                    <div class="page-header">
                        <h1>Page not found!</h1>
                    </div>

                    <p>Looks like something went very, very wrong!</p>

                    <p>We can't seem to find the page you are looking for, please try using the menu to the left or contacting the site admin</p>

                </article>
            </div>
        </div>
    </div>
</div>
