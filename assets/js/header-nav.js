(function () {
    'use strict';

    /* ≤768px — выездное меню. >768px — горизонтальное меню; при переполнении строки — бургер.
       Переполнение меряем только пока меню в потоке (без класса collapsed), иначе clientWidth баллонится. */

    function debounce(fn, ms) {
        var t;
        return function () {
            clearTimeout(t);
            var args = arguments;
            t = setTimeout(function () {
                fn.apply(null, args);
            }, ms);
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        var header = document.querySelector('.main-header');
        var burger = document.querySelector('.header-burger');
        var nav = document.getElementById('site-navigation');
        var navClose = nav ? nav.querySelector('.nav-drawer-close') : null;
        var backdrop = document.getElementById('nav-drawer-backdrop');
        if (!burger || !nav || !header) {
            return;
        }

        var navList = nav.querySelector('.nav-list');
        var headerContent = header.querySelector('.header-content');
        if (!navList) {
            return;
        }

        var mqMobile = window.matchMedia('(max-width: 768px)');

        function setBackdropVisible(show) {
            if (!backdrop) {
                return;
            }
            backdrop.classList.toggle('is-active', show);
            backdrop.setAttribute('aria-hidden', show ? 'false' : 'true');
        }

        function setOpen(open) {
            nav.classList.toggle('is-open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.setAttribute('aria-label', open ? 'Закрыть меню' : 'Открыть меню');
            document.body.classList.toggle('nav-drawer-open', open);
            setBackdropVisible(open);
        }

        function updateNavCollapse() {
            if (mqMobile.matches) {
                header.classList.remove('main-header--nav-collapsed');
                return;
            }

            var wasOpen = nav.classList.contains('is-open');
            header.classList.remove('main-header--nav-collapsed');
            void header.offsetHeight;

            var needsBurger = navList.scrollWidth > nav.clientWidth + 2;

            if (needsBurger) {
                header.classList.add('main-header--nav-collapsed');
            } else if (wasOpen) {
                setOpen(false);
            }
        }

        var scheduleUpdate = debounce(updateNavCollapse, 80);

        updateNavCollapse();
        window.addEventListener('resize', scheduleUpdate);
        if (typeof ResizeObserver !== 'undefined' && headerContent) {
            new ResizeObserver(scheduleUpdate).observe(headerContent);
        }
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(scheduleUpdate);
        }
        if (mqMobile.addEventListener) {
            mqMobile.addEventListener('change', scheduleUpdate);
        } else if (mqMobile.addListener) {
            mqMobile.addListener(scheduleUpdate);
        }

        burger.addEventListener('click', function (e) {
            e.stopPropagation();
            setOpen(!nav.classList.contains('is-open'));
        });

        if (navClose) {
            navClose.addEventListener('click', function () {
                setOpen(false);
                burger.focus();
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', function () {
                setOpen(false);
                burger.focus();
            });
        }

        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                setOpen(false);
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                setOpen(false);
                burger.focus();
            }
        });
    });
})();
