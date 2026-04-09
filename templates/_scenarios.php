<?php
$terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'slug'       => [
        'uborka-posle-pozhara', 
        'uborka-posle-potopa', 
        'uborka-posle-smerti', 
        'uborka-silno-zagryaznyonnyh-kvartir'
    ],
    'orderby'    => 'include'
]);
?>

<section class="services">
    <div class="services__container container">
        <div class="services__hint hint">НАШ ОПЫТ</div>
        <h2 class="services__title title">С какими <span class="color-accent">ситуациями</span> мы работаем</h2>
        
        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
            <ul class="services__list">
                <?php foreach ($terms as $term): 
                    get_template_part('templates/components/card', 'service-cat', [
                        'term' => $term
                    ]);
                endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <?php 
        $all_services_link = get_post_type_archive_link('services');
        if ($all_services_link) : ?>
            <a href="<?php echo esc_url($all_services_link); ?>" class="services__more btn btn-outline">Все услуги</a>
        <?php endif; ?>
    </div>
</section>