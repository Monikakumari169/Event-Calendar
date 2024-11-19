<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="custom-header">
    <div class="flex-wrap">
        <div class="cstm-logo">
            <div class="logo">
                <h1>Logo</h1>
            </div>
        </div>
        <div class="cstm-nav">
            <nav class="menu">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="cstm-search">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>
        </div>
    </div>

</header>


 