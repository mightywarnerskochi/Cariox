<?php
$page_title = '404 - Page Not Found | Cariox';
$page_desc = '';
include __DIR__ . '/includes/header.php';
?>

    <div class="inner-vector">
        <picture><img src="public/images/inner/inner-vector.png" alt="About Us"></picture>
    </div>
<section class="inner-banner contact-banner">
    <div class="container-ctn w-100">
        <div class="content">
         
        </div>
    </div>
</section>
<section class="not-found-page">
    <div class="bg-vector">
        <picture>
            <img src="public/images/inner/inner-vector.png" alt="vector">
        </picture>
    </div>
    <div class="container-ctn">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6 text-center text-md-end pe-md-5 mb-5 mb-md-0">
                <div class="graphic-404">
                    <img loading="lazy" src="public/images/404.png" alt="404" class="img-fluid" style="max-width: 320px;">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="content-404">
                    <h2>Oops! i think we have something broken</h2>
                    <p>Sorry, the page you are looking for does not exist. If you think something is
                        broken, report a problem</p>
                    <div class="action-buttons d-flex flex-wrap gap-3 mt-4">
                        <a href="index.php" class="btn btn-gradient">Back to Home</a>
                        <a href="contact.php" class="btn btn-outline-custom">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
