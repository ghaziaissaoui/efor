import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Navigation } from 'swiper';

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
  slider: '.direction-slider',
  sliderWrapper: '.swiper-wrapper',
  sliderSlide: '.swiper-slide',
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class DirectionSliderComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);

    const trigger = document.querySelectorAll(SELECTORS.slider);

    trigger.forEach(item => {
      if (item) {
        new Swiper(item, {
          modules: [Navigation],
          breakpoints: {
            0: {
              slidesPerView: 1.2,
              spaceBetween: 24,
              loop: true,
            },
            720: {
              loop: true,
              loopedSlides: 4.2,
              loopAdditionalSlides: 200,
              centeredSlides: false ,
              centeredSlidesBounds: false,
              shortSwipes: true,
              slideToClickedSlide: true,
              preventClicksPropagation: false,
              preventClicks: false,
              slidesPerView: '4.3',
              spaceBetween: 40,
            },
          },
          navigation: {
            nextEl: '.direction-arrow-next',
            prevEl: '.direction-arrow-prev',
          }
        });
      }
    });
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

window.customElements.define('direction-slider-component', DirectionSliderComponent);

export default DirectionSliderComponent;
