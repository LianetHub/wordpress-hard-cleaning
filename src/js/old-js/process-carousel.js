/**
 * Секция «Процесс» — лента с клонами, бесконечная прокрутка в обе стороны.
 * Разметка: [prepend][оригиналы][append], стартовый scroll ≈ первый оригинал — можно листать влево с «начала».
 * Симметричный обрез (не десктоп): --process-peek + подстройка scrollOffset после layout.
 * Стрелки: плавный scroll (кроме prefers-reduced-motion).
 */
(function () {
    "use strict";

    function processGapPx() {
        var w = window.innerWidth || document.documentElement.clientWidth;
        return Math.round(Math.max(20, Math.min(60, (w * 60) / 1920)));
    }

    function prefersReducedMotion() {
        try {
            return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        } catch (e) {
            return false;
        }
    }

    function supportsScrollEnd(el) {
        return "onscrollend" in el;
    }

    /** Десктоп/планшетный режим карусели (выше мобильного брейкпоинта 768px). */
    function isDesktopProcess() {
        try {
            return window.matchMedia("(min-width: 769px)").matches;
        } catch (e) {
            return (window.innerWidth || document.documentElement.clientWidth || 0) >= 769;
        }
    }

    function initProcessCarousel() {
        var track = document.querySelector("#process-track");
        var inner = document.querySelector("#process-carousel-inner");
        if (!track || !inner) return;

        var prevBtn = document.querySelector(".process-section-new .process-nav-prev");
        var nextBtn = document.querySelector(".process-section-new .process-nav-next");

        var originals = [];
        var targets = [];
        var cycleLen = 0;
        var scrollLow = 0;
        var scrollOffset = 0;
        var navBusy = false;
        var scrollEndTimer;
        var n = 0;

        function isMobileSimpleMode() {
            try {
                return window.matchMedia("(max-width: 768px)").matches;
            } catch (e) {
                return (window.innerWidth || document.documentElement.clientWidth || 0) <= 768;
            }
        }

        var modeIsMobile = isMobileSimpleMode();

        if (isMobileSimpleMode()) {
            var mobileSlides = Array.prototype.slice.call(inner.children).filter(function (el) {
                return el.classList.contains("p-step-slide");
            });
            if (!mobileSlides.length) return;

            var indicatorWrap = document.querySelector("#process-mobile-indicator");
            var indicatorDots = indicatorWrap
                ? Array.prototype.slice.call(indicatorWrap.querySelectorAll(".process-mobile-indicator__dot"))
                : [];

            var current = 0;
            var touchStartX = 0;
            var touchEndX = 0;

            function syncMobileIndicator() {
                if (!indicatorDots.length) return;
                indicatorDots.forEach(function (dot, i) {
                    dot.classList.toggle("is-active", i === current);
                });
            }

            function showMobileSlide(idx) {
                if (!mobileSlides.length) return;
                if (idx < 0) idx = mobileSlides.length - 1;
                if (idx >= mobileSlides.length) idx = 0;
                current = idx;
                mobileSlides.forEach(function (slide, i) {
                    slide.classList.toggle("is-active", i === current);
                });
                syncMobileIndicator();
            }

            if (prevBtn) {
                prevBtn.addEventListener("click", function () {
                    showMobileSlide(current - 1);
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener("click", function () {
                    showMobileSlide(current + 1);
                });
            }

            track.addEventListener(
                "touchstart",
                function (event) {
                    if (!event.touches || !event.touches.length) return;
                    touchStartX = event.touches[0].clientX;
                },
                { passive: true }
            );

            track.addEventListener(
                "touchend",
                function (event) {
                    if (!event.changedTouches || !event.changedTouches.length) return;
                    touchEndX = event.changedTouches[0].clientX;
                    var delta = touchEndX - touchStartX;
                    if (Math.abs(delta) < 40) return;
                    if (delta < 0) {
                        showMobileSlide(current + 1);
                    } else {
                        showMobileSlide(current - 1);
                    }
                },
                { passive: true }
            );

            var mobileResizeTimer;
            window.addEventListener(
                "resize",
                function () {
                    clearTimeout(mobileResizeTimer);
                    mobileResizeTimer = setTimeout(function () {
                        var nowMobile = isMobileSimpleMode();
                        if (nowMobile !== modeIsMobile) {
                            window.location.reload();
                        }
                    }, 120);
                },
                { passive: true }
            );

            showMobileSlide(0);
            return;
        }

        function removeClones() {
            Array.prototype.forEach.call(inner.querySelectorAll(".p-step-slide--clone"), function (node) {
                node.remove();
            });
        }

        function collectOriginals() {
            originals = Array.prototype.slice
                .call(inner.children)
                .filter(function (el) {
                    return el.classList.contains("p-step-slide") && !el.classList.contains("p-step-slide--clone");
                });
            n = originals.length;
        }

        function appendClones() {
            removeClones();
            collectOriginals();
            /* [prepend копия ряда][оригиналы][append копия] — чтобы с первого экрана можно было листать влево (scrollLeft > 0). */
            var fragPre = document.createDocumentFragment();
            originals.forEach(function (slide) {
                var c = slide.cloneNode(true);
                c.classList.add("p-step-slide--clone", "p-step-slide--clone-prepend");
                c.setAttribute("aria-hidden", "true");
                fragPre.appendChild(c);
            });
            inner.insertBefore(fragPre, inner.firstChild);

            originals.forEach(function (slide) {
                var c = slide.cloneNode(true);
                c.classList.add("p-step-slide--clone", "p-step-slide--clone-append");
                c.setAttribute("aria-hidden", "true");
                inner.appendChild(c);
            });
        }

        function measure() {
            collectOriginals();
            var cloneAppend0 = inner.querySelector(".p-step-slide--clone-append");
            if (!originals.length || !cloneAppend0) return;

            var first = originals[0];
            var peek = isDesktopProcess() ? 0 : Math.max(0, Math.round(first.offsetWidth / 2));
            inner.style.setProperty("--process-peek", peek + "px");
            void inner.offsetHeight;

            targets = originals.map(function (s) {
                return Math.round(s.offsetLeft);
            });
            cycleLen = Math.round(cloneAppend0.offsetLeft - originals[0].offsetLeft);
            scrollOffset = 0;
        }

        /** Однократно: сравниваем видимые «половинки» первой и последней карточки у краёв вьюпорта и сдвигаем scroll. */
        function balancePeekOnce() {
            if (!originals.length || !targets.length) return;

            track.scrollLeft = targets[0];
            void track.offsetHeight;

            /* Десктоп: без «половинок» у края — только padding трека, левый и правый отступ от вьюпорта совпадают. */
            if (isDesktopProcess()) {
                scrollOffset = track.scrollLeft - targets[0];
                scrollLow = track.scrollLeft;
                return;
            }

            var tr = track.getBoundingClientRect();
            var cs = window.getComputedStyle(track);
            var pl = parseFloat(cs.paddingLeft) || 0;
            var pr = parseFloat(cs.paddingRight) || 0;
            var viewL = tr.left + pl;
            var viewR = tr.right - pr;

            var first = originals[0];
            var last = originals[n - 1];
            var fr = first.getBoundingClientRect();
            var lr = last.getBoundingClientRect();
            var wantL = first.offsetWidth / 2;
            var wantR = last.offsetWidth / 2;

            var visL = Math.min(fr.right, viewR) - Math.max(fr.left, viewL);
            var visR = Math.min(lr.right, viewR) - Math.max(lr.left, viewL);

            /* Положительный adj — сдвиг вправо (увеличить scrollLeft), если обрез слева глубже желаемого */
            var errL = wantL - visL;
            var errR = wantR - visR;
            var adj = Math.round((errL + errR) / 2);
            var lim = Math.max(24, Math.round(first.offsetWidth / 2) || 40);
            adj = Math.max(-lim, Math.min(lim, adj));

            var raw = Math.round(targets[0] + adj);
            track.scrollLeft = Math.max(0, raw);
            scrollOffset = track.scrollLeft - targets[0];
            scrollLow = track.scrollLeft;
        }

        function targetX(i) {
            return Math.round(targets[i] + scrollOffset);
        }

        function normalize() {
            if (!cycleLen || cycleLen < 4) return;
            var s = track.scrollLeft;
            var hi = scrollLow + cycleLen;
            if (s >= hi - 1) {
                track.scrollLeft = Math.round(s - cycleLen);
            } else if (s < scrollLow - 1) {
                track.scrollLeft = Math.round(s + cycleLen);
            }
        }

        function releaseNav() {
            navBusy = false;
        }

        function onScrollSettled() {
            normalize();
            releaseNav();
        }

        function bindScrollEnd() {
            if (supportsScrollEnd(track)) {
                track.addEventListener("scrollend", onScrollSettled, { passive: true });
            } else {
                track.addEventListener(
                    "scroll",
                    function () {
                        clearTimeout(scrollEndTimer);
                        scrollEndTimer = setTimeout(onScrollSettled, 120);
                    },
                    { passive: true }
                );
            }
        }

        function nearestIndex() {
            normalize();
            var s = track.scrollLeft;
            var best = 0;
            var bd = 1e9;
            var i;
            for (i = 0; i < n; i++) {
                var d = Math.abs(s - targetX(i));
                if (d < bd) {
                    bd = d;
                    best = i;
                }
            }
            return best;
        }

        function goTo(left) {
            var smooth = !prefersReducedMotion();
            track.scrollTo({ left: Math.round(left), top: 0, behavior: smooth ? "smooth" : "auto" });
            if (!smooth) {
                onScrollSettled();
            }
        }

        function goNext() {
            if (n < 2 || !cycleLen || !targets.length) return;
            navBusy = true;
            var idx = nearestIndex();
            var left;
            if (idx === n - 1) {
                left = targetX(0) + cycleLen;
            } else {
                left = targetX(idx + 1);
            }
            goTo(left);
        }

        function goPrev() {
            if (n < 2 || !cycleLen || !targets.length) return;
            navBusy = true;
            var idx = nearestIndex();
            var left;
            /* [prepend][O…O][append]: с первого шага назад — в зону prepend (эквивалент последнего слайда), симметрично goNext на последнем. */
            if (idx === 0) {
                left = targetX(n - 1) - cycleLen;
            } else {
                left = targetX(idx - 1);
            }
            goTo(left);
        }

        function layout() {
            inner.style.setProperty("--process-carousel-gap", processGapPx() + "px");
            appendClones();
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    measure();
                    if (targets.length) {
                        balancePeekOnce();
                    }
                    normalize();
                    releaseNav();
                });
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener("click", function () {
                if (navBusy) return;
                goPrev();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener("click", function () {
                if (navBusy) return;
                goNext();
            });
        }

        bindScrollEnd();

        var resizeTimer;
        window.addEventListener(
            "resize",
            function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    var nowMobile = isMobileSimpleMode();
                    if (nowMobile !== modeIsMobile) {
                        window.location.reload();
                        return;
                    }
                    layout();
                }, 150);
            },
            { passive: true }
        );

        collectOriginals();
        if (originals.length < 2) return;
        layout();
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initProcessCarousel);
    } else {
        initProcessCarousel();
    }
})();
