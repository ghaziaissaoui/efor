import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { SplitText } from 'gsap/SplitText'

gsap.registerPlugin(ScrollTrigger, SplitText)

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
  storytelling: '.storytelling-component',
  storytellingText: '.storytelling__text'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class StorytellingComponent extends CEComponent {
  constructor() {
    super()

  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    textReveal()
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

function textReveal() {
  const targets = gsap.utils.toArray(document.querySelectorAll(SELECTORS.storytelling));
  targets.forEach((target) => {
    let SplitClient = new SplitText(target.querySelector(SELECTORS.storytellingText), { type: "words,chars" });
    let chars = SplitClient.chars; //an array of all the divs that wrap each character
    gsap.from(chars, {
      duration: 0.8,
      opacity: 0.4,
      y: 0,
      ease: 'none',
      stagger: 0.1,
      scrollTrigger: {
        trigger: target,
        markers: false,
        start: 'top 75%',
        end: 'bottom center',
        scrub: true
      }
    });
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

window.customElements.define('storytelling-component', StorytellingComponent);

export default StorytellingComponent;
