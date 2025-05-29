import UIComponent from '../../abstract/js-toolbox/ui-component.js';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Constants
  • Main class
  • Private functions
  • Event handlers
  • Prompt
  • Exports
*/

/*
  • Constants
  ---------- ---------- ---------- ---------- ----------
*/
// className
const CLASS_NAMES = {
  scrollbox: 'modal__scrollbox u-y-scrollable',
  dialog: 'modal__dialog',
  closeButton: 'modal__close-button close-button func-button',
  loader: 'loader modal__loader',
};

const SELECTORS = {
  scrollbox: '.modal__scrollbox',
  dialog: '.modal__dialog',
  closeButton: '.modal__close-button',
  title: '.modal__title',
  content4point: '.point',
};

const MODIFIER_CLASSES = {
  loading: 'modal--loading',
  visible: 'modal--visible'
};

const ATTRIBUTES = {
  ariaHidden: 'aria-hidden',
};

/*
  • Main class
  ---------- ---------- ---------- ---------- ----------
*/

class Modal extends UIComponent {
  constructor ({ elmt, autoInsertCloseButton }) {
    super(elmt);

    this.autoInsertCloseButton = autoInsertCloseButton;
    this.scrollboxElmt = this.elmt.querySelector(SELECTORS.scrollbox);
    this.dialogElmt = this.elmt.querySelector(SELECTORS.dialog);
    this.closeButton = this.elmt.querySelector(SELECTORS.closeButton);

    if(this.elmt.classList.contains(MODIFIER_CLASSES.visible)) {
      this.show();
    }
    else {
      /* stylelint-disable-next-line */
      this.elmt.setAttribute(ATTRIBUTES.ariaHidden, true);
    }

    this.elmt.addEventListener('click', onClick.bind(this));
  }

  get speakerPoint() {
    return document.querySelectorAll(SELECTORS.content4point);
  }

  show () {
    const sourceUrl = this.elmt.dataset.sourceUrl;
    this._promise = {};
    this._promise.instance = new Promise((resolve, reject) => {
      this._promise.resolve = resolve;
      this._promise.reject = reject;
    });
    this.emit('show');

    if(sourceUrl) {
      this.loadContent(sourceUrl);
    }
    else {
      showComplete.call(this);
    }

    return this._promise.instance;
  }

  confirm () {
    this.elmt.classList.remove(MODIFIER_CLASSES.loading);
    this.elmt.classList.remove(MODIFIER_CLASSES.visible);
    /* stylelint-disable-next-line */
    this.elmt.setAttribute(ATTRIBUTES.ariaHidden, true);
    looseFocus.call(this);
    if(this._promise) {
      this._promise.resolve(true);
      delete this._promise;
    }
    this.emit('confirm');
    this.emit('hide');
  }

  dismiss () {
    this.elmt.classList.remove(MODIFIER_CLASSES.loading);
    this.elmt.classList.remove(MODIFIER_CLASSES.visible);
    if(this.speakerPoint){
      this.speakerPoint.forEach(elmt => {
        elmt.querySelector('.label').classList.remove('hidden')
      })
    }
    /* stylelint-disable-next-line */
    this.elmt.setAttribute(ATTRIBUTES.ariaHidden, true);
    looseFocus.call(this);
    if(this._promise) {
      this._promise.resolve(false);
      delete this._promise;
    }
    this.emit('dismiss');
    this.emit('hide');
  }

  loadContent (url) {
    if(this.dialogElmt) {
      this.dialogElmt.innerHTML = '';
    }

    this.loaderElmt = document.createElement('div');
    this.loaderElmt.className = CLASS_NAMES.loader;
    this.elmt.appendChild(this.loaderElmt);

    this.elmt.classList.add(MODIFIER_CLASSES.loading);

    fetch(url)
      .then(resp => resp.text())
      .then(onLoadContent.bind(this))
      .catch(onLoadContentError.bind(this));
  }
}

/*
  • Private functions
  ---------- ---------- ---------- ---------- ----------
*/

function showComplete () {
  this.autoInsertCloseButton && insertCloseButton.call(this);
  const shouldEmitLoadEvent = this.elmt.classList.contains(MODIFIER_CLASSES.loading);
  this.elmt.classList.remove(MODIFIER_CLASSES.loading);
  this.elmt.classList.add(MODIFIER_CLASSES.visible);
  /* stylelint-disable-next-line */
  this.elmt.setAttribute(ATTRIBUTES.ariaHidden, false);
  gainFocus.call(this);
  shouldEmitLoadEvent && this.emit('loadContent');
  this.emit('shown');
}

function gainFocus () {
  const focusElmt = this.dialogElmt.querySelector(SELECTORS.title) || this.dialogElmt || this.elmt;
  focusElmt.tabIndex = 0;

  setTimeout(() => {
    focusElmt.focus();
  }, 500);
}

function looseFocus () {
  const focusElmt = this.dialogElmt.querySelector(SELECTORS.title) || this.dialogElmt || this.elmt;
  focusElmt.tabIndex = -1;
}

function insertCloseButton () {
  if(!this.closeButton) {
    this.closeButton = document.createElement('button');
    this.closeButton.className = CLASS_NAMES.closeButton;
    this.closeButton.setAttribute('data-dismiss', true);
    this.closeButton.innerHTML = '<span class="close-button__bar"></span><span class="close-button__bar"></span>';
  }

  this.dialogElmt.insertAdjacentElement('afterbegin', this.closeButton);
}

function insertLoadedContent (html) {
  if(this.scrollboxElmt) {
    this.scrollboxElmt.classList.add('u-y-scrollable');
  }
  else {
    this.scrollboxElmt = document.createElement('div');
    this.scrollboxElmt.className = CLASS_NAMES.scrollbox;
    this.elmt.appendChild(this.scrollboxElmt);
  }

  if(!this.dialogElmt) {
    this.dialogElmt = document.createElement('div');
    this.dialogElmt.className = CLASS_NAMES.dialog;
    this.scrollboxElmt.appendChild(this.dialogElmt);
  }

  this.dialogElmt.innerHTML = html;

  if(this.loaderElmt) {
    this.loaderElmt.remove();
    this.loaderElmt = null;
  }
}

/*
  • Event handlers
  ---------- ---------- ---------- ---------- ----------
*/

function onClick (ev) {
  if(ev.target === this.scrollboxElmt || ev.target === this.elmt) {
    this.dismiss();
    return;
  }

  const actionElmt = ev.target.closest('[data-confirm], [data-dismiss]');

  if(actionElmt && this.elmt.contains(actionElmt)) {
    if(actionElmt.hasAttribute('data-confirm')) {
      this.confirm();
      return;
    }

    if(actionElmt.hasAttribute('data-dismiss')) {
      this.dismiss();
      return;
    }
  }
}

function onLoadContent(html) {
  insertLoadedContent.call(this, html);
  setTimeout(showComplete.bind(this), 50);
}

function onLoadContentError(err) {
  console.log(err);
}

/*
  • Exports
  ---------- ---------- ---------- ---------- ----------
*/

const getComponent = UIComponent.get;

function init (rootElmt) {
  return Array.from((rootElmt || document).querySelectorAll('.modal')).map(elmt => {
    return new Modal({ elmt, autoInsertCloseButton: true });
  });
}

export default Modal;
export { init as initModals, getComponent };
