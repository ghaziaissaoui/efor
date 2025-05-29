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

class FooterComponent extends CEComponent {
  constructor() {
    super();
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
    console.log('Attribute Changed:', this);
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

window.customElements.define('footer-component', FooterComponent);

export default FooterComponent;
