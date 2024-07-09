<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>
<h1>Delete Bookmarks</h1>
<ul id="bookmarkList">
    <?php foreach ($bookmarks as $bookmark): ?>
        <li data-id="<?= $bookmark['id'] ?>">
            <a href="<?= site_url('bookmark/edit_view/' . $bookmark['id']) ?>"><?= $bookmark['title'] ?></a>
            <button class="delete btn" data-id="<?= $bookmark['id'] ?>">Delete</button>
        </li>
    <?php endforeach; ?>
</ul>
<script>
// Backbone Model for Bookmark
var Bookmark = Backbone.Model.extend({
    urlRoot: '/bookmark_app/index.php/bookmark/delete_view', // URL for deleting bookmarks (assuming proper CodeIgniter routes)
    defaults: {
        title: '',
        url: '',
        tags: ''
    }
});

// Backbone Collection for Bookmarks
var BookmarksCollection = Backbone.Collection.extend({
    model: Bookmark,
    url: '/bookmark' // URL for the collection of bookmarks
});

// Backbone View for the Bookmarks List
var BookmarkListView = Backbone.View.extend({
    el: '#bookmarkList', // Element where the view will be rendered

    events: {
        'click .delete': 'deleteBookmark' // Event handler for delete button clicks
    },

    initialize: function() {
        // Initialize the collection with data passed from PHP
        this.collection = new BookmarksCollection(<?php echo json_encode($bookmarks); ?>);
    },

    deleteBookmark: function(e) {
        e.preventDefault();
        var bookmarkId = $(e.currentTarget).data('id');
        var bookmark = this.collection.get(bookmarkId); // Get the bookmark model from the collection

        if (bookmark) {
            // Destroy the bookmark model on the server
            bookmark.destroy({
                success: function(model, response) {
                    alert('Bookmark deleted successfully!');
                    window.location.reload(); // Reload the page after deletion
                },
                error: function(model, response) {
                    alert('Error deleting bookmark!');
                }
            });
        } else {
            console.error('Bookmark not found in collection:', bookmarkId);
        }
    }
});

// Initialize the BookmarkListView when the document is ready
$(function() {
    var bookmarksView = new BookmarkListView();
});
</script>
<?php $this->load->view('footer'); ?>
