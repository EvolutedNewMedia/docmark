<?php if (isset($menu) && ! empty($menu)): ?>
    <ul class="nav nav-list">

        <?php foreach ($menu as $item): ?>
            <li class="<?php echo (isset($item['activeParent'])) ? 'open' : ''; echo (isset($item['active'])) ? ' active' : ''; ?>">
                <a href="<?php echo $item['link']; ?>">
                    <?php echo $item['label']; ?>
                </a>

                <?php if (isset($item['children']) && ! empty($item['children'])): ?>
                    <?php echo $helper->includeTemplate('menuChildren.php', array('menu' => $item['children'], 'helper' => $helper)); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>