<?php get_header(); ?>

<main id="primary" class="site-main">


    <?php require_once(TEMPLATE_PATH . '_hero.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_scenarios.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_features.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_pricing.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_cases.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_equipment.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_coverage.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_contacts.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_cta.php'); ?>


</main>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // BA Slider logic
        const baSliders = document.querySelectorAll('.ba-container');

        console.log(baSliders);


        baSliders.forEach(slider => {
            const overImg = slider.querySelector('.ba-img.over');
            const handle = slider.querySelector('.ba-handle-new');

            if (overImg && handle) {
                const move = (e) => {
                    const rect = slider.getBoundingClientRect();
                    let x = (e.pageX || e.touches[0].pageX) - rect.left - window.scrollX;
                    if (x < 0) x = 0;
                    if (x > rect.width) x = rect.width;
                    const percent = (x / rect.width) * 100;
                    overImg.style.clipPath = `inset(0 ${100 - percent}% 0 0)`;
                    handle.style.left = `${percent}%`;
                };

                slider.addEventListener('mousemove', move);
                slider.addEventListener('touchmove', move);
            }
        });
    });
</script>
 -->

<?php get_footer(); ?>