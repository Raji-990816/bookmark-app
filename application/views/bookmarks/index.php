<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('header'); 
?>
<div class="container">
    <h1>Bookmarks</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookmarks as $bookmark): ?>
                <tr>
                    <td><?php echo $bookmark['title']; ?></td>
                    <td><a href="<?php echo $bookmark['url']; ?>"><?php echo $bookmark['url']; ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <?php echo $links; ?> <!-- Pagination links -->
    </div>
</div>
<?php $this->load->view('footer'); ?>
