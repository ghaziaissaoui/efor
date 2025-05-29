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
  heroArticleContainer: '.hero-article-component',
  heroArticleImg: '.hero-article-component__img',
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class HeroArticleComponent extends CEComponent {
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
  const trigger = document.querySelectorAll(SELECTORS.heroArticleContainer);

  trigger.forEach(item => {
    if (item) {
      gsap.to(item.querySelector(SELECTORS.heroArticleImg), {
        translateX: '0%',
        duration: 0.8,
        stagger: 0.1,
        ease: 'none',
        scrollTrigger: {
          trigger: item,
          start: 'top 100%',
          end: 'top 100%',
          scrub: true,
          markers: false
        },
      })
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

window.customElements.define('hero-article-component', HeroArticleComponent);

export default HeroArticleComponent;
