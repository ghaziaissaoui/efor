import Focus from '../../abstract/js-toolbox/focus.js';
import Keystroke from '../../abstract/js-toolbox/keystroke.js';

const instances = new WeakMap();

class UIComponent {
  constructor (elmt) {
    this.elmt = elmt;
    this._bindedEventHandlers = {};
    this._unbindedEventHandlers = {};
    instances.set(this.elmt, this);
    this.elmt.dataset.componentReady = true;
  }

  remove () {
    this.offAll();
    instances.delete(this.elmt);
    this.elmt.remove();
  }

  on (type, handler) {
    const bindedHandler = handler.bind(this);

    if(!(type in this._bindedEventHandlers)) {
      this._bindedEventHandlers[type] = new WeakMap();
      this._unbindedEventHandlers[type] = new Set();
    }

    this._bindedEventHandlers[type].set(handler, bindedHandler);
    this._unbindedEventHandlers[type].add(handler);

    this.elmt.addEventListener(type, bindedHandler);
  }

  off (type, handler) {
    if((type in this._bindedEventHandlers) && this._bindedEventHandlers[type].has(handler)) {
      const bindedHandler = this._bindedEventHandlers[type].get(handler);
      this._bindedEventHandlers[type].delete(handler);
      this._unbindedEventHandlers[type].delete(handler);
      this.elmt.removeEventListener(type, bindedHandler);
    }
  }

  offAll () {
    for(const type in this._unbindedEventHandlers) {
      this._unbindedEventHandlers[type].forEach(handler => {
        this.off(type, handler);
      });
    }

    this._bindedEventHandlers = {};
    this._unbindedEventHandlers = {};
  }

  emit (type, data, options = {}) {
    options.detail = data;
    this.elmt.dispatchEvent(new CustomEvent(type, options));
  }

  trapFocus ({ inElmt, defaultElmt } = {}) {
    Focus.trapIn(inElmt || this.elmt, defaultElmt);
  }

  releaseFocus () {
    Focus.release();
  }

  startRespondingToKeystrokes () {
    // this.constructor.name should return the name of the class
    Keystroke.startResponding(this.constructor.name, this);
  }

  stopRespondingToKeystrokes () {
    // this.constructor.name should return the name of the class
    Keystroke.stopResponding({ ns: this.constructor.name });
  }
}

UIComponent.registerKeystrokes = function (keystrokes) {
  // this.name should return the name of the class
  Keystroke.register(this.name, keystrokes);
}

UIComponent.get = function (elmt) {
  return instances.get(elmt);
}

export default UIComponent;
