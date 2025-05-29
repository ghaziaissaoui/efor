import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Navigation, Pagination } from 'swiper';
import UIComponent from '../../../front/abstract/js-toolbox/ui-component';
import { loadAxeptio } from '../../../front/components/consentAxeptio/consentAxeptio';
import { initModals } from '../../../front/components/modal/modal';

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
  slider: '.talents-slider',
  sliderWrapper: '.swiper-wrapper',
  sliderSlide: '.swiper-slide',
  sliderModalContent: '.content-talent',
  sliderModalDialog: '.modal__dialog',
  sliderModalHero: '.hero-talent-component',
  slideActive: '.swiper-slide-active',
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class TalentsSliderComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }
  connectedCallback() {
    console.log('Connected:', this);

    const trigger = document.querySelectorAll(SELECTORS.slider);
    let activeIndex = null;

    trigger.forEach(item => {
      if (item) {
        let swiperTalent = new Swiper(item, {
          modules: [Navigation, Pagination],
          breakpoints: {
            0: {
              slidesPerView: 'auto',
              spaceBetween: 24,
              centeredSlides: true,
              loop: true,
              centeredSlidesBounds: true,
              preventClicks: true,
              preventClicksPropagation: true,
            },
            720: {
              loop: true,
              centeredSlides: true,
              shortSwipes: false,
              slideToClickedSlide: true,
              touchStartPreventDefault: false,
              slidesPerView: 'auto',
            },
          },
          on: {
            click: function (swiper) {
              if (activeIndex === swiper.activeIndex) {
                modalShow(window.location.href)
              } else {
                activeIndex = swiper.activeIndex
              }
            },
            slideChangeTransitionEnd: function (swiper) {
              activeIndex = swiper.activeIndex
            }
          },
          pagination: {
            el: '.talent-swiper-pagination',
            clickable: true,
          },
          navigation: {
            nextEl: '.talents-arrow-next',
            prevEl: '.talents-arrow-prev',
          }
        });
        activeIndex = swiperTalent.activeIndex
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

function modalShow(currentUrl) {
  const talentItem = document.querySelector(SELECTORS.slideActive)
  const talentsModal = UIComponent.get(document.getElementById('Talents-modal'));
  const url = talentItem.dataset.url;

  if (talentsModal) {
    const mdBreakpoint = window.matchMedia('(max-width: 560px)');
    if (mdBreakpoint.matches) {
      setTimeout(() => { talentsModal.show(); }, 300)
    }
    talentsModal.show()
    if (url) {
      window.history.replaceState(null, '', url);
    }

    loadModalContent(talentItem.id);
    talentsModal.on('dismiss', () => {
      const modalContent = document.querySelector('#Talents-modal .modal__content');
      modalContent.innerHTML = '';
      document.querySelector('.modal__scrollbox').scroll({ top: 0 });
      window.history.replaceState(null, '', currentUrl);
    })
  }
}

function loadModalContent(postId) {
  fetch(window.js_vars.ajaxUrl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cache-Control': 'no-cache'
    },
    body: new URLSearchParams({
      action: 'load-talent-modal-content',
      security: window.js_vars.ajaxNonce,
      postId: postId,
    })
  }).then(response => response.json())
    .then(data => onComplete.call(this, data))
}

function onComplete(data) {
  const modalContent = document.querySelector('#Talents-modal .modal__content');
  modalContent.innerHTML = data.data;

  const modalContentHeight = modalContent.querySelector(SELECTORS.sliderModalContent).scrollHeight;
  const modalHero = modalContent.querySelector(SELECTORS.sliderModalHero).scrollHeight;
  const modalDialog = document.querySelector(SELECTORS.sliderModalDialog);

  let margin = 80

  if (window.matchMedia('(max-width: 720px)').matches) {
    margin = 50;
  }

  modalDialog.style.height = (modalContentHeight + modalHero + margin) + 'px';
  loadAxeptio();
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

// Init modals
initModals();

window.customElements.define('talents-slider-component', TalentsSliderComponent);

export default TalentsSliderComponent;
