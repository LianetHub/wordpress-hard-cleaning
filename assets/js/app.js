"use strict";

// animation lazy loading images

document.addEventListener('DOMContentLoaded', () => {
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');

    lazyImages.forEach(img => {
        const parent = img.parentElement;

        function markAsLoaded() {
            img.classList.add('is-loaded');
            if (parent) {
                parent.classList.add('is-ready');
            }
        }

        if (img.complete) {
            markAsLoaded();
        } else {
            img.addEventListener('load', markAsLoaded);
            img.addEventListener('error', markAsLoaded);
        }
    });
});

$(function () {

    function normalizeGorodaLetter(letter) {
        if (!letter || letter === "all") {
            return "all";
        }
        const s = String(letter).trim().slice(0, 1);
        if (!s) {
            return "all";
        }
        if (!/^[А-ЯЁа-яё]$/u.test(s)) {
            return "all";
        }
        return s.toLocaleUpperCase("ru-RU");
    }

    function getGorodaLetterFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return normalizeGorodaLetter(params.get("letter"));
    }

    function applyGorodaLetterFilter(letter) {
        const $grid = $(".goroda-directory__grid");
        if (!$grid.length) {
            return;
        }
        const showAll = letter === "all";
        const filterLetter = showAll ? "" : normalizeGorodaLetter(letter);
        const $cards = $grid.find(".city-dir-card");

        $cards.each(function () {
            const $c = $(this);
            const cardLetter = normalizeGorodaLetter($c.attr("data-letter") || "");
            const show = showAll || cardLetter === filterLetter;
            $c.toggleClass("hidden", !show);
        });

        const $wrap = $(".goroda-directory__filters");
        $wrap.find(".goroda-letter-filter").removeClass("active");
        $wrap.find(".goroda-letter-filter").filter(function () {
            const d = $(this).attr("data-letter");
            if (showAll) {
                return d === "all";
            }
            return normalizeGorodaLetter(d) === filterLetter;
        }).addClass("active");

        const $dirSwiper = $(".goroda-directory__filters.filters");
        if ($dirSwiper.length && $dirSwiper[0].swiper) {
            $dirSwiper[0].swiper.update();
        }
    }

    if ($('.goroda-directory__grid').length) {
        applyGorodaLetterFilter(getGorodaLetterFromUrl());
    }

    $(window).on('popstate', function () {
        if ($('.goroda-directory__grid').length) {
            applyGorodaLetterFilter(getGorodaLetterFromUrl());
        }
    });

    //  init Fancybox
    if (typeof Fancybox !== "undefined" && Fancybox !== null) {
        Fancybox.bind("[data-fancybox]", {
            dragToClose: false,
        });
    }

    // detect user OS
    const isMobile = {
        Android: () => /Android/i.test(navigator.userAgent),
        BlackBerry: () => /BlackBerry/i.test(navigator.userAgent),
        iOS: () => /iPhone|iPad|iPod/i.test(navigator.userAgent),
        Opera: () => /Opera Mini/i.test(navigator.userAgent),
        Windows: () => /IEMobile/i.test(navigator.userAgent),
        any: function () {
            return this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows();
        },
    };

    function getNavigator() {
        if (isMobile.any() || $(window).width() < 992) {
            $('body').removeClass('_pc').addClass('_touch');
        } else {
            $('body').removeClass('_touch').addClass('_pc');
        }
    }

    getNavigator();

    $(window).on('resize', () => {
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(() => {
            getNavigator();
        }, 100);
    });

    // event handlers
    $(document).on('click', (e) => {
        const $target = $(e.target);
        const $menu = $('.menu');
        const $toggler = $('.header__menu-toggler');
        const isTouch = $('body').hasClass('_touch');

        // Fancybox Gallery
        const $fancyTrigger = $target.closest('[data-fancybox-gallery]');
        if ($fancyTrigger.length) {
            e.preventDefault();
            const rawData = $fancyTrigger.attr('data-gallery');
            if (rawData && typeof Fancybox !== 'undefined') {
                try {
                    const items = JSON.parse(rawData);
                    Fancybox.show(items, {
                        infinite: false,
                        dragToClose: true
                    });
                } catch (err) {
                    console.error("Fancybox JSON parse error:", err);
                }
            }
            return;
        }

        // Menu toggler
        if ($target.closest('.header__menu-toggler').length) {
            $toggler.toggleClass("active");
            $menu.toggleClass("menu--open");
            $('body').toggleClass('menu-lock');
            return;
        }

        // Close menu on click outside (overlay)
        if ($target.is('.menu') && $menu.hasClass('menu--open')) {
            $toggler.removeClass("active");
            $menu.removeClass("menu--open");
            $('body').removeClass('menu-lock');
        }

        // Handle Links & Submenus logic
        const $menuLink = $target.closest('.menu-item a');
        if ($menuLink.length) {
            const $parentItem = $menuLink.closest('.menu-item');
            const hasSubmenu = $parentItem.find('.sub-menu').length > 0 || $parentItem.hasClass('has-children');

            // Если это тач-устройство и есть подменю
            if (isTouch && hasSubmenu) {
                if (!$parentItem.hasClass('active')) {
                    e.preventDefault();
                    // Закрываем другие открытые подменю того же уровня
                    $parentItem.siblings('.menu-item.active').removeClass('active');
                    $parentItem.addClass('active');
                    return;
                }
            }

            // Закрытие меню при клике на обычную ссылку (или второе нажатие на таче)
            if ($menu.hasClass('menu--open')) {
                $toggler.removeClass("active");
                $menu.removeClass("menu--open");
                $('body').removeClass('menu-lock');
            }
        }

        // Handle arrows logic (отдельно, если есть стрелочки)
        if ($target.closest('.menu__arrow').length) {
            const $parentItem = $target.closest('.menu__arrow').parent();
            if ($parentItem.hasClass('active')) {
                $parentItem.removeClass('active');
            } else {
                $parentItem.siblings('.menu-item.active').removeClass('active');
                $parentItem.addClass('active');
            }
            return;
        }

        // Close all submenus when clicking outside the menu
        if (!$target.closest('.menu-item').length) {
            $('.menu-item.active').removeClass('active');
        }


        // FAQ accordion
        if ($target.closest('.faq__question').length) {
            const $faqQuestion = $target.closest('.faq__question');
            const $item = $faqQuestion.closest('.faq__item');
            const $answer = $item.find('.faq__answer');

            $('.faq__answer').not($answer).slideUp().closest('.faq__item').removeClass('active');

            $item.toggleClass('active');
            $answer.slideToggle();
        }


        // Price List Tabs Switching
        const $priceTab = $target.closest('.price-list__tab');
        if ($priceTab.length && !$priceTab.hasClass('is-active')) {
            const targetId = $priceTab.data('target');
            const $panes = $('.price-list__pane');
            const $currentPane = $('#pane-' + targetId);

            $('.price-list__tab').removeClass('is-active');
            $priceTab.addClass('is-active');

            $panes.hide().removeClass('is-active');
            $currentPane.fadeIn(400).addClass('is-active');

            return;
        }


        // Show More Prices
        const $showMoreBtn = $target.closest('.js-price-show-more');
        if ($showMoreBtn.length) {
            const $btn = $showMoreBtn;
            const $table = $btn.closest('.price__table-wrapper').find('.js-price-table');
            const $hiddenRows = $table.find('tbody tr.is-hidden');

            if (!$btn.data('text-more')) {
                $btn.data('text-more', $btn.text());
            }

            if (!$btn.hasClass('is-active')) {
                $hiddenRows.fadeIn(400).css('display', 'table-row');
                $btn.text($btn.data('text-less')).addClass('is-active');
                $btn.parent().addClass('is-active');
            } else {
                $hiddenRows.hide();
                $btn.text($btn.data('text-more')).removeClass('is-active');
                $btn.parent().removeClass('is-active');

                $('html, body').animate({
                    scrollTop: $table.offset().top - 100
                }, 400);
            }
            return;
        }


        // Districts logic (Coverage section)
        const $districtCard = $target.closest('.district-card');
        if ($districtCard.length) {
            $('.district-card').removeClass('active');
            $districtCard.addClass('active');

            const name = $districtCard.attr('data-name');
            const desc = $districtCard.attr('data-desc');
            const time = $districtCard.attr('data-time');

            const content = `<strong>${name} район</strong> — ${desc} <span class="text-blue fw-700">Время выезда: ${time}</span>`;

            $('.district-card__details').each(function () {
                $(this).html(content);
            });

            return;
        }

        // equipment tabs
        const $equipmentTab = $target.closest('.equipment__tab');
        if ($equipmentTab.length && !$equipmentTab.hasClass('active')) {
            const filter = $equipmentTab.data('filter');
            const $slider = $('.equipment__slider');
            const swiper = $slider[0].swiper;

            $('.equipment__tab').removeClass('active');
            $equipmentTab.addClass('active');

            $('.equipment__card').each(function () {
                const itemCategory = $(this).data('category');
                if (itemCategory === filter) {
                    $(this).show().addClass('swiper-slide');
                } else {
                    $(this).hide().removeClass('swiper-slide');
                }
            });

            if (swiper) {
                swiper.update();
                swiper.slideTo(0);
            }

            return;
        }

        const $gorodaLetterBtn = $target.closest('.goroda-letter-filter');
        if ($gorodaLetterBtn.length && $gorodaLetterBtn.closest('.goroda-directory__filters').length) {
            e.preventDefault();
            const letterRaw = $gorodaLetterBtn.attr('data-letter') || 'all';
            const letter = letterRaw === 'all' ? 'all' : normalizeGorodaLetter(letterRaw);
            applyGorodaLetterFilter(letter);
            const url = new URL(window.location.href);
            if (letter === 'all') {
                url.searchParams.delete('letter');
            } else {
                url.searchParams.set('letter', letter);
            }
            const qs = url.searchParams.toString();
            window.history.pushState({}, '', url.pathname + (qs ? '?' + qs : ''));
            return;
        }

        // docs filters
        const $filterBtn = $target.closest('.docs-filter');
        if ($filterBtn.length) {
            const filter = $filterBtn.data('filter');
            const $gridItems = $('.certs__item');
            const $emptyMsg = $('.certs__empty');
            let visibleCount = 0;

            $('.filters__item').removeClass('active');
            $filterBtn.addClass('active');

            $gridItems.each(function () {
                const itemType = $(this).data('type');
                if (filter === 'all' || itemType === filter) {
                    $(this).css('display', 'flex').hide().fadeIn(300);
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleCount === 0) {
                $emptyMsg.fadeIn(300);
            } else {
                $emptyMsg.hide();
            }

            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + (filter === 'all' ? '' : '?type=' + filter);
            window.history.pushState({ path: newUrl }, '', newUrl);

            return;
        }

    });


    // init faq accordion
    const $faqItems = $('.faq__item');
    if ($faqItems.length) {
        $('.faq__item.active').find('.faq__answer').show();

        $(window).on('resize', () => {
            $('.faq__item.active').find('.faq__answer').slideDown()
        });
    }

    // sliders
    class MobileSwiper {
        constructor(sliderName, options, condition = 991.98) {
            this.$slider = $(sliderName);
            this.options = options;
            this.init = false;
            this.swiper = null;
            this.condition = condition;

            if (this.$slider.length) {
                this.handleResize();
                $(window).on("resize", () => this.handleResize());
            }
        }

        handleResize() {
            if (window.innerWidth <= this.condition) {
                if (!this.init) {
                    this.init = true;
                    this.swiper = new Swiper(this.$slider[0], this.options);
                }
            } else if (this.init) {
                this.swiper.destroy();
                this.swiper = null;
                this.init = false;
            }
        }
    }

    if ($('.team__slider').length) {
        new MobileSwiper('.team__slider', {
            slidesPerView: 3,
            spaceBetween: 8,
            pagination: {
                el: '.team__slider-pagination',
                clickable: true
            }
        })
    }

    if ($('.trust__slider').length) {
        new MobileSwiper('.trust__slider', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            watchOverflow: true,
            loop: true,
            autoplay: {
                delay: 5000,
                stopOnLastSlide: false
            },
            pagination: {
                el: '.trust__slider-pagination',
                clickable: true,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                }
            }
        })
    }

    if ($('.documents-slider').length) {
        new MobileSwiper('.documents-slider', {
            slidesPerView: 'auto',
            spaceBetween: 30,
        })
    }

    if ($('.equipment__slider').length) {
        new Swiper('.equipment__slider', {
            slidesPerView: 1.1,
            spaceBetween: 16,
            watchOverflow: true,
            pagination: {
                el: '.equipment__slider-pagination',
                clickable: true
            },
            breakpoints: {
                575.98: {
                    slidesPerView: 1.5,
                    spaceBetween: 30,
                },
                767.98: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1199.98: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1439.98: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        })
    }

    if ($('.process__slider').length) {
        new Swiper('.process__slider', {
            slidesPerView: "auto",
            spaceBetween: 30,
            watchOverflow: true,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 5000,
                stopOnLastSlide: false
            },
            navigation: {
                prevEl: '.process__prev',
                nextEl: '.process__next'
            },
            pagination: {
                el: '.process__slider-pagination',
                clickable: true
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 60,
                }
            }
        })

    }

    if ($('.reviews__slider').length) {
        new Swiper('.reviews__slider', {
            slidesPerView: 1.1,
            spaceBetween: 16,
            watchOverflow: true,
            loop: true,
            navigation: {
                prevEl: '.reviews__prev',
                nextEl: '.reviews__next'
            },
            pagination: {
                el: '.reviews__slider-pagination',
                clickable: true
            },
            breakpoints: {
                767.98: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1199.98: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        })

    }

    if ($('.filters').length) {
        const $this = $(this);
        const activeIndex = $this.find('.filters.active').index();

        new MobileSwiper('.filters', {
            slidesPerView: "auto",
            spaceBetween: 12,
            initialSlide: activeIndex >= 0 ? activeIndex : 0
        })
    }

    // Phone Input Mask Russia

    const $phoneInputs = $('input[type="tel"]');

    const getInputNumbersValue = (input) => {
        return input.value.replace(/\D/g, '');
    };

    const onPhoneInput = function (e) {
        let input = e.target,
            inputNumbersValue = getInputNumbersValue(input),
            selectionStart = input.selectionStart,
            formattedInputValue = "";

        if (!inputNumbersValue) {
            return input.value = "";
        }

        if (input.value.length != selectionStart) {
            if (e.originalEvent.data && /\D/g.test(e.originalEvent.data)) {
                input.value = inputNumbersValue;
            }
            return;
        }

        if (["7", "8", "9"].indexOf(inputNumbersValue[0]) > -1) {
            if (inputNumbersValue[0] == "9") inputNumbersValue = "7" + inputNumbersValue;
            let firstSymbols = (inputNumbersValue[0] == "8") ? "8" : "+7";
            formattedInputValue = firstSymbols + " ";

            if (inputNumbersValue.length > 1) {
                formattedInputValue += '(' + inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ') ' + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += '-' + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += '-' + inputNumbersValue.substring(9, 11);
            }
        } else {
            formattedInputValue = '+' + inputNumbersValue.substring(0, 16);
        }
        input.value = formattedInputValue;
    };

    const onPhoneKeyDown = function (e) {
        let inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    };

    const onPhonePaste = function (e) {
        let input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        let pasted = e.originalEvent.clipboardData || window.clipboardData;
        if (pasted) {
            let pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                input.value = inputNumbersValue;
            }
        }
    };

    $phoneInputs
        .on('keydown', onPhoneKeyDown)
        .on('input', onPhoneInput)
        .on('paste', onPhonePaste);


    function getSuccessSubmitting() {
        Fancybox.close();
        Fancybox.show([{
            src: "#success-submitting",
            type: "inline"
        }]);
    }

    function getErrorSubmitting() {
        Fancybox.close();
        Fancybox.show([{
            src: "#error-submitting",
            type: "inline"
        }]);
    }

    document.addEventListener('wpcf7mailsent', function () {
        getSuccessSubmitting()
    }, false);

    document.addEventListener('wpcf7mailfailed', function () {
        getErrorSubmitting()
    }, false);


    function initYandexMap() {
        const $mapContainer = $('#yandex-map');
        if (!$mapContainer.length) return;

        let myMap, myPlacemark;

        const syncOffset = () => {
            const $card = $('.baloon__card');
            if (!$card.length || !myPlacemark) return;

            const w = $card.outerWidth();
            const h = $card.outerHeight();
            const gap = window.innerWidth <= 768 ? 8 : 10;

            myPlacemark.options.set('balloonOffset', [
                -Math.round(w / 2),
                -Math.round(h + gap)
            ]);
        };

        const init = () => {
            const rawCoords = $mapContainer.data('coords');
            const centerCoords = rawCoords ? rawCoords.split(',').map(Number) : [59.957545, 30.412431];
            const balloonHtml = $('#map-balloon-template').html();

            myMap = new ymaps.Map('yandex-map', {
                center: centerCoords,
                zoom: 17,
                controls: ['zoomControl']
            });

            myMap.behaviors.disable('scrollZoom');

            const MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                `<div class="map-balloon-wrapper">${balloonHtml}</div>`
            );

            myPlacemark = new ymaps.Placemark(centerCoords, {}, {
                balloonLayout: MyBalloonLayout,
                balloonCloseButton: false,
                balloonPanelMaxMapArea: 0,
                hideIconOnBalloonOpen: false,
                balloonOffset: [0, 0]
            });

            myPlacemark.events.add('balloonopen', () => {
                requestAnimationFrame(() => {
                    requestAnimationFrame(syncOffset);
                });
                setTimeout(syncOffset, 120);
            });

            myMap.geoObjects.add(myPlacemark);
            myPlacemark.balloon.open();

            $(window).on('resize', () => {
                clearTimeout(window.mapResizeTimer);
                window.mapResizeTimer = setTimeout(() => {
                    if (myPlacemark && myPlacemark.balloon.isOpen()) {
                        syncOffset();
                    }
                }, 150);
            });
        };

        const loadScript = () => {
            if (typeof ymaps !== 'undefined') return;

            const script = document.createElement('script');
            script.src = 'https://api-maps.yandex.ru/2.1/?apikey=496cd84c-0a7a-4b7e-a9d5-bd9261e5f0a6&lang=ru_RU';
            script.type = 'text/javascript';
            script.onload = () => {
                ymaps.ready(init);
            };
            document.head.appendChild(script);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadScript();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '200px'
        });

        observer.observe($mapContainer[0]);
    }

    initYandexMap();

    // before slider
    const $sliders = $('.before-slider');

    if ($sliders.length) {
        $sliders.each(function () {
            const $currentSlider = $(this);
            let isDragging = false;

            $currentSlider.on('mousemove', function (e) {
                updateSliderPosition(e, $currentSlider);
            });

            $currentSlider.on('touchstart', function (e) {
                isDragging = true;
                updateSliderPosition(e, $currentSlider);
            });

            $(document).on('touchend', function () {
                isDragging = false;
            });

            $(document).on('touchmove', function (e) {
                if (isDragging) {
                    updateSliderPosition(e, $currentSlider);
                }
            });

            function updateSliderPosition(e, $element) {
                let clientX;

                if (e.type.includes('touch')) {
                    clientX = e.originalEvent.touches[0].clientX;
                } else {
                    clientX = e.clientX;
                }

                const rect = $element[0].getBoundingClientRect();
                const position = clientX - rect.left;
                const percent = Math.max(0, Math.min((position / rect.width) * 100, 100));

                $element.css('--position', percent + '%');
            }
        });
    }

})
