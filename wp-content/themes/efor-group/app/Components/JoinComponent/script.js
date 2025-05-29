import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { Power0 } from 'gsap/gsap-core';
import VideoComponent from '../VideoComponent/script';

gsap.registerPlugin(ScrollTrigger);

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
  join: '.join',
  joinSlide: '.join-slide',
  joinContainer: '.join-scroll__container'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class JoinComponent extends CEComponent {
  constructor() {
    super()
    VideoComponent;
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    sliderHorizontal()
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
function sliderHorizontal() {

  const trigger = document.querySelectorAll(SELECTORS.join);

  trigger.forEach(item => {
    if(item) {
      let sections = gsap.utils.toArray(item.querySelectorAll(SELECTORS.joinSlide));

      if (window.screen.width <= 1000) {
        gsap.to(sections, {
          xPercent: -112 * (sections.length - 1),
          ease: Power0.easeIn,
          scrollTrigger: {
            trigger: item.querySelector(SELECTORS.joinContainer),
            pin: true,
            markers: false,
            start: 'top 10px',
            scrub: 1,
            end: 'bottom -100%',
          }
        });
      } else {
        gsap.to(sections, {
          xPercent: -100 * (sections.length - 1),
          ease: Power0.easeIn,
          scrollTrigger: {
            trigger: item.querySelector(SELECTORS.joinContainer),
            pin: true,
            markers: false,
            start: 'top 105px',
            scrub: 1,
            end: 'bottom -100%',
          }
        });
      }
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

window.customElements.define('join-component', JoinComponent);

export default JoinComponent;

