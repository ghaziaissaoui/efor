import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import {gsap} from 'gsap';

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
  imageContainer: '.rejoindre-component',
  imgleft: '.image__left',
  imgRight: '.image__right'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class RejoindreComponent extends CEComponent {
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
      if (window.screen.width <= 560) {
        gsap.to(item.querySelector(SELECTORS.imgRight), {
          translateX: '30%',
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
      } else if((window.screen.width <= 1000)) {
        gsap.to(item.querySelector(SELECTORS.imgleft), {
          translateX: '-70%',
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
        gsap.to(item.querySelector(SELECTORS.imgRight), {
          translateX: '70%',
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
      } else {
        gsap.to(item.querySelector(SELECTORS.imgleft), {
          translateX: '-50%',
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
        gsap.to(item.querySelector(SELECTORS.imgRight), {
          translateX: '50%',
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

window.customElements.define('rejoindre-component', RejoindreComponent);

export default RejoindreComponent;
