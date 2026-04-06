 <?php
    $raw_coords = get_field('map_coords', 'option') ?: '59.954106, 30.422777';
    $clean_url_coords = str_replace(' ', '', $raw_coords);

    $phone = get_field('phone', 'option');
    $phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

    $address = get_field('address', 'option');
    ?>

 <section id="contacts" class="contacts">
     <div id="yandex-map"
         style="width: 100%; height: 100%;"
         data-coords="<?php echo esc_attr($raw_coords); ?>">
     </div>

     <div id="map-balloon-template" style="display: none;">
         <div class="baloon__card">
             <h3 class="baloon__title title-sm">Спецуборка — офис</h3>

             <?php if ($address): ?>
                 <address class="baloon__address"><?php echo $address; ?></address>
             <?php endif; ?>

             <?php if ($phone): ?>
                 <p class="baloon__phone">
                     Тел: <a href="tel:<?php echo $phone_clean; ?>" class="baloon__phone-link"><?php echo $phone; ?></a>
                 </p>
             <?php endif; ?>

             <span class="baloon__badge">Выезд по СПб и ЛенОбласти</span>

             <div class="baloon__actions">
                 <a href="https://yandex.ru/maps/?rtext=~<?php echo $clean_url_coords; ?>&rtt=auto"
                     target="_blank"
                     class="baloon__btn btn btn-white">
                     Маршрут
                 </a>

                 <?php if ($phone): ?>
                     <a href="tel:<?php echo $phone_clean; ?>"
                         class="baloon__btn btn btn-outline-white">Позвонить</a>
                 <?php endif; ?>
             </div>
         </div>
     </div>
 </section>