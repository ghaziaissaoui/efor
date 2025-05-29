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
  loadMore: '.load-more',
  listingContent: '.listing-content'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class ListingComponent extends CEComponent {
  constructor() {
    super()

    if(this.loadMore) {
      this.loadMore.addEventListener('click', () => loadNextPage.call(this));
    }
  }

  get loadMore() {
    return this.querySelector(SELECTORS.loadMore)
  }

  get listingContent() {
    return this.querySelector(SELECTORS.listingContent)
  }

  static get observedAttributes() {
    return ['data-paged'];
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
      doLoadMore.call(
        this,
        newValue,
        this.getAttribute('data-size'),
        this.getAttribute('data-url'),
        this.getAttribute('data-cat'),
        this.getAttribute('data-cpt'),
      )
    }
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function loadNextPage() {
  const paged = this.getAttribute('data-paged')
  this.setAttribute('data-paged', parseInt(paged) + 1)
}

function doLoadMore(
  nextPage,
  size,
  url,
  cat,
  contentType = 'post',
) {
  fetch(window.js_vars.ajaxUrl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cache-Control': 'no-cache'
    },
    body: new URLSearchParams({
      action: 'load-more',
      security: window.js_vars.ajaxNonce,
      size,
      contentType,
      nextPage,
      url,
      cat,
    })
  }).then(response => response.json())
    .then(data => onComplete.call(this, data))
}

function onComplete(data) {
  if(data.fragment !== '') {
    document.querySelector(SELECTORS.listingContent).insertAdjacentHTML('beforeend', data.fragment)
  }

  if(!data.hasNext) {
    this.loadMore.remove()
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

window.customElements.define('listing-component', ListingComponent);

export default ListingComponent;
