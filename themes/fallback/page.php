<?php
    $this->layout(
        $theme . '::layouts/main'
    );
?>

<article>
    <div class="page-header">
        <h1><?=$this->e($pageTitle)?></h1>
    </div>

    <?=$page?>

</article>
