<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php include('header.php'); ?>

<h1>Login</h1>

<!-- Login form -->
<form id="login-form" method="post" action="#">
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn ">Login</button>
</form>

<script>
    // Backbone model for login
    var LoginModel = Backbone.Model.extend({
        url: '<?= site_url('user/login') ?>',
        defaults: {
            username: '',
            password: ''
        }
    });

    // Backbone view for handling login form
    var LoginView = Backbone.View.extend({
        el: '#login-form',

        events: {
            'submit': 'submitForm' // Bind submit event to submitForm method
        },

        initialize: function () {
            this.model = new LoginModel();
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
                    console.log('Login successful', response);
                    if(response.success) {
                        alert('Login Successful!');
                        window.location.href = '<?= site_url('bookmark/index') ?>';
                    } else {
                        alert(response.error);
                    }
                },
                error: function (model, response) {
                    console.log('Login failed', response);
                    alert('Invalid username or password!');
                }
            });
        }
    });

    // Initialize the login view when the document is ready
    $(document).ready(function() {
        var loginView = new LoginView();
    });
</script>

<?php include('footer.php'); ?>
