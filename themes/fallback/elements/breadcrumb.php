<?php if (isset($breadcrumb) && ! empty($breadcrumb)): ?>
    <ol class="breadcrumb">

        <?php $count = (count($breadcrumb) - 1); ?>
        <?php foreach ($breadcrumb as $key => $item): ?>
            <li>
                <?php if ($key < $count): ?>
                    <a href="<?=$this->e($item['link'])?>">
                <?php endif; ?>
                    <?=$this->e($item['label'])?>

                <?php if ($key < $count): ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

    </ol>
<?php endif; ?>