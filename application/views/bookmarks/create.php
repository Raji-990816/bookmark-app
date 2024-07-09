<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('header'); ?>

<h1>Add New Bookmark</h1>
<form id="addBookmarkForm">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" class="form-control">
    </div>
    <div class="form-group">
        <label for="url">URL:</label>
        <input type="url" name="url" id="url" class="form-control">
    </div>
    <div class="form-group">
        <label for="tags">Tags:</label>
        <input type="text" name="tags" id="tags" class="form-control">
    </div>
    <button type="submit" class="btn">Add</button>
</form>
<script>
    // Backbone Model for Bookmark
    var Bookmark = Backbone.Model.extend({
        urlRoot: '<?= site_url('bookmark/create') ?>', // URL for creating a new bookmark
        defaults: {
            title: '',
            url: '',
            tags: ''
        },
        validate: function(attrs) {
            var errors = [];
            if (!attrs.title) {
                errors.push('Title is required');
            }
            if (!attrs.url) {
                errors.push('URL is required');
            }
            if (!attrs.tags) {
                errors.push('Tags are required');
            }
            if (errors.length > 0) {
                return errors;
            }
        }
    });

    // Backbone View for Add Bookmark Form
    var AddBookmarkView = Backbone.View.extend({
        el: '#addBookmarkForm', // Element where the view will be rendered

        events: {
            'submit': 'submitForm' // Event handler for form submission
        },

        submitForm: function(e) {
            e.preventDefault();
            var newBookmark = new Bookmark({
                title: this.$('#title').val(),
                url: this.$('#url').val(),
                tags: this.$('#tags').val()
            });

            if (newBookmark.isValid()) {
                // If the bookmark model is valid, attempt to save it
                console.log('Bookmark is valid, attempting to save:', newBookmark.toJSON());
                newBookmark.save(null, {
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(newBookmark.toJSON()),
                    dataType: 'json', // Ensure response is JSON
                    success: function(model, response) {
                        alert('Bookmark added successfully!');
                        window.location.href = '<?= site_url('bookmark/index') ?>'; // Redirect to index page after successful save
                    },
                    error: function(model, xhr, options) {
                        console.error('Error response:', xhr);
                        console.error('Text Status:', xhr.statusText);
                        console.error('Error Thrown:', xhr.responseText);
                        alert('Error adding bookmark!');
                    }
                });
            } else {
                alert(newBookmark.validationError.join('\n')); // Show validation errors if any
            }
        }
    });

    // Initialize the AddBookmarkView when the document is ready
    $(function() {
        new AddBookmarkView();
    });

</script>
<?php $this->load->view('footer'); ?>
