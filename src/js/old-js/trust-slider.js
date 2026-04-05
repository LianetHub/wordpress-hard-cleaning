document.addEventListener('DOMContentLoaded', function () {
    var slider = document.querySelector('.js-trust-slider');
    var cards = slider ? Array.prototype.slice.call(slider.querySelectorAll('.trust-card')) : [];
    var dotsWrap = document.querySelector('.js-trust-dots');
    var dots = dotsWrap ? Array.prototype.slice.call(dotsWrap.querySelectorAll('.trust-dot')) : [];

    if (!slider || !cards.length || !dots.length) {
        return;
    }

    var current = 0;
    var touchStartX = 0;
    var touchEndX = 0;
    var mqMobile = window.matchMedia('(max-width: 768px)');
    var resizeTimer;

    function show(index) {
        if (index < 0) index = cards.length - 1;
        if (index >= cards.length) index = 0;
        current = index;

        cards.forEach(function (card, i) {
            card.classList.toggle('is-active', i === current);
        });

        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });

        updateSliderMinHeight();
    }

    /** Высота контейнера = самая высокая карточка + место под полоски (≤768px). */
    function updateSliderMinHeight() {
        if (!mqMobile.matches) {
            slider.style.minHeight = '';
            cards.forEach(function (c) {
                c.removeAttribute('style');
            });
            return;
        }

        var maxH = 0;
        var keep = current;

        cards.forEach(function (card) {
            cards.forEach(function (c) {
                c.classList.remove('is-active');
            });
            card.classList.add('is-active');

            card.style.cssText =
                'position:relative;opacity:1;transform:none;inset:auto;width:100%;max-width:none;' +
                'height:auto;min-height:0;margin:0;pointer-events:none;box-sizing:border-box;';

            maxH = Math.max(maxH, card.offsetHeight);
        });

        cards.forEach(function (c) {
            c.removeAttribute('style');
            c.classList.remove('is-active');
        });
        showWithoutMeasure(keep);

        var dotsReserve = 26;
        slider.style.minHeight = Math.ceil(maxH + dotsReserve) + 'px';
    }

    function showWithoutMeasure(index) {
        if (index < 0) index = cards.length - 1;
        if (index >= cards.length) index = 0;
        current = index;

        cards.forEach(function (card, i) {
            card.classList.toggle('is-active', i === current);
        });

        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });
    }

    function onResize() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            updateSliderMinHeight();
        }, 100);
    }

    // init
    showWithoutMeasure(0);
    updateSliderMinHeight();

    window.addEventListener('resize', onResize);
    window.addEventListener('load', function () {
        if (mqMobile.matches) {
            updateSliderMinHeight();
        }
    });
    if (typeof mqMobile.addEventListener === 'function') {
        mqMobile.addEventListener('change', updateSliderMinHeight);
    } else if (typeof mqMobile.addListener === 'function') {
        mqMobile.addListener(updateSliderMinHeight);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            var idx = parseInt(dot.getAttribute('data-index') || '0', 10);
            show(idx);
        });
    });

    slider.addEventListener(
        'touchstart',
        function (e) {
            if (!e.touches || !e.touches.length) return;
            touchStartX = e.touches[0].clientX;
        },
        { passive: true }
    );

    slider.addEventListener(
        'touchend',
        function (e) {
            if (!e.changedTouches || !e.changedTouches.length) return;
            touchEndX = e.changedTouches[0].clientX;
            var delta = touchEndX - touchStartX;

            if (Math.abs(delta) < 40) return;

            if (delta < 0) {
                show(current + 1);
            } else {
                show(current - 1);
            }
        },
        { passive: true }
    );
});
