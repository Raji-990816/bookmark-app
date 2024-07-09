<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php include('header.php'); ?>

<h1>Register</h1>

<!-- Registration form -->
<form id="register-form" method="post" action="#">
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn ">Register</button>
</form>

<script>
    // Backbone model for registration
    var RegisterModel = Backbone.Model.extend({
        url: '<?= site_url('user/register') ?>',
        defaults: {
            username: '',
            password: ''
        }
    });

    // Backbone view for handling registration form
    var RegisterView = Backbone.View.extend({
        el: '#register-form',

        events: {
            'submit': 'submitForm' // Bind submit event to submitForm method
        },

        initialize: function () {
            this.model = new RegisterModel();
        },

        // Handle form submission
        submitForm: function (event) {
            event.preventDefault(); // Prevent default form submission

            var username = this.$('[name="username"]').val();
            var password = this.$('[name="password"]').val();
            this.model.set({ username: username, password: password });

            // Save the model and handle success and error responses
            this.model.save(null, {
                success: function (model, response) {
                    console.log('Registration successful', response);
                    if(response.success) {
                        alert('Registration Successful!');
                        window.location.href = '<?= site_url('user/login') ?>';
                    } else {
                        alert(response.error);
                    }
                },
                error: function (model, response) {
                    console.log('Registration failed', response);
                    alert('Registration failed!');
                }
            });
        }
    });

    // Initialize the registration view when the document is ready
    $(document).ready(function() {
        var registerView = new RegisterView();
    });
</script>

<?php include('footer.php'); ?>
