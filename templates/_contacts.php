 <section id="contacts" class="map-section-full">
     <div id="yandex-map" style="width: 100%; height: 100%;"></div>
 </section>
 <!-- Подключаем API Яндекс Карт -->
 <!-- В идеале получите свой API ключ в кабинете разработчика Яндекса и вставьте вместо "ваш_api_ключ" -->
 <script src="https://api-maps.yandex.ru/2.1/?apikey=496cd84c-0a7a-4b7e-a9d5-bd9261e5f0a6&lang=ru_RU" type="text/javascript"></script>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         // Ждем загрузки API Яндекса
         ymaps.ready(init);

         function init() {
             // Координаты вашего офиса (пр. Металлистов д. 19/30)
             // Примерные координаты, замените на точные
             var centerCoords = [59.957545, 30.412431];

             // Создаем карту
             var myMap = new ymaps.Map('yandex-map', {
                 center: centerCoords,
                 zoom: 17, // Чуть ближе к метке
                 controls: ['zoomControl'] // Оставляем только зум
             });

             // Отключаем скролл колесиком (чтобы страница не застревала на карте)
             myMap.behaviors.disable('scrollZoom');

             // Создаем кастомный HTML-макет (шаблон) для нашего балуна (карточки)
             var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                 '<div class="map-custom-card">' +
                 '<h3 class="m-card-title">Спецуборка — офис</h3>' +
                 '<p class="m-card-address">Санкт-Петербург, пр. Металлистов д. 19/30</p>' +
                 '<p class="m-card-phone">Тел: <a href="tel:+78129007868">+7 (812) 900-78-68</a></p>' +
                 '<span class="m-card-badge">Выезд по СПб и ЛенОбласти</span>' +
                 '<div class="m-card-actions">' +
                 // Замените ссылку на реальную ссылку маршрута в Яндекс Картах
                 '<a href="https://yandex.ru/maps/-/CD..." target="_blank" class="btn-map btn-map-solid">Маршрут</a>' +
                 '<a href="tel:+78129007868" class="btn-map btn-map-outline">Позвонить</a>' +
                 '</div>' +
                 '</div>'
             );

             var pinGapPx = window.innerWidth <= 768 ? 8 : 10;
             var myPlacemark;

             function syncBalloonOffsetFromDom() {
                 var el = document.querySelector('#yandex-map .map-custom-card');
                 if (!el || !myPlacemark) {
                     return;
                 }
                 var rect = el.getBoundingClientRect();
                 var w = rect.width;
                 var h = rect.height;
                 /* Родитель балуна иногда отдаёт схлопнутую ширину на первом кадре — не доверять min(100%,…) */
                 if (w < 120) {
                     w = Math.min(245, Math.max(196, Math.round(196 + (window.innerWidth - 360) * 0.12)));
                 }
                 if (h < 2) {
                     return;
                 }
                 myPlacemark.options.set('balloonOffset', [
                     -Math.round(w / 2),
                     -Math.round(h + pinGapPx)
                 ]);
             }

             myPlacemark = new ymaps.Placemark(centerCoords, {
                 // Данные метки (не обязательны, так как шаблон жестко прописан, но можно передавать переменные)
             }, {
                 balloonLayout: MyBalloonLayout,
                 balloonCloseButton: false,
                 balloonPanelMaxMapArea: 0,
                 hideIconOnBalloonOpen: false,
                 balloonOffset: [0, 0]
             });

             myPlacemark.events.add('balloonopen', function() {
                 requestAnimationFrame(function() {
                     requestAnimationFrame(syncBalloonOffsetFromDom);
                 });
                 setTimeout(syncBalloonOffsetFromDom, 120);
             });

             var balloonResizeTimer;
             window.addEventListener('resize', function() {
                 clearTimeout(balloonResizeTimer);
                 balloonResizeTimer = setTimeout(function() {
                     if (!myPlacemark || !myPlacemark.balloon.isOpen()) {
                         return;
                     }
                     pinGapPx = window.innerWidth <= 768 ? 8 : 10;
                     syncBalloonOffsetFromDom();
                 }, 150);
             });

             myMap.geoObjects.add(myPlacemark);
             myPlacemark.balloon.open();
         }
     });
 </script>