 <?php
    $image = get_field('hero_image');
    $tags = get_field('hero_tags');
    $title = get_field('hero_title') ?: 'Комплексная спецуборка в Санкт-Петербурге и области';
    $subtitle = get_field('hero_subtitle') ?: 'После смерти, пожара, потопа и сильного загрязнения. Оценка в день обращения. Выезд по СПб и Ленобласти.';
    ?>

 <section class="hero">
     <div class="hero__container container">
         <div class="hero__image">
             <?php if ($image): ?>
                 <img src="<?php echo esc_url($image['url']); ?>"
                     alt="<?php echo esc_attr($image['alt']); ?>"
                     class="hero__image-main"
                     fetchpriority="high"
                     loading="eager">
             <?php else: ?>
                 <img src="<?php echo get_template_directory_uri(); ?>/assets/hero_cleaners.png"
                     alt="Спецуборка"
                     class="hero__image-main"
                     fetchpriority="high"
                     loading="eager">
             <?php endif; ?>

             <?php if ($tags): ?>
                 <ul class="hero__tags">
                     <?php foreach ($tags as $tag): ?>
                         <li class="hero__tag">
                             <?php if ($tag['icon']): ?>
                                 <div class="hero__tag-icon">
                                     <img src="<?php echo esc_url($tag['icon']['url']); ?>"
                                         alt="<?php echo esc_attr($tag['icon']['alt']); ?>">
                                 </div>
                             <?php endif; ?>
                             <div class="hero__tag-text"><?php echo esc_html($tag['text']); ?></div>
                         </li>
                     <?php endforeach; ?>
                 </ul>
             <?php endif; ?>
         </div>

         <div class="hero__offer">
             <h1 class="hero__title title-lg"><?php echo $title; ?></h1>
             <p class="hero__subtitle"><?php echo esc_html($subtitle); ?></p>
             <div class="hero__btns">
                 <a href="#contacts" class="hero__btn btn btn-primary">Срочный вызов</a>
                 <a href="#contacts" class="hero__btn btn btn-outline">Рассчитать стоимость</a>
             </div>
         </div>
     </div>
 </section>