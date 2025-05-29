/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Private vars
  • Private Functions
  • Public Functions
  • Event Handlers
  • Exports
*/

/*
  • Private vars
  ---------- ---------- ---------- ---------- ----------
*/

let trapElmt;
let resumeElmt;
let focusables;

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function sortFocusables (unsorted) {
  const sorted = unsorted.filter(elmt => elmt.tabIndex === 0);

  for(const elmt of unsorted) {
    if(elmt.tabIndex > 0) {
      if(elmt.tabIndex > sorted.length) {
        sorted.push(elmt);
      }
      else {
        sorted.splice(elmt.tabIndex - 1, 0, elmt);
      }
    }
  }

  return sorted;
}

function focusNext () {
  if(!trapElmt) {
    return;
  }

  let index = focusables.indexOf(document.activeElement);

  if(index === -1) {
    index = resumeElmt
      ? focusables.indexOf(resumeElmt)
      : 0;
  }
  else {
    index = index >= focusables.length - 1
      ? 0
      : index + 1;
  }

  focusables[index].focus();
}

function focusPrevious () {
  if(!trapElmt) {
    return;
  }

  let index = focusables.indexOf(document.activeElement);

  if(index === -1) {
    index = resumeElmt
      ? focusables.indexOf(resumeElmt)
      : focusables.length - 1;
  }
  else {
    index = index <= 0
      ? focusables.length - 1
      : index - 1;
  }

  focusables[index].focus();
}

/*
  • Public Functions
  ---------- ---------- ---------- ---------- ----------
*/

function isFocusable (elmt) {
  return elmt.tabIndex > -1;
}

function getFocusablesIn (parentElmt) {
  return sortFocusables(Array.from(parentElmt.querySelectorAll('*')).filter(isFocusable));
}

function trapIn (elmt, defaultElmt) {
  trapElmt = elmt;
  resumeElmt = defaultElmt && elmt.contains(defaultElmt) && isFocusable(defaultElmt)
    ? defaultElmt
    : null;

  focusables = getFocusablesIn(trapElmt);

  window.addEventListener('focusin', onFocusIn);
  window.addEventListener('keydown', onKeyDown);
}

function release (soft) {
  trapElmt = null;
  resumeElmt = null;

  if(!soft) {
    focusables = null;
    window.removeEventListener('focusin', onFocusIn);
    window.removeEventListener('keydown', onKeyDown);
  }
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

function onFocusIn (ev) {
  if(!trapElmt.contains(ev.target)) {
    release(true); // "soft" release
  }
  else if(!focusables) {
    trapIn(trapElmt);
  }
}

function onKeyDown (ev) {
  if(!trapElmt) {
    return;
  }

  // If default behavior of the tab key has been prevented
  // we assume its being used for something else
  // than focus cycling and stop here.
  if(ev.key === 'Tab' && !ev.defaultPrevented) {
    ev.preventDefault();

    if(ev.shiftKey) {
      focusPrevious();
    }
    else {
      focusNext();
    }
  }
}

/*
  • Exports
  ---------- ---------- ---------- ---------- ----------
*/

export default {
  isFocusable,
  getFocusablesIn,
  trapIn,
  release
};

export {
  isFocusable,
  getFocusablesIn,
  trapIn,
  release
};
