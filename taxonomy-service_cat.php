<?php get_header(); ?>

<?php
$term = get_queried_object();
$title = get_field('term_title', $term) ?: $term->name;
$descr = get_field('term_descr', $term) ?: $term->description;

$image = get_field('category_heading_image', $term) ?: get_field('category_image', $term);
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


<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php
$term = get_queried_object();
$prices_group = get_field('all_services_prices_list', 'option', false);

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

if ($services_query->have_posts()) :
?>
    <section class="price price--blue">
        <div class="container">
            <div class="price__hint hint">Прайс-лист</div>
            <h2 class="price__title title">
                Цены на услугу <br>
                <span class="color-accent"><?php echo esc_html($term->name); ?></span>
            </h2>
            <div class="price__table-wrapper custom-table">
                <table>
                    <thead>
                        <tr>
                            <th>Наименование услуги</th>
                            <th>Стоимость</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($services_query->have_posts()) : $services_query->the_post();
                            $sid = get_the_ID();
                            $service_data = $prices_group['service_data_' . $sid] ?? null;


                            $first_row = $service_data['additional_services'][0] ?? null;

                            $display_name = get_the_title();
                            $display_price = $first_row['price'] ?? '—';

                        ?>
                            <tr>
                                <td data-label="Наименование">
                                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                                        <?php echo esc_html($display_name); ?>
                                    </a>
                                </td>
                                <td data-label="Стоимость" class="price__value">
                                    <?php echo esc_html($display_price); ?>
                                </td>
                            </tr>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>