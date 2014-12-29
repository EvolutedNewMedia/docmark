<?php if (isset($menu) && ! empty($menu)): ?>
    <ul class="nav nav-list">

        <?php foreach ($menu as $item): ?>

            <?php
                // calculate the class we want
                $class = '';

                if (
                    isset($item['activeParent']) ||
                    (isset($item['active']) && isset($item['children']) && ! empty($item['children']))
                ):
                    // if this is a directory where a child is active, set it to open.
                    // or if we are on this directories index, open it

                    $class = 'open';
                elseif (isset($item['active'])):

                    $class = 'active';
                endif;
            ?>
            <li class="<?=$class?>">
                <a href="<?php echo (isset($item['link'])) ? $item['link'] : ''; ?>">
                    <?=$this->e($item['label'])?>
                </a>

                <?php if (isset($item['children']) && ! empty($item['children'])): ?>
                    <?php
                        $this->insert(
                            $theme . '::elements/menuChildren',
                            array(
                                'children' => $item['children']
                            )
                        );
                    ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>