const files = {
  scripts: [],
  stylesheets: [],
};

function registerFiles (payload, listName) {
  const list = files[listName];

  if(typeof payload === 'string') {
    list.push(payload);
  }
  else {
    Object.entries(payload).forEach(item => {
      if(isNaN(parseInt(item[0]))) {
        list.push({
          url: item[1],
          callback: item[0]
        });
      }
      else {
        list.push(item[1]);
      }
    });
  }
}

function registerStylesheets (payload) {
  registerFiles(payload, 'stylesheets');
}

function registerScripts (payload) {
  registerFiles(payload, 'scripts');
}

function loadRegisteredFiles (listName) {
  const list = files[listName];

  list.forEach(item => {
    const newElmt = document.createElement(listName === 'stylesheets' ? 'link' : 'script');

    if(listName === 'stylesheets') {
      newElmt.rel = 'stylesheet';
    }
    else {
      newElmt.type = 'text/javascript';
    }

    if(typeof item === 'string') {
      newElmt.href = item;
    }
    else {
      newElmt.href = item.url;
      newElmt.onload = window[`${newElmt.callback}Loaded`];
    }

    document.head.appendChild(scriptElmt);
  });

  list.length = 0;
}

function loadRegisteredStylesheets () {
  loadRegisteredFiles('stylesheets');
}

function loadRegisteredScripts () {
  loadRegisteredFiles('scripts');
}

function loadLazyElmts (elmt) {
  const isLinkElmt = elmt.tagName.toLowerCase() === 'link';
  const url = isLinkElmt ? elmt.dataset.href : elmt.dataset.src;
  const urlset = isLinkElmt ? null : elmt.dataset.srcset;
  const callback = elmt.dataset.callback;

  if(isLinkElmt) {
    delete elmt.dataset.href;
  }
  else {
    delete elmt.dataset.src;
    delete elmt.dataset.srcset;
  }

  if(callback) {
    delete elmt.dataset.callback;
    elmt.onload = window[callback];
  }

  if(urlset) {
    elmt.srcset = urlset;
  }

  elmt.src = url;
}

function loadLazyStylesheets () {
  document.querySelectorAll('link[data-href]').forEach(loadLazyElmts);
}

function loadLazyScripts () {
  document.querySelectorAll('script[data-src]').forEach(loadLazyElmts);
}

function loadLazyIframes () {
  document.querySelectorAll('iframe[data-src]').forEach(loadLazyElmts);
}

function loadLazyImages () {
  document.querySelectorAll('img[data-src]').forEach(loadLazyElmts);
}

function loadEverything () {
  loadRegisteredStylesheets();
  loadRegisteredScripts();
  loadLazyStylesheets();
  loadLazyScripts();
  loadLazyIframes();
  loadLazyImages();
}

function eventTrigger () {
  loadEverything();
  document.removeEventListener('scroll', eventTrigger);
  document.removeEventListener('mousemove', eventTrigger);
  document.removeEventListener('touchstart', eventTrigger);
}

document.addEventListener('scroll', eventTrigger);
document.addEventListener('mousemove', eventTrigger);
document.addEventListener('touchstart', eventTrigger);

export {
  registerStylesheets,
  registerScripts,
  loadRegisteredStylesheets,
  loadRegisteredScripts,
  loadLazyStylesheets,
  loadLazyScripts,
  loadLazyIframes,
  loadLazyImages,
  loadEverything
};
