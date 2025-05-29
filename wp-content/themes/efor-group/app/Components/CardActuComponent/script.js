import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Navigation, Pagination,  Autoplay } from 'swiper';
Swiper.use([Navigation, Pagination, Autoplay]);

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

const SELECTORS = {
  slider: '.card-actu-list__slider',
};

const M_CLASSES = {};

/*
 • Component Class
 ---------- ---------- ---------- ---------- ----------
 */

class CardActuComponent extends CEComponent {

  constructor() {
    super()
  }

  static get observedAttributes() {
    return ['data'];
  }

  connectedCallback() {
    console.log('Connected:', this);
    const mdBreakpoint = window.matchMedia('(max-width: 720px)');

    if (mdBreakpoint.matches && this.querySelector(SELECTORS.slider)) {
      new Swiper(SELECTORS.slider, {
        loop: true,
        autoplay: false,
        slidesPerView: 1,
        allowTouchMove: true,
        simulateTouch: true,
      });
    }
  }

  disconnectedCallback() {
    console.log('Disconnected:', this);
  }

  adoptedCallback() {
    console.log('Adopted:', this);
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue && oldValue !== newValue) {
      console.log('Attribute Changed:', name, oldValue, newValue);
    }
  }
}

/*
 • Private Functions
 ---------- ---------- ---------- ---------- ----------
 */

/*
 • Event Handlers
 ---------- ---------- ---------- ---------- ----------
 */

/*
 • Init and Exports
 ---------- ---------- ---------- ---------- ----------
 */

window.customElements.define('card-actu-component', CardActuComponent);

export default CardActuComponent;
