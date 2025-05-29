import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

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
  fullW: '.full-w-img-component',
  fullWImg: '.full-w-img'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class FullWImgComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    imgReveal()
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
function imgReveal()
{
  let gsMaxWidth = getComputedStyle(document.documentElement).getPropertyValue('--gs-max-width')
  const offsetMarginBigScreen = `calc(((100vw - ${gsMaxWidth}) / 2) * -1)`; // remove margin on big screen

  const trigger = document.querySelectorAll(SELECTORS.fullW);

  trigger.forEach( (item) => {
    if (item) {
      if (window.screen.width >= 720) {
        gsap.to(item.querySelector(SELECTORS.fullWImg), {
          marginLeft: offsetMarginBigScreen,
          marginRight: offsetMarginBigScreen,
          duration: 0.8,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })
      }
    }
  })
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('full-w-img-component', FullWImgComponent);
export default FullWImgComponent;
