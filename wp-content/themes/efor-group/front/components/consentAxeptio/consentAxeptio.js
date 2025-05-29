export function loadAxeptio() {
  (window._axcb || []).push(function(sdk) {
    sdk.on('cookies:complete', function(choices){
      checkIframe(choices);
    });
  });
}

function checkIframe(choices) {
  document
    .querySelectorAll('[data-hide-on-vendor-consent]')
    .forEach(el => {
      const vendor = el.getAttribute('data-hide-on-vendor-consent');
      el.style.display = choices[vendor] ? 'none' : 'inherit';
    });
  document
    .querySelectorAll('[data-requires-vendor-consent]')
    .forEach(el => {
      const vendor = el.getAttribute('data-requires-vendor-consent');
      if (choices[vendor]) {
        el.setAttribute('src', el.getAttribute('data-src'));
        el.classList.remove('u-hidden');
      } else {
        el.classList.add('u-hidden')
        el.setAttribute('src', '');
      }
    });
}
