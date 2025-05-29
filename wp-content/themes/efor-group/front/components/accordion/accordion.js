import UIComponent from '../../abstract/js-toolbox/ui-component';

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
  accordion:'.accordion',
  accordionItem:'.accordion .item',
  accordionItemContentIntro:'.accordion .item .item__intro',
  accordionItemContent:'.accordion .item .item__content',
};

const M_CLASSES = {
  open: 'item--open',
};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class Accordion extends UIComponent{
  constructor(elmt) {
    super(elmt)
    this.elmt = elmt

    document.querySelectorAll(SELECTORS.accordion).forEach(elmt => {
      elmt.addEventListener('click', onClickMainSection.bind(this));
      firstItemActiveOnBigScreen.call(this)
    })
  }

  toggleAccordionContent(accordionElmt) {
    accordionElmt.classList.contains(M_CLASSES.open)
      ? this.contractAccordionContent(accordionElmt)
      : this.expandAccordionContent(accordionElmt);
  }
  expandAccordionContent(accordionElmt) {
    if (this.expandedAccordionContentElmt) {
      this.contractAccordionContent(this.expandedAccordionContentElmt);
    }

    const accordionElmtContent = accordionElmt.querySelector(SELECTORS.accordionItemContent);
    if (accordionElmtContent) {
      accordionElmtContent.style.maxHeight = accordionElmtContent.scrollHeight + 'px';
      accordionElmt.classList.add(M_CLASSES.open);
      this.expandedAccordionContentElmt = accordionElmt;
      this.emit('expandAccordionContent');
    }
  }

  contractAccordionContent(accordionElmt) {
    const accordionElmtContent = accordionElmt.querySelector(SELECTORS.accordionItemContent);
    if (accordionElmtContent) {
      accordionElmtContent.style.maxHeight = '';
      accordionElmt.classList.remove(M_CLASSES.open);
      this.emit('expandAccordionContent');
    }
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/
function onClickMainSection(ev) {
  const accordionElmt = ev.target.closest(SELECTORS.accordionItemContentIntro)
    ? ev.target.closest(SELECTORS.accordionItem)
    : null;

  console.log(accordionElmt)
  if (accordionElmt) {
    this.toggleAccordionContent(accordionElmt);
    ev.preventDefault();

    setTimeout(() => {
      accordionElmt.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }, 350)
  }
}

function firstItemActiveOnBigScreen() {
  const lgBreakpoint = window.matchMedia('(min-width: 1000px)');
  const accordionElmt = this.elmt.firstElementChild;

  if (lgBreakpoint.matches) {
    this.expandAccordionContent(accordionElmt)
  }
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/
const getComponent = UIComponent.get;

function init (rootElmt) {
  return Array.from((rootElmt || document).querySelectorAll('.accordion')).map(elmt => {
    return new Accordion(elmt);
  });
}

export default Accordion;
export { init as initAccordion, getComponent };
