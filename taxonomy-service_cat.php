<?php get_header(); ?>

<?php
$term = get_queried_object();
$title = get_field('term_title', $term) ?: $term->name;
$descr = get_field('term_descr', $term) ?: $term->description;

$image = get_field('category_heading_image', $term) ?: get_field('category_image', $term);

$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php echo wp_kses($title, ['span' => ['class' => []]]); ?>
            </h1>
            <?php if ($descr): ?>
                <p class="heading__subtitle subtitle"><?php echo $descr; ?></p>
            <?php endif; ?>
            <div class="heading__btns">
                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="heading__btn btn btn-secondary">Срочный вызов</a>
                <?php endif; ?>
                <a href="#callback" data-fancybox class="heading__btn btn btn-outline">Оставить заявку</a>
            </div>
        </div>
        <?php if ($image): ?>
            <div class="heading__image">
                <img src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                    class="cover-image">
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>

<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php
$term = get_queried_object();
$prices_group = get_field('all_services_prices_list', 'option');

$services_query = new WP_Query([
    'post_type'      => 'services',
    'posts_per_page' => -1,
    'tax_query'      => [
        [
            'taxonomy' => 'service_cat',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ],
    ],
    'orderby' => 'title',
    'order'   => 'ASC',
]);

if ($services_query->have_posts()) : ?>
    <section class="price price--blue">
        <div class="container">
            <div class="price__hint hint">Прайс-лист</div>
            <h2 class="price__title title">
                Цены на услугу <br>
                <span class="color-accent"><?php echo esc_html($term->name); ?></span>
            </h2>
            <div class="price__table-wrapper custom-table">
                <table class="js-price-table">
                    <thead>
                        <tr>
                            <th>Наименование услуги</th>
                            <th>Стоимость</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $row_counter = 0;
                        while ($services_query->have_posts()) : $services_query->the_post();
                            $row_counter++;
                            $sid = get_the_ID();
                            $service_data = $prices_group['service_data_' . $sid] ?? null;
                            $display_name = get_the_title();
                            $display_price = !empty($service_data['service_price']) ? $service_data['service_price'] : '—';

                            $row_class = ($row_counter > 12) ? 'is-hidden' : '';
                        ?>
                            <tr class="<?php echo $row_class; ?>">
                                <td data-label="Наименование">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo esc_html($display_name); ?>
                                    </a>
                                </td>
                                <td data-label="Стоимость" class="price__value">
                                    от <?php echo format_service_price($display_price); ?> ₽
                                </td>
                            </tr>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </tbody>
                </table>

                <?php if ($row_counter > 12) : ?>
                    <div class="price__more-wrapper">
                        <button class="btn btn-secondary js-price-show-more" data-text-less="Скрыть">
                            Показать все цены
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_equipment.php'); ?>
<?php require_once(TEMPLATE_PATH . '_coverage.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>