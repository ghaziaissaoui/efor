const API_URL = 'https://www.youtube.com/iframe_api';
const onAPIReady = [];

let initialized = false;
let ready = false;
let resolveFunction = null;

function onYouTubeIframeAPIReady () {
  ready = true;

  for(const callback of onAPIReady) {
    callback();
  }

  onAPIReady.length = 0;

  if(resolveFunction) {
    resolveFunction();
    resolveFunction = null;
  }
}

function addReadyCallback (callback) {
  onAPIReady.push(callback);

  if(initialized && ready) {
    onYouTubeIframeAPIReady();
  }
}

function init (callback) {
  if(initialized) {
    if(callback) {
      addReadyCallback(callback);
      onYouTubeIframeAPIReady();
    }

    return Promise.resolve();
  }
  else {
    return new Promise((resolve, reject) => {
      resolveFunction = resolve;

      callback && addReadyCallback(callback);
      window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;

      const tag = document.createElement('script');
      tag.src = API_URL;

      const firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      setTimeout(() => {
        reject();
      }, 10000);

      initialized = true;
    });
  }
}

function getState () {
  if(ready) {
    return 'ready';
  }

  if(initialized) {
    return 'initialized';
  }

  return 'empty';
}

export default init;

export {
  init,
  addReadyCallback,
  getState
};
