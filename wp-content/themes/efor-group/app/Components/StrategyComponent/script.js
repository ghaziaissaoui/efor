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

class StrategyComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    scrollTo()
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
function scrollTo()
{
  const pxCalc = (rem, base = 16) => {
    let tempRem = rem
    if (typeof rem === 'string' || rem instanceof String)
      tempRem = tempRem.replace('rem', '')

    tempRem = parseInt(tempRem)
    return base * tempRem
  }

  const anchors = document.querySelectorAll('.anchor')
  const goTo = document.querySelectorAll('.anchor-to')
  const mdBreakpoint = window.matchMedia('(max-width: 1000px)')
  const fullWImg = document.querySelector('.full-w-img')

  let gsSidebarWidth = parseFloat(pxCalc(getComputedStyle(document.documentElement).getPropertyValue('--gs-width-sidebar')))
  const fullWidth = window.innerWidth
  let fullWImgRatio = parseFloat(getComputedStyle(fullWImg).getPropertyValue('--block-ratio'))
  let fullWImgHeight = fullWImg.clientHeight
  let finalValue = (fullWImgRatio / 100) * (fullWidth - gsSidebarWidth)
  let imgHeightFinal = Math.round(finalValue - fullWImgHeight)

  let getPreviousSibling = function (refElement, target) {
    let first = null;

    let placeholder = refElement.previousElementSibling;

    while (placeholder) {
      if (placeholder.classList.contains(target)) {
        first = placeholder;
        break;
      }

      placeholder = placeholder.previousElementSibling;
    }

    return first;
  }

  anchors.forEach(anchor => {
    goTo.forEach(item => {
      let hrefGoTo = '#' + item.dataset.anchor
      let hrefAnchor = anchor.getAttribute('href')

      anchor.addEventListener('click', (ev) => {
        let int = 0;
        if (hrefAnchor === hrefGoTo) {
          let previous = item.previousSibling
          if (previous) {
            int++
            let findedImg = getPreviousSibling(previous, 'full-w-img-container');
            while (findedImg) {
              int++;
              if (findedImg) {
                findedImg = getPreviousSibling(findedImg, 'full-w-img-container')
              }
            }
          }
          console.log(fullWImgHeight)
          console.log(imgHeightFinal)

          let yOffset = int * imgHeightFinal;
          let headerOffset = 126;

          let y = item.offsetTop + yOffset - headerOffset
          if (mdBreakpoint.matches) {
            y = item.offsetTop
          }

          window.scrollTo({top: y, behavior: 'smooth'});
          ev.preventDefault();
        }
      })
    })
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

window.customElements.define('strategy-component', StrategyComponent);

export default StrategyComponent;
