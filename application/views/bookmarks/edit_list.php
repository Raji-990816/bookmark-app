<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>
<h1>Update Bookmarks</h1>
<a>Click the bookmark to edit:</a>
<ul id="bookmarkList">
    <?php foreach ($bookmarks as $bookmark): ?>
        <li data-id="<?= $bookmark['id'] ?>">
            <a href="#"><?= $bookmark['title'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<script>
// Backbone View for Edit List
var EditListView = Backbone.View.extend({
    el: '#bookmarkList',
    events: {
        'click li': 'editBookmark'
    },
    initialize: function() {
        // Initialization
    },
    editBookmark: function(e) {
        e.preventDefault();
        var bookmarkId = $(e.currentTarget).data('id');
        // Redirect to the edit view of the bookmark with the specific ID
        window.location.href = '<?= site_url('bookmark/edit_view/') ?>' + bookmarkId;
    }
});

// Initialize the EditListView when the document is ready
$(function() {
    new EditListView();
});
</script>
<?php $this->load->view('footer'); ?>
