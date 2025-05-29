import UIComponent from '../../abstract/js-toolbox/ui-component.js';

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
  root: '.sendify-optin-form',
  button: '.sendify-optin-form__button'
};


/*
 • Component Class
 ---------- ---------- ---------- ---------- ----------
 */

class OptinNewsletter extends UIComponent {
  constructor(elmt) {
    console.log('Calling OptinNewsletter constructor');
    // Calling parent class constructor
    super(elmt);

    this.buttonElmt.addEventListener('click', onClickButton.bind(this));

  }

  get buttonElmt() {
    return this.elmt.querySelector(SELECTORS.button);
  }

  optin() {
    validate(this)
  }
}

/*
 • Private Functions
 ---------- ---------- ---------- ---------- ----------
 */

function validate(self) {
  if (self.elmt.querySelector('.sendify-optin-form__input') && self.elmt.querySelector('.sendify-optin-form__input').value === '') {
    self.emit('validate', {
      root: self.elmt,
      detail: 'field_empty'
    })
  }

  else if (
    self.elmt.querySelector('.sendify-optin-form__input') &&
    self.elmt.querySelector('.sendify-optin-form__input').value &&
    !validateEmail(self.elmt.querySelector('.sendify-optin-form__input').value)
  ) {
    self.emit('validate', {
      root: self.elmt,
      detail: 'email_not_valid'
    })
  } else {
    const email = self.elmt.querySelector('.sendify-optin-form__input').value
    const doubleOptin = self.elmt.getAttribute('data-double-optin')
    const listId = self.elmt.getAttribute('data-list')

    fetch(window.js_vars.ajaxUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=subscribe_to_list&email=${email}&list=${listId}&double_optin=${doubleOptin}`,
      credentials: 'same-origin'
    }).then(res => res.json())
      .then(response => {
        self.emit('validate', {
          root: self.elmt,
          detail: response
        })
      })
  }
}

function validateEmail(email) {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

/*
 • Event Handlers
 ---------- ---------- ---------- ---------- ----------
 */

function onClickButton() {
  this.optin();
}

/*
 • Init and Exports
 ---------- ---------- ---------- ---------- ----------
 */

function init(root) {
  return Array.from((
    root || document
  ).querySelectorAll(SELECTORS.root)).map(elmt => new OptinNewsletter(elmt));
}

export default OptinNewsletter;

export {init as initOptinNewsletter};
