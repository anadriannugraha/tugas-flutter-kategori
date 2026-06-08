/**
 * Device detection — adds body classes for responsive CSS & JS
 * Classes: device-mobile | device-tablet | device-desktop | touch-device
 */
(function () {
    const BREAKPOINTS = { mobile: 768, tablet: 1024 };

    function getType() {
        const w = window.innerWidth;
        if (w < BREAKPOINTS.mobile) return 'mobile';
        if (w < BREAKPOINTS.tablet) return 'tablet';
        return 'desktop';
    }

    function update() {
        const type = getType();
        const body = document.body;
        body.classList.remove('device-mobile', 'device-tablet', 'device-desktop');
        body.classList.add('device-' + type);

        if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
            body.classList.add('touch-device');
        }
    }

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(update, 120);
    });
    window.addEventListener('orientationchange', update);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', update);
    } else {
        update();
    }

    window.gzDevice = {
        get type() {
            return getType();
        },
        isMobile: function () {
            return getType() === 'mobile';
        },
        isTablet: function () {
            return getType() === 'tablet';
        },
        isDesktop: function () {
            return getType() === 'desktop';
        },
        onChange: function (callback) {
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    callback(getType());
                }, 120);
            });
        }
    };
})();
