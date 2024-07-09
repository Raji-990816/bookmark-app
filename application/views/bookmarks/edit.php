<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>
<div class="container">
    <h1>Edit Bookmark</h1>
    <form id="editBookmarkForm" method="post" action="<?= site_url('bookmark/edit_view/'.$bookmark['id']) ?>">
        <input type="hidden" id="id" name="id" value="<?= $bookmark['id'] ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $bookmark['title'] ?>" required>
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="url" class="form-control" id="url" name="url" value="<?= $bookmark['url'] ?>" required>
        </div>
        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" class="form-control" id="tags" name="tags" value="<?= $bookmark['tags'] ?>">
        </div>
        <button type="submit" class="btn">Update</button>
    </form>
</div>
<script>
// Backbone Model for Bookmark
var Bookmark = Backbone.Model.extend({
    urlRoot: '/bookmark_app/index.php/bookmark/edit_view', // URL for editing bookmark
    defaults: {
        title: '',
        url: '',
        tags: ''
    },
    idAttribute: 'id' // Specify the id attribute for the model
});

// Backbone View for Edit Form
var EditBookmarkView = Backbone.View.extend({
    el: '#editBookmarkForm', // Element where the view will be rendered

    events: {
        'submit': 'saveBookmark' // Event handler for form submission
    },

    initialize: function() {
        this.model = new Bookmark(<?php echo json_encode($bookmark); ?>); // Initialize the model with the current bookmark data
    },

    saveBookmark: function(e) {
        e.preventDefault();
        var formData = {
            title: $('#title').val(),
            url: $('#url').val(),
            tags: $('#tags').val()
        };

        this.model.save(formData, {
            type: 'PUT', // Use HTTP PUT method for updating
            success: function(model, response) {
                console.log(response); // Log server response in the console
                alert('Bookmark updated successfully!');
                window.location.href = '<?= site_url('bookmark') ?>'; // Redirect to bookmark index page after successful update
            },
            error: function(model, response) {
                console.log(response); // Log server response in the console
                alert('Error updating bookmark!');
            }
        });
    }
});

// Initialize the EditBookmarkView when the document is ready
$(function() {
    new EditBookmarkView();
});
</script>

<?php $this->load->view('footer'); ?>
