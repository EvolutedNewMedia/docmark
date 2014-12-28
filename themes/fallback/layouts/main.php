<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>          <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>          <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <title><?=$this->e($pageTitle . ' :: ' . $site['title'])?></title>
        <meta name="description" content="<?=$this->e($pageTitle . ' :: ' . $site['title'])?>" />
        <meta name="author" content="WHSuite">
        <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
        <!-- Mobile -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Font -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

        <!-- CSS -->
        <link href='/assets/css/style.css' rel='stylesheet' type='text/css'>

    </head>
    <body>

        <?=$this->section('content')?>

        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>
            if (typeof jQuery == 'undefined')
                document.write(unescape("%3Cscript src='/assets/js/jquery-1.11.0.min.js' type='text/javascript'%3E%3C/script%3E"));
        </script>

        <!-- hightlight.js -->
        <script src="/assets/js/highlight.min.js"></script>
        <script>hljs.initHighlightingOnLoad();</script>

        <!-- Front end file editor -->
        <script src="/assets/js/custom.js"></script>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </body>
</html>
