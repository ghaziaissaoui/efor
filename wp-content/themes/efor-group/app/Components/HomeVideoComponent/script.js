import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import api from '../../../front/abstract/grid-system/grid-system';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Config
  • Component Class
  • Private Functions
  • Event Handlers
  • Init and Exports
*/

/*
  • Config
  ---------- ---------- ---------- ---------- ----------
*/


/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class HomeVideoComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    onInit.call(this)

    api.on('leavemedium', () => {
      onServeVideoByScreen.call(this, 'mobile')
    })

    api.on('entermedium', () => {
      onServeVideoByScreen.call(this, 'desktop')
    })
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function onInit() {
  if (window.matchMedia('screen and (max-width: 560px)').matches) {
    onServeVideoByScreen.call(this, 'mobile')
  } else {
    onServeVideoByScreen.call(this, 'desktop')
  }
  var observer = new IntersectionObserver(function(entries) {
    // isIntersecting is true when element and viewport are overlapping
    // isIntersecting is false when element and viewport don't overlap
    if(entries[0].isIntersecting) {
      document.body.classList.add('home-hero')
    } else {
      document.body.classList.remove('home-hero')
    }
  }, { threshold: 0, rootMargin: '-126px', });

  observer.observe(document.querySelector('home-video-component'));
}

function onServeVideoByScreen(device) {
  const sources = JSON.parse(this.getAttribute('data-src'))
  if (device === 'mobile') {
    this.classList.remove('ratio-block--16/9')
    this.classList.add('ratio-block--9/16')
    this.querySelector('video').setAttribute('src', sources.mobile)
  } else {
    this.classList.remove('ratio-block--9/16')
    this.classList.add('ratio-block--16/9')
    this.querySelector('video').setAttribute('src', sources.desktop)

  }
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('home-video-component', HomeVideoComponent);

export default HomeVideoComponent;
