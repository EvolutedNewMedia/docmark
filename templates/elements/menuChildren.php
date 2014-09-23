<?php if (isset($children) && ! empty($children)): ?>
    <ul class="nav nav-list">

        <?php foreach ($children as $item): ?>

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
            <li class="<?php echo $class; ?>">
                <a href="<?php echo $item['link']; ?>">
                    <?php echo $item['label']; ?>
                </a>

                <?php if (isset($item['children']) && ! empty($item['children'])): ?>
                    <?php echo $helper->includeTemplate('menuChildren.php', array('children' => $item['children'], 'helper' => $helper)); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>