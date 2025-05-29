import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Navigation, Pagination } from 'swiper';

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
  slider: '.carousel-slider',
  sliderItem: '.carousel-slider .swiper-slide',
  sliderItemImg: '.carousel-slider .swiper-slide img',
  sliderArrowPrev: '.carousel-arrow-prev',
  sliderArrowNext: '.carousel-arrow-next',
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class CarouselComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    const arrowPrevList = this.querySelector(SELECTORS.sliderArrowPrev)
    const arrowNexttList = this.querySelector(SELECTORS.sliderArrowNext)
    const sliderImgList = this.querySelectorAll(SELECTORS.sliderItemImg)
    const trigger = document.querySelectorAll(SELECTORS.slider);

    trigger.forEach(item => {
      if (item) {
        const carousel = new Swiper(item, {
          modules: [Navigation, Pagination],
          loop: true,
          allowTouchMove: true,
          simulateTouch: true,
          navigation: {
            nextEl: '.carousel-arrow-next',
            prevEl: '.carousel-arrow-prev',
          },
          pagination: {
            el: '.carousel-swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
              return '<div class="ratio-block ratio-block--1/1 ' + className + '"><img src="' + sliderImgList[index].src + '" alt="" class="ratio-block__content"></div>';
            },
          }
        });

        arrowNexttList.addEventListener('click', function (e) {
          e.preventDefault()
          carousel.slideNext()
        });

        arrowPrevList.addEventListener('click', function (e) {
          e.preventDefault()
          carousel.slidePrev()
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

window.customElements.define('carousel-component', CarouselComponent);

export default CarouselComponent;
