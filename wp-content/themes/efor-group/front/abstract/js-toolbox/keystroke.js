import AbstractEvent from './abstract-event.js';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Private vars
  • Private Functions
  • Public Functions
  • Event Handlers
  • Init and Exports
*/

/*
  • Private vars
  ---------- ---------- ---------- ---------- ----------
*/

const TEXT_BASED_INPUT_TYPES = ['date', 'datetime-local', 'email', 'month', 'number', 'password', 'search', 'tel', 'text', 'time', 'url', 'week'];

const registered = {};
const responders = [];

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function isEditingText () {
  const activeElmt = document.activeElement;
  const tagName = activeElmt.tagName.toLowerCase();

  if(tagName === 'textarea'
  || (tagName === 'input' && TEXT_BASED_INPUT_TYPES.includes(activeElmt.type.toLowerCase()))
  || activeElmt.isContentEditable) {
    return true;
  }

  return false;
}

function getDoStrokeFunction (resp) {
  return function (strokeString) {
    // 'this' will be a keystroke event
    // (ie. an AbstractEvent instance)

    let proceed = true;

    // Checking in GLOBAL namespace
    if(('GLOBAL' in registered) && strokeString in registered.GLOBAL) {
      proceed = registered.GLOBAL[strokeString].call(resp.obj, this);
    }

    // Checking in component namespace
    if(proceed && (resp.ns in registered) && (strokeString in registered[resp.ns])) {
      registered[resp.ns][strokeString].call(resp.obj, this);
    }
  }
}

function getStrokeData (ev, resp) {
  const modifiers =
    (ev.ctrlKey ? 'ctrl+' : '') +
    (ev.metaKey ? 'meta+' : '') +
    (ev.altKey ? 'alt+' : '') +
    (ev.shiftKey ? 'shift+' : '');

  const stroke = `${modifiers}${ev.key.toLowerCase()}`;
  const codeStroke = `code:${modifiers}${ev.code.toLowerCase()}`;

  return {
    stroke,
    codeStroke,
    globalStrokeExists: ('GLOBAL' in registered) && (stroke in registered.GLOBAL),
    globalCodeStrokeExists: ('GLOBAL' in registered) && (codeStroke in registered.GLOBAL),
    nsStrokeExists: (resp.ns !== 'GLOBAL') && (resp.ns in registered) && (stroke in registered[resp.ns]),
    nsCodeStrokeExists: (resp.ns !== 'GLOBAL') && (resp.ns in registered) && (codeStroke in registered[resp.ns])
  };
}

/*
  • Public Functions
  ---------- ---------- ---------- ---------- ----------
*/

function register (ns, handlers) {
  if(!(ns in registered)) {
    registered[ns] = {};
  }

  for(const key in handlers) {
    registered[ns][key] = handlers[key];
  }
}

function registerGlobal (handlers) {
  register('GLOBAL', handlers);
}

function startResponding (ns = 'GLOBAL', obj = window) {
  responders.push({ ns, obj });
}

function stopResponding ({ ns, clearTail } = {}) {
  if(responders.length === 0) {
    return;
  }

  if(ns === undefined) {
    responders.pop();
  }
  else if(typeof ns === 'string') {
    // Remove last added responder of namespace ns
    let foundIndex = null;

    for(let i = responders.length - 1 ; i >= 0 ; i--) {
      if(responders[i].ns === ns) {
        foundIndex = i;
        break;
      }
    }

    if(foundIndex !== null) {
      responders.splice(
        foundIndex,
        // if clearTail, also remove all responders
        // added after the one we target, whatever the namespace
        clearTail ? responders.length : 1
      );
    }
  }
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

function onKeyUp (ev) {
  if(responders.length === 0) {
    return;
  }

  const resp = responders[responders.length - 1];
  const typeIsRegistered =
    ('GLOBAL' in registered)
    || (resp.ns in registered);

  if(!typeIsRegistered) {
    return;
  }

  const {
    stroke,
    codeStroke,
    globalStrokeExists,
    globalCodeStrokeExists,
    nsStrokeExists,
    nsCodeStrokeExists
  } = getStrokeData(ev, resp);

  if(!globalStrokeExists && !globalCodeStrokeExists && !nsStrokeExists && !nsCodeStrokeExists) {
    return;
  }

  const event = new AbstractEvent('keyStroke', {
    source: resp.obj,
    properties: {
      ctrlKey: ev.ctrlKey,
      metaKey: ev.metaKey,
      altKey: ev.altKey,
      shiftKey: ev.shiftKey,
      code: ev.code,
      key: ev.key,
      location: ev.location,
      repeat: ev.repeat,
      isEditingText: isEditingText(),
      originalEvent: ev,
      doStroke: getDoStrokeFunction(resp)
    }
  });

  let proceed = true;

  if(nsStrokeExists) {
    proceed = registered[resp.ns][stroke].call(resp.obj, event);
  }
  else if(nsCodeStrokeExists) {
    proceed = registered[resp.ns][codeStroke].call(resp.obj, event);
  }

  if(proceed === false) {
    return;
  }

  if(globalStrokeExists) {
    registered.GLOBAL[stroke].call(resp.obj, event);
  }
  else if(globalCodeStrokeExists) {
    registered.GLOBAL[codeStroke].call(resp.obj, event);
  }
}

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.addEventListener('keydown', onKeyUp);

export default {
  register,
  registerGlobal,
  startResponding,
  stopResponding
};

export {
  register,
  registerGlobal,
  startResponding,
  stopResponding
};
