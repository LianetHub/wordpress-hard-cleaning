<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="portfolio">
    <div class="container">
        <div class="portfolio__hint hint">Наши работы</div>
        <h1 class="portfolio__title title">Примеры <span class="color-accent">выполненных работ</span></h1>
        <p class="portfolio__subtitle subtitle">Фотографии до и после — без фильтров и обработки</p>

        <?php
        $args = [
            'post_type'      => 'portfolio',
            'posts_per_page' => -1,
            'post_status'    => 'publish'
        ];
        $portfolio_query = new WP_Query($args);

        $used_term_ids = [];

        if ($portfolio_query->have_posts()) {
            foreach ($portfolio_query->posts as $p) {
                $services = get_field('case_service_link', $p->ID);
                $primary_term_id = (!empty($services) && is_array($services)) ? $services[0] : $services;
                if ($primary_term_id) {
                    $used_term_ids[] = (int) $primary_term_id;
                }
            }
        }

        $used_term_ids = array_unique($used_term_ids);
        $categories = [];

        if (!empty($used_term_ids)) {
            $categories = get_terms([
                'taxonomy'   => 'service_cat',
                'include'    => $used_term_ids,
                'hide_empty' => false,
            ]);
        }

        if (!is_wp_error($categories) && !empty($categories)) :
        ?>
            <div class="portfolio__filters filters swiper">
                <div class="swiper-wrapper">
                    <button type="button" data-filter="all" class="filters__item portfolio-filter swiper-slide btn btn-sm btn-outline active">
                        Все работы
                    </button>

                    <?php foreach ($categories as $category) : ?>
                        <button type="button" data-filter="<?php echo esc_attr($category->term_id); ?>" class="filters__item portfolio-filter swiper-slide btn btn-sm btn-outline">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="portfolio__grid">
            <?php
            if ($portfolio_query->have_posts()) :
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    get_template_part('templates/components/card-portfolio');
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Работы еще не добавлены.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.portfolio-filter');
        const portfolioCards = document.querySelectorAll('.case-card');

        if (!filterButtons.length || !portfolioCards.length) return;

        const applyFilter = (filterValue) => {
            filterButtons.forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-filter') === filterValue);
            });

            portfolioCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (filterValue === 'all' || filterValue === cardCategory) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        };

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filterValue = button.getAttribute('data-filter');
                applyFilter(filterValue);

                const url = new URL(window.location);
                if (filterValue === 'all') {
                    url.searchParams.delete('filter');
                } else {
                    url.searchParams.set('filter', filterValue);
                }
                window.history.replaceState({}, '', url);
            });
        });

        const urlParams = new URLSearchParams(window.location.search);
        const initialFilter = urlParams.get('filter');

        if (initialFilter && document.querySelector(`.portfolio-filter[data-filter="${initialFilter}"]`)) {
            applyFilter(initialFilter);
        } else {
            applyFilter('all');
        }
    });
</script>

<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>
<?php get_footer(); ?>