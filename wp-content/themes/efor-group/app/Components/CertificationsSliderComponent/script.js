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
  certifSlider: '.certif-slider',
  interventionSlider: '.interventions-slider',
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class CertificationsSliderComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    let trigger = document.querySelectorAll(SELECTORS.certifSlider);
    initializeSlider(trigger);

    trigger = document.querySelectorAll(SELECTORS.interventionSlider);
    initializeSlider(trigger);
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

function initializeSlider(sliders)
{
  sliders.forEach(item => {
    if (item && false === item.classList.contains('initialized')) {
      const hasImage = item.classList.contains('certif-slider');
      let slidesPerView;

      if (false === hasImage) {
        slidesPerView = [1.2, 2.1];
      } else {
        slidesPerView = [1.2, 1.09];
      }

      new Swiper(item, {
        loop: true,
        autoplay: false,
        slidesPerView: 1,
        allowTouchMove: true,
        simulateTouch: true,
        breakpoints: {
          0: {
            slidesPerView: slidesPerView[0],
          },
          1000: {
            slidesPerView: slidesPerView[1],
          },
        },
        navigation: {
          nextEl: '.arrow-next',
          prevEl: '.arrow-prev',
        },
      });

      item.classList.add('initialized');
    }
  });
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('certifications-slider-component', CertificationsSliderComponent);

export default CertificationsSliderComponent;
