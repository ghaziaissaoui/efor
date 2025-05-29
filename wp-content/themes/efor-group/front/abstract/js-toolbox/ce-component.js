import Focus from '../../abstract/js-toolbox/focus.js';
import Keystroke from '../../abstract/js-toolbox/keystroke.js';

class CEComponent extends HTMLElement {
  constructor () {
    super();
  }

  on (type, handler, options) {
    return this.addEventListener(type, handler, options);
  }

  off (type, handler, options) {
    return this.removeEventListener(type, handler, options);
  }

  emit (type, data, options = {}) {
    options.detail = data;
    this.dispatchEvent(new CustomEvent(type, options));
  }

  trapFocus ({ inElmt, defaultElmt } = {}) {
    Focus.trapIn(inElmt || this, defaultElmt);
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

CEComponent.registerKeystrokes = function (keystrokes) {
  // this.name should return the name of the class
  Keystroke.register(this.name, keystrokes);
}

export default CEComponent;
