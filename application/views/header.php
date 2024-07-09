<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookmark Application</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">Bookmark App</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php if ($this->session->userdata('user_id')): ?>
                    <!-- Search Form -->
                    <li class="nav-item">
                        <form class="form-inline ml-auto" action="<?= site_url('bookmark/search') ?>" method="get">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search by tags..." aria-label="Search" name="tags">
                            <button class="btn" type="submit">Search</button>
                        </form>
                    </li>
                    <!-- Navigation links for logged-in users -->
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('bookmark/index') ?>">View Bookmarks</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('bookmark/create') ?>">Add Bookmark</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('bookmark/edit_view') ?>">Update Bookmark</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('bookmark/delete_view') ?>">Delete Bookmarks</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('user/logout') ?>">Logout</a></li>
                <?php else: ?>
                    <!-- Navigation links for guests -->
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('user/register') ?>">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('user/login') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
