import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import isMobile from 'is-mobile'

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
  sidebarLink: '.sidebar-component__content'
};

const M_CLASSES = {
  sidebarComponentFill: 'sidebar-component--fill',
  active: 'is-active'
};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class SidebarComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    this.isMobile = isMobile({ tablet: true })
    this.isIpad = /Macintosh/i.test(navigator.userAgent) && navigator.maxTouchPoints && navigator.maxTouchPoints > 1;

    if (this.isMobile || this.isIpad) {
      const transition = document.querySelector('.transition')
      transition.remove()
    } else {
      const transition = document.querySelector('.transition')
      const sidebarLinks = document.querySelectorAll(SELECTORS.sidebarLink)

      setTimeout(() => {
        transition.classList.remove(M_CLASSES.active);
      }, 500);

      sidebarLinks.forEach(link => {
        if (document.body.classList.contains('sidebar-transition')) {
          link.addEventListener('click', e => {
            e.preventDefault()

            let target = e.target.href;
            transition.classList.add(M_CLASSES.active)

            setTimeout(() => {
              window.location.href = target;
            }, 500)
          })
        }
      })
    }
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

window.customElements.define('sidebar-component', SidebarComponent);

export default SidebarComponent;
