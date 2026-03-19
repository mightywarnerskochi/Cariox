<?php
$page_title = 'Thank You | Cariox';
$page_desc = '';
include __DIR__ . '/includes/header.php';
?>

<section class="thank-you-page d-flex align-items-center justify-content-center text-center">
    <div class="bg-vector">
        <picture>
            <img src="public/images/inner/inner-vector.png" alt="vector">
        </picture>
    </div>
    <div class="container-ctn">
        <div class="thank-you-content">
            <div class="graphic-thank-you ">
                <img loading="lazy" src="public/images/thank-you.png" alt="Thank You" class="img-fluid">
            </div>
            <h2>Thank You</h2>
            <p>Your submission has been receive. We will be in touch and contact you soon.</p>
            <div class="action-buttons d-flex justify-content-center mt-4">
                <a href="index.php" class="btn btn-gradient">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
