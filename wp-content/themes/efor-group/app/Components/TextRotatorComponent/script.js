import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Autoplay } from 'swiper';
Swiper.use([Autoplay]);

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
  slider: '.textRotator', 
};

/*
 • Component Class
 ---------- ---------- ---------- ---------- ----------
 */

class TextRotatorComponent extends CEComponent {
  constructor() {
    super();
  }

  connectedCallback() {
    new Swiper(SELECTORS.slider, {
      direction: 'vertical',
      loop: true,
      autoHeight: true,
      simulateTouch:false,
      allowTouchMove: false,
      speed: 1100,
      autoplay: {
        delay: 4200,
        disableOnInteraction: false,
      },
    });
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

window.customElements.define('text-rotator-component', TextRotatorComponent);

export default TextRotatorComponent;
