import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';

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

const SELECTORS = {};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class HeroTalentComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    onInit()
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
function onInit() {
  var observer = new IntersectionObserver(function(entries) {
    // isIntersecting is true when element and viewport are overlapping
    // isIntersecting is false when element and viewport don't overlap
    if(entries[0].isIntersecting) {
      document.body.classList.add('talent-hero')
    } else {
      document.body.classList.remove('talent-hero')

    }
    console.log('Element has just become visible in screen');
  }, { threshold: [0] });

  observer.observe(document.querySelector('hero-talent-component'));
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('hero-talent-component', HeroTalentComponent);

export default HeroTalentComponent;
