<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = "Cariox - Industrial Automation Solutions";
$page_desc = "Cariox provides cutting-edge industrial automation, marking, coding, and inspection systems for modern manufacturing.";

switch ($current_page) {
    case 'about.php':
        $page_title = "About Us | Cariox";
        break;
    case 'services.php':
        $page_title = "Our Services | Cariox";
        break;
    case 'products.php':
        $page_title = "Our Products | Cariox";
        break;
    case 'contact.php':
        $page_title = "Contact Us | Cariox";
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?php echo $page_title; ?>
    </title>
    <meta name="description" content="<?php echo $page_desc; ?>">

    <!-- Performance Optimizations -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://code.jquery.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Favicons -->
    <link rel="shortcut icon" href="public/images/fav.png" type="image/png" />
    <link rel="apple-touch-icon" sizes="128x128" href="public/images/fav.png" />

    <!-- Libraries -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" href="public/css/lib/slick-full.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" />
    <link rel="stylesheet" href="public/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="public/css/lib/jquery.fancybox.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

    <!-- Main Style -->
    <link rel="stylesheet" href="public/scss/style.css" />
</head>

<body>
    <header>
        <div class="container-ctn">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="index.php">
                    <picture>
                        <img src="public/images/logo.png" width="180" height="70" class="img-fluid" alt="Cariox">
                    </picture>
                </a>
                <nav class="d-none d-xl-block">
                    <ul>
                        <li class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>"><a
                                href="index.php">Home</a></li>
                        <li class="<?php echo $current_page === 'about.php' ? 'active' : ''; ?>"><a
                                href="about.php">About Us</a></li>
                        <li class="mega-menu-item">
                            <a href="products.php"
                                class="<?php echo in_array($current_page, ['products.php', 'product-detail.php']) ? 'active' : ''; ?>">
                                Products
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                    fill="none">
                                    <path d="M5.25 7.5L9 11.25L12.75 7.5" stroke="white" stroke-width="1.125"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                            <div class="dropdown-submenu category-mega-menu">
                                <div class="mega-menu-grid">
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Ink-Jet</h4>
                                        <ul>
                                            <li><a href="product-detail.php">EBS 6500 Series</a></li>
                                            <li><a href="product-detail.php">EBS 6600 Series</a></li>
                                            <li><a href="product-detail.php">EBS 6900 Series</a></li>
                                            <li><a href="product-detail.php">EBS Bolt Series</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Marking & Coding</h4>
                                        <ul>
                                            <li><a href="product-detail.php">Handjet Handheld</a></li>
                                            <li><a href="product-detail.php">Drop on Demand</a></li>
                                            <li><a href="product-detail.php">High Definition</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Inspection</h4>
                                        <ul>
                                            <li><a href="product-detail.php">X-Ray Systems</a></li>
                                            <li><a href="product-detail.php">Metal Detectors</a></li>
                                            <li><a href="product-detail.php">Checkweighers</a></li>
                                            <li><a href="product-detail.php">Vision Systems</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Packing</h4>
                                        <ul>
                                            <li><a href="product-detail.php">VFFS Machines</a></li>
                                            <li><a href="product-detail.php">Flow Wrap</a></li>
                                            <li><a href="product-detail.php">Carton Sealers</a></li>
                                            <li><a href="product-detail.php">Pallet Wrappers</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Labelling</h4>
                                        <ul>
                                            <li><a href="product-detail.php">Label Applicators</a></li>
                                            <li><a href="product-detail.php">Print & Apply</a></li>
                                            <li><a href="product-detail.php">Rotary Labellers</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Handheld</h4>
                                        <ul>
                                            <li><a href="product-detail.php">EBS-250 Handjet</a></li>
                                            <li><a href="product-detail.php">EBS-260 Handjet</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Conveyors</h4>
                                        <ul>
                                            <li><a href="product-detail.php">Belt Conveyors</a></li>
                                            <li><a href="product-detail.php">Roller Systems</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Laser</h4>
                                        <ul>
                                            <li><a href="product-detail.php">CO2 Lasers</a></li>
                                            <li><a href="product-detail.php">Fiber Lasers</a></li>
                                            <li><a href="product-detail.php">UV Lasers</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Consumables</h4>
                                        <ul>
                                            <li><a href="product-detail.php">Inks & Solvents</a></li>
                                            <li><a href="product-detail.php">Ribbons</a></li>
                                            <li><a href="product-detail.php">Labels</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-col">
                                        <h4 class="mega-menu-title">Spares</h4>
                                        <ul>
                                            <li><a href="product-detail.php">Filters</a></li>
                                            <li><a href="product-detail.php">Pumps</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mega-menu-footer">
                                    <a href="products.php" class="view-all-link">
                                        <span>Discover All Products</span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.16669 10H15.8334M15.8334 10L10 4.16669M15.8334 10L10 15.8334"
                                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="<?php echo $current_page === 'services.php' ? 'active' : ''; ?>"><a href="services.php">Services</a></li>
                        <li class="<?php echo $current_page === 'blogs.php' ? 'active' : ''; ?>"><a href="blogs.php">News & Events</a></li>
                        <li class="<?php echo $current_page === 'blogs.php' ? 'active' : ''; ?>"><a href="blogs.php">Blogs</a></li>
                        <li class="<?php echo $current_page === 'contact.php' ? 'active' : ''; ?>"><a
                                href="contact.php">Contact Us</a></li>
                    </ul>
                </nav>
                <a href="products.php" class="header-btn d-none d-lg-block">Industrial Automation</a>

                <button class="navbar-toggler d-xl-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#burgerMenu">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 7H25M5 15H25M5 23H25" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
    </header>