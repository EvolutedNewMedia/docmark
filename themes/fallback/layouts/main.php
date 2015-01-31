<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>          <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>          <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <title><?=$this->e($pageTitle . ' :: ' . $site['title'])?></title>
        <meta name="description" content="<?=$this->e($pageTitle . ' :: ' . $site['title'])?>" />
        <meta name="author" content="<?=$site['title']?>">
        <link rel="icon" href="<?=$this->asset('/assets/img/favicon.ico')?>" type="image/x-icon">
        <!-- Mobile -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Font -->
        <link href="//fonts.googleapis.com/css?family=Roboto:400,100,300,700" rel="stylesheet" type="text/css">

        <!-- CSS -->
        <link href="<?=$this->asset('/assets/css/style.css')?>" rel="stylesheet" type="text/css">

    </head>
    <body>

        <div class="container-fluid fluid-height wrapper">
            <div class="navbar navbar-fixed-top hidden-print">
                <div class="container-fluid">
                    <a class="brand navbar-brand pull-left" href="/">
                        <?=$this->e($site['title'])?>
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

                        <?=$this->section('content')?>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>
            if (typeof jQuery == 'undefined')
                document.write(unescape("%3Cscript src='<?=$this->asset('/assets/js/jquery-1.11.0.min.js')?>' type='text/javascript'%3E%3C/script%3E"));
        </script>

        <!-- hightlight.js -->
        <script src="<?=$this->asset('/assets/js/highlight.min.js')?>"></script>
        <script>hljs.initHighlightingOnLoad();</script>

        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </body>
</html>