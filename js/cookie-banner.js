/**
 * Mon Webmaster à Bordeaux — Scripts utilitaires & Bandeau RGPD
 */

document.addEventListener('DOMContentLoaded', function () {
  // --- Gestion du bandeau Cookies / Confidentialité ---
  var banner = document.getElementById('cookie-banner');
  var acceptBtn = document.getElementById('cookie-accept');

  if (banner && acceptBtn) {
    if (localStorage.getItem('cookies_ok') === 'true') {
      banner.classList.add('hidden');
    } else {
      banner.classList.remove('hidden');
    }

    acceptBtn.addEventListener('click', function () {
      localStorage.setItem('cookies_ok', 'true');
      banner.classList.add('hidden');
    });
  }

  // --- Gestion du menu mobile ---
  var navToggle = document.getElementById('nav-toggle');
  var mobileMenu = document.getElementById('mobile-menu');

  if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', function () {
      var isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', !isExpanded);
      mobileMenu.classList.toggle('is-open');
      document.body.style.overflow = !isExpanded ? 'hidden' : '';
    });

    // Fermeture du menu mobile au clic sur un lien
    var mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        navToggle.setAttribute('aria-expanded', 'false');
        mobileMenu.classList.remove('is-open');
        document.body.style.overflow = '';
      });
    });
  }
});
