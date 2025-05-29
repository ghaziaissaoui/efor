import CEComponent from '../../abstract/js-toolbox/ce-component.js';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Config
  • Component Class
  • Event Handlers
  • Init and Exports
*/

/*
  • Config
  ---------- ---------- ---------- ---------- ----------
*/

const MODIFIER_CLASSES = {
  loading: '--loading',
  error: '--error'
}

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class ClickFetch extends CEComponent {
  constructor() {
    super();
  }

  get clickableElmt() {
    return this.firstElementChild;
  }

  connectedCallback () {
    this.defaultLabel = this.clickableElmt.textContent;
    this.action = this.dataset.action;

    if('loadingLabel' in this.dataset) {
      const loadingLabel = this.dataset.loadingLabel.trim();
      this.loadingLabel = loadingLabel.length > 0 ? loadingLabel : null;
    }
    else {
      this.loadingLabel = null;
    }

    if('params' in this.dataset) {
      const params = this.dataset.params;
      this.params = params !== '[]' ? JSON.parse(params) : null;
    }
    else {
      this.params = null;
    }

    this._onClickClickableElmt = onClickClickableElmt.bind(this);
    this.clickableElmt.addEventListener('click', this._onClickClickableElmt);
  }

  disconnectedCallback () {
    this.clickableElmt.removeEventListener('click', this._onClickClickableElmt);
  }

  fetch(url) {
    const clickableElmt = this.clickableElmt;
    clickableElmt.disabled = true;
    clickableElmt.classList.add(MODIFIER_CLASSES.loading);
    clickableElmt.classList.remove(MODIFIER_CLASSES.error);

    if(this.loadingLabel) {
      clickableElmt.innerHTML = this.loadingLabel;
    }

    const detail = {
      elmt: this,
      action: this.action
    };

    window.dispatchEvent(new CustomEvent(`beforeClickFetch:${this.action}`, { detail }));
    window.dispatchEvent(new CustomEvent('beforeClickFetch', { detail }));

    fetch(url || window.js_vars.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
      body: new URLSearchParams(Object.assign({
        action: this.action,
        security: window.js_vars.ajaxNonce
      }, this.params))
    })
    .then(response => response.json())
    .then(data => onFetchComplete.call(this, data))
    .catch(error => onFetchError.call(this, error));
  }
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

function onClickClickableElmt () {
  this.fetch();
}

function onFetchComplete (data) {
  const clickableElmt = this.clickableElmt;
  clickableElmt.disabled = false;
  clickableElmt.classList.remove(MODIFIER_CLASSES.loading);
  clickableElmt.innerHTML = this.defaultLabel;

  const detail = {
    elmt: this,
    action: this.action,
    success: data.success,
    data: data.data
  };

  window.dispatchEvent(new CustomEvent(`clickFetchComplete:${this.action}`, { detail }));
  window.dispatchEvent(new CustomEvent('clickFetchComplete', { detail }));

  if(!data.success) {
    clickableElmt.classList.add(MODIFIER_CLASSES.error);
    window.dispatchEvent(new CustomEvent(`clickFetchError:${this.action}`, { detail }));
    window.dispatchEvent(new CustomEvent('clickFetchError', { detail }));
  }
}

function onFetchError (error) {
  console.log(error);

  const clickableElmt = this.clickableElmt;
  clickableElmt.classList.remove(MODIFIER_CLASSES.loading);
  clickableElmt.classList.add(MODIFIER_CLASSES.error);
}

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('click-fetch', ClickFetch);

export default ClickFetch;
