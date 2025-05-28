function acceptCookies() {
    const preferences = {
        accepted: true,
        performanceCookies: true,
        marketingCookies: true
    };
    localStorage.setItem("cookiePreferences", JSON.stringify(preferences));
    closeAllModals();
    loadMarketingScripts(); // Carrega GA se aceitou tudo
}

function openSettings() {
    document.getElementById('cookieBackdrop').style.display = 'none';
    document.getElementById('cookieSettingsModal').style.display = 'flex';
}

function closeSettings() {
    document.getElementById('cookieSettingsModal').style.display = 'none';
    document.getElementById('cookieBackdrop').style.display = 'flex';
}

function saveSettings() {
    const performance = document.getElementById('performanceCookies').checked;
    const marketing = document.getElementById('marketingCookies').checked;

    const preferences = {
        accepted: true,
        performanceCookies: performance,
        marketingCookies: marketing
    };

    localStorage.setItem("cookiePreferences", JSON.stringify(preferences));
    closeAllModals();
    console.log("Preferences saved:", preferences);

    if (marketing) {
        loadMarketingScripts(); // Só carrega se marcar marketing
    }
}

function closeAllModals() {
    document.getElementById("cookieBackdrop").style.display = "none";
    document.getElementById("cookieSettingsModal").style.display = "none";
}

// ⚙️ Carrega Google Analytics se necessário
function loadMarketingScripts() {
    const gaScript = document.createElement("script");
    gaScript.setAttribute("async", "");
    gaScript.src = "https://www.googletagmanager.com/gtag/js?id=G-LXV08QY9E5";
    document.head.appendChild(gaScript);

    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }

    gtag("js", new Date());
    gtag("config", "G-LXV08QY9E5");
}

// Executa quando a página carrega
window.onload = function () {
    const saved = localStorage.getItem("cookiePreferences");
    if (saved) {
        const prefs = JSON.parse(saved);
        if (prefs.accepted) {
            closeAllModals();
            if (prefs.marketingCookies) {
                loadMarketingScripts();
            }
        }
    } else {
        document.getElementById("cookieBackdrop").style.display = "flex";
    }
};
// Facebook
function loadFacebookPixel() {
    !function(f,b,e,v,n,t,s) {
        if(f.fbq)return; n=f.fbq=function(){n.callMethod ?
            n.callMethod.apply(n,arguments) : n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;
        n.push=n; n.loaded=!0; n.version='2.0';
        n.queue=[]; t=b.createElement(e); t.async=!0;
        t.src=v; s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s);
    }(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', 'SEU_PIXEL_ID'); // ⬅️ Substitua aqui
    fbq('track', 'PageView');
}

// TikTok
function loadTikTokPixel() {
    !function (w, d, t) {
        w.TiktokAnalyticsObject = t;
        var ttq = w[t] = w[t] || [];
        ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias", "group", "enableCookie"];
        ttq.setAndDefer = function (t, e) {
            t[e] = function () {
                t.push([e].concat(Array.prototype.slice.call(arguments, 0)));
            };
        };
        for (var i = 0; i < ttq.methods.length; i++) {
            ttq.setAndDefer(ttq, ttq.methods[i]);
        }
        ttq.load = function (e, n) {
            var i = "https://analytics.tiktok.com/i18n/pixel/events.js";
            ttq._i = ttq._i || [];
            ttq._i.push([e, n]);
            var a = document.createElement("script");
            a.type = "text/javascript";
            a.async = true;
            a.src = i;
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(a, s);
        };
        ttq.load('SEU_PIXEL_ID'); // ⬅️ Substitua aqui
        ttq.page();
    }(window, document, 'ttq');
}
//hotjar
function loadHotjar() {
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:SEU_ID_HOTJAR, hjsv:6}; // ⬅️ Substitua aqui
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script'); r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
}
