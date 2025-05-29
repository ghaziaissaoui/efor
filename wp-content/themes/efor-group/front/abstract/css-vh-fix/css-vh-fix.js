const CLASS_NAME = 'css-vh-fix';
const SELECTOR = `.${CLASS_NAME}`;

function cssVhFix () {
  const vh = document.querySelector(SELECTOR).offsetHeight;

  document.documentElement.style.setProperty('--vh', `${vh / 100}px`);
  document.documentElement.style.setProperty('--full-vh', `${vh}px`);

  if(window.scrollY === 0) {
    document.documentElement.style.setProperty('--vh-min', `${vh / 100}px`);
    document.documentElement.style.setProperty('--full-vh-min', `${vh}px`);
  }
}

if(!document.querySelector(SELECTOR)) {
  const elmt = document.createElement('div');
  elmt.className = CLASS_NAME;
  document.body.appendChild(elmt);

  document.documentElement.style.setProperty('--vh-min', 'var(--vh)');
  document.documentElement.style.setProperty('--full-vh-min', 'var(--full-vh)');
}

window.addEventListener('resize', cssVhFix);

export { cssVhFix };
