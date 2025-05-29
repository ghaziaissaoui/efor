import UIComponent from '../../abstract/js-toolbox/ui-component';

class Collapsible extends UIComponent {
  constructor (elmt) {
    super(elmt);

    this.elmt = elmt;
    this._toggleElmt = document.querySelector(this.elmt.dataset.toggledBy);
    this._collapsedHeight = this.elmt.offsetHeight;
    this._close = close.bind(this);

    if(this.elmt.classList.contains('collapsible--expanded')) {
      this._open = true;
      this.elmt.setAttribute('aria-hidden', false);
    }
    else {
      this._open = false;
      this._toggleElmt.classList.add('--contract');

      if(this._collapsedHeight > 0) {
        this.elmt.setAttribute('aria-hidden', false);
      }
      else {
        this.elmt.setAttribute('aria-hidden', true);
      }

      this.elmt.setAttribute('aria-hidden', true);
    }

    if(this._collapsedHeight > 0) {
      this.elmt.style.visibility = 'visible';
    }

    this.elmt.setAttribute('tabindex', -1);
    this.elmt.addEventListener('transitionend', onTransitionEnd.bind(this));
    this._toggleElmt.addEventListener('click', onClickToggler.bind(this));
  }

  expand () {
    var h = this.elmt.scrollHeight;
    this._open = true;
    this.elmt.classList.add('collapsible--transitioning');
    this.elmt.style.height = h + 'px';
    this.elmt.setAttribute('aria-hidden', false);
    this._toggleElmt.classList.remove('--contract');
    this.emit('toggle', { collapsible: this, type: 'expand' });
    this.emit('expand', { collapsible: this });
  }

  contract () {
    var h = this.elmt.scrollHeight;
    this._open = false;
    this.elmt.classList.remove('collapsible--expanded');
    this.elmt.style.height = h + 'px';
    this._collapsedHeight <= 0 && this.elmt.setAttribute('aria-hidden', true);
    setTimeout(this._close, 1000/60);
    this._toggleElmt.classList.add('--contract');
    this.emit('toggle', { collapsible: this, type: 'contract' });
    this.emit('contract', { collapsible: this });
  }

  toggle (shouldOpen) {
    if(shouldOpen === undefined) {
      this._open ? this.contract() : this.expand();
    }
    else {
      shouldOpen ? this.expand() : this.contract();
    }
  }
}

function close () {
  this.elmt.style.height = 0 + 'px';
}

function onTransitionEnd (ev) {
  if(ev.propertyName == 'height') {
    if(this._open) {
      this.elmt.classList.remove('collapsible--transitioning');
      this.elmt.classList.add('collapsible--expanded');
    }
    else {
      this.elmt.classList.remove('collapsible--expanded');
    }

    this.elmt.style.height = null;
  }
}

function onClickToggler () {
  this.toggle();
}

function init (root) {
  return Array.from((root || document).querySelectorAll('.collapsible')).map(elmt => {
    return new Collapsible(elmt);
  });
}

export default init;
