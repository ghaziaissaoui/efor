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

const SELECTORS = {
  years: '.timeline-content__year',
  progressbarFill: '.timeline-progressbar__fill',
  progressbar: '.timeline-progressbar',
  contents: '.timeline-contents',
  content: '.timeline-content',
  header: 'header-component',
};

const SETTINGS = {
  scrollOffset: {
    small: 15,
    large: 25,
    default: 7,
  }
}

/*
 • Component Class
 ---------- ---------- ---------- ---------- ----------
 */

class TimelineComponent extends CEComponent {
  constructor() {
    super();
  }

  get contentContainerElmt() {
    return this.querySelector(SELECTORS.contents);
  }

  get contentsElmt() {
    return [...this.querySelectorAll(SELECTORS.content)];
  }

  get progressbarElmt() {
    return this.querySelector(SELECTORS.progressbar);
  }

  get progressBarFillElmt() {
    return this.querySelector(SELECTORS.progressbarFill);
  }

  get yearsElmt() {
    return [...this.querySelectorAll(SELECTORS.years)];
  }

  get contentPos() {
    return this._contentPos;
  }

  get scrollOffset() {
    return this._scrollOffset;
  }

  get headerHeight() {
    return document.querySelector(SELECTORS.header).getBoundingClientRect().height;
  }

  get prevScreenWidth() {
    return this._prevScreenWidth;
  }

  set contentPos(posObj) {
    this._contentPos = posObj;
  }

  set scrollOffset(offset) {
    this._scrollOffset = offset;
  }

  set prevScreenWidth(width) {
    this._prevScreenWidth = Math.round(width);
  }

  connectedCallback() {
    this.progressBarFillElmt.style.maxHeight = 0 + '%';
    this.scrollOffset = SETTINGS.scrollOffset.default;

    this.addYearStyle();
    this.setPositions();
    this.setProgressBarHeight()

    window.addEventListener('scroll', () => {
      this.contentPos ? this.animateProgressbar() : null;
    })
  }

  setProgressBarHeight() {
    const lgBreakpoint = window.matchMedia('(max-width: 1000px)');
    if(lgBreakpoint.matches) {
      const contentElmt = this.contentsElmt.slice(0, -1)
      let arr = [];
      const init = 0;

      contentElmt.forEach(el => {
        arr.push(el.clientHeight)
        const sumOfcontentHeight = arr.reduce((acc, currentValue) => acc + currentValue, init);
        this.progressbarElmt.style.height = sumOfcontentHeight + 205 + 'px'
      })
    }
  }

  addYearStyle() {
    this.yearsElmt.forEach(year => {
      const yearSplit = year.textContent.match(/.{1,2}/g);
      year.innerHTML = `${yearSplit[0]}<span class="c-gold">${yearSplit[1]}</span>`;
    });
  }

  animateProgressbar() {
    const currentScrollPos = window.scrollY - this.contentPos.top; // Position of scroll inside the container

    if (window.scrollY < this.contentPos.start) {
      this.progressBarFillElmt.style.maxHeight = 0 + '%';

      return;
    }

    if (window.scrollY > this.contentPos.start && window.scrollY <= this.contentPos.end) {
      const height = this.progressbarElmt.scrollHeight - this.scrollOffset;
      const scrolled = ( currentScrollPos / height) * 100;

      this.progressBarFillElmt.style.maxHeight = Math.round(scrolled + this.scrollOffset) + '%';
    }
  }

  setPositions() {
    setTimeout(() => {
      this.contentPos = {
        top: this.contentContainerElmt.getBoundingClientRect().top,
        start: this.contentContainerElmt.getBoundingClientRect().top - this.headerHeight - 50,
        end: this.contentContainerElmt.getBoundingClientRect().top + this.contentContainerElmt.offsetHeight,
      }

      this.style.setProperty('--first-content-height', this.contentsElmt[0].offsetHeight + 'px')

      if (window.innerHeight < 600 && window.screen.width >= 1000) {
        this.scrollOffset = SETTINGS.scrollOffset.small;
        return;
      }

      if (window.innerHeight > 900 && window.screen.width >= 1000) {
        this.scrollOffset = SETTINGS.scrollOffset.large;
        return;
      }

      this.scrollOffset = SETTINGS.scrollOffset.default;
    }, 200);
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

window.customElements.define('timeline-component', TimelineComponent);

export default TimelineComponent;
