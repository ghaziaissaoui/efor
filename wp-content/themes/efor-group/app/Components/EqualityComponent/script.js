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
  imageContainer: '.equality-component',
  imgleft: '.image__left',
  imgRight: '.image__right'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class EqualityComponent extends CEComponent {
  constructor() {
    super()
    imgReveal()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
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
  const trigger = document.querySelectorAll(SELECTORS.imageContainer);
  trigger.forEach(item => {
    if (item) {
      if (window.screen.height <= 800) {
        gsap.to(item.querySelector(SELECTORS.imgleft), {
          translateX: '0%',
          duration: 0.8,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'bottom 70%',
            scrub: true,
            markers: false
          },
        })
        gsap.to(item.querySelector(SELECTORS.imgRight), {
          translateX: '0%',
          duration: 0.8,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'bottom 70%',
            scrub: true,
            markers: false
          },
        })
      } else {
        gsap.to(item.querySelector(SELECTORS.imgleft), {
          translateX: '0%',
          duration: 0.8,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 5%',
            scrub: true,
            markers: false
          },
        })
        gsap.to(item.querySelector(SELECTORS.imgRight), {
          translateX: '0%',
          duration: 0.8,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 5%',
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

window.customElements.define('equality-component', EqualityComponent);

export default EqualityComponent;
