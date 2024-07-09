<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>
<div class="container">
    <h1>Search Results</h1>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $bookmark): ?>
                <li><?= $bookmark['title'] ?> - <a href="<?= $bookmark['url'] ?>" target="_blank"><?= $bookmark['url'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No bookmarks found for the specified tags.</p>
    <?php endif; ?>
</div>
<?php $this->load->view('footer'); ?>
