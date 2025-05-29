import CEComponent from '../../abstract/js-toolbox/ce-component.js';

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
  root: '.dummy',
  button: '.dummy__button',
  reset: '.dummy__reset',
  output: '.dummy__output',
  count: '.dummy__count'
};

const MODIFIER_CLASSES = {
  clicked: '--clicked'
}

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class Dummy extends CEComponent {
  constructor () {
    super();

    this._clicked = 0;

    this.buttonElmt.addEventListener('click', onClickButton.bind(this));
    this.resetElmt.addEventListener('click', onClickReset.bind(this));
  }

  get buttonElmt () {
    return this.querySelector(SELECTORS.button);
  }

  get resetElmt () {
    return this.querySelector(SELECTORS.reset);
  }

  get outputElmt () {
    return this.querySelector(SELECTORS.output);
  }

  get countElmt () {
    return this.querySelector(SELECTORS.count);
  }

  increment () {
    change(this, this._clicked + 1);

    // .emit() is inherited from CEComponent
    this.emit('increment', { component: this });
  }

  decrement () {
    change(this, this._clicked - 1);

    // .emit() is inherited from CEComponent
    this.emit('decrement', { component: this });
  }

  reset () {
    change(this, 0);

    // .emit() is inherited from CEComponent
    this.emit('reset', { component: this });
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function change (self, n) {
  self._clicked = n;
  self.countElmt.innerText = n;
  self.countElmt.classList.toggle('t-weight-900', n > 1);
  managePlural(self, n);
  self.classList.toggle(MODIFIER_CLASSES.clicked, n > 0);

  // .emit() is inherited from CEComponent
  self.emit('change', { component: this });
}

function managePlural (self, n) {
  self.querySelectorAll('*[data-singular][data-plural]').forEach(elmt => {
    elmt.innerText = elmt.dataset[n > 1 ? 'plural' : 'singular'];
  });
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

function onClickButton () {
  this.increment();
}

function onClickReset () {
  this.reset();
}

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('dummy-component', Dummy);

export default Dummy;
