<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = "Spotcast - Premium Podcast Production in Dubai";
$page_desc = "Spotcast brings the studio to you. We record podcasts anywhere in Dubai - indoors, outdoors, or on-location. High-quality video and audio production.";

switch ($current_page) {
    case 'about.php':
        $page_title = "About Us | Spotcast - Your Story, Anywhere";
        $page_desc = "Learn about Spotcast, a flexible podcast production crew in Dubai giving creators freedom and authenticity with diverse backdrops.";
        break;
    case 'services.php':
        $page_title = "Our Services | Spotcast - Mobile & Studio Podcasting";
        $page_desc = "Explore Spotcast services: Mobile Podcast Production, Cinematic Sets, Studio Recording, and Professional Video Editing in Dubai.";
        break;
    case 'work.php':
        $page_title = "Our Work | Spotcast - Podcast Portfolio";
        $page_desc = "View our portfolio of podcasts produced in Dubai's most unique settings. From industry leaders to rising creators.";
        break;
    case 'contact-us.php':
        $page_title = "Contact Us | Spotcast - Book Your Session";
        $page_desc = "Get in touch with Spotcast for your podcast production needs in Dubai. Call us or book a free quote online.";
        break;
    case 'work-details.php':
        $page_title = "Project Details | Spotcast";
        break;
    case 'privacy-policy.php':
        $page_title = "Privacy Policy | Spotcast";
        break;
    case 'terms-and-conditions.php':
        $page_title = "Terms & Conditions | Spotcast";
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
    <link rel="stylesheet" href="public/css/lib/slick-full.css" />
    <link rel="stylesheet" href="public/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="public/css/lib/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Main Style -->
    <link rel="stylesheet" href="public/scss/style.css" />
</head>

<body>

    <header id="header" role="banner" class="site-header">
        <div class="container-ctn">
            <div class="d-flex justify-content-between align-items-center flex-wrap header-row">
                <!-- Logo with alt text for screen readers -->
                <a href="index.php" aria-label="Website Logo" class="brand">
                    <picture>
                        <img src="public/images/logo.png" alt="Spotcast logo" width="178" height="54" loading="lazy" />
                    </picture>
                </a>

                <div class="header-right d-flex align-items-center">
                    <!-- Navigation bar for desktop users -->
                    <nav class="d-none d-md-block" role="navigation">
                        <ul class="d-flex flex-wrap">
                            <li><a href="services.php" aria-label="Explore our services">Services</a></li>
                            <li><a href="contact-us.php" aria-label="Contact us">Contact</a></li>
                        </ul>
                    </nav>

                    <!-- Hamburger menu for mobile (trigger for offcanvas menu) -->
                    <button class="navbar-toggler " type="button" data-bs-toggle="offcanvas"
                        aria-label="Click to open menu" aria-controls="burgerMenu" data-bs-target="#burgerMenu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 48 48" fill="none">
                            <path d="M8 12H40M8 24H24M8 36H40" stroke="black" stroke-width="4" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
