<?php
$terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'include'    => [8, 6, 4, 5, 41],
    'orderby'    => 'include'
]);

$extra_service_id = 821;
$extra_service = get_post($extra_service_id);
?>

<section class="services">
    <div class="services__container container">
        <div class="services__hint hint">НАШ ОПЫТ</div>
        <h2 class="services__title title">С какими <span class="color-accent">ситуациями</span> мы работаем</h2>

        <ul class="services__list">
            <?php
            if (!empty($terms) && !is_wp_error($terms)) :
                foreach ($terms as $term):
                    get_template_part('templates/components/card', 'service-cat', [
                        'term' => $term
                    ]);
                endforeach;
            endif;

            if ($extra_service && $extra_service->post_status === 'publish') :
                get_template_part('templates/components/card', 'service-item', [
                    'post' => $extra_service
                ]);
            endif;
            ?>
        </ul>

        <?php
        $all_services_link = get_post_type_archive_link('services');
        if ($all_services_link) : ?>
            <a href="<?php echo esc_url($all_services_link); ?>" class="services__more btn btn-outline">Все услуги</a>
        <?php endif; ?>
    </div>
</section>