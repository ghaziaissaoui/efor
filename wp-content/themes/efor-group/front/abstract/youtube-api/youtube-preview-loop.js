import * as YouTubeAPI from './youtube-api.js';

const PREVIEW_LOOP_START = 10;
const PREVIEW_LOOP_DURATION = 5;

class YouTubePreviewLoop {
  constructor (options) {
    this.initYT()

    this.options = Object.assign({
      activeElementsSelector: '.youtube-preview-loop',
      loopContainerSelector: '.youtube-preview-loop',
      insertionPointSelector: '.youtube-preview-loop__insertion-point',
      coverElementSelector: '.youtube-preview-loop__cover-image'
    }, options);

    this.player = null;

    this._loopSeek = loopSeek.bind(this);
    this._clickHandler = onClickActiveElement.bind(this);

    this.activeElements.forEach(elmt => {
      elmt.addEventListener('mouseenter', this._mouseEnterHandler);
      elmt.addEventListener('mouseleave', this._mouseLeaveHandler);
      elmt.addEventListener('click', this._clickHandler);
    });
  }

  async initYT() {
    if(YouTubeAPI.getState() === 'empty') {
      await YouTubeAPI.init();
    }
  }

  rebind () {
    this.activeElements.forEach(elmt => {
      elmt.removeEventListener('mouseenter', this._mouseEnterHandler);
      elmt.removeEventListener('mouseleave', this._mouseLeaveHandler);
      elmt.removeEventListener('click', this._clickHandler);
    });
  }

  get activeElements () {
    return document.querySelectorAll(this.options.activeElementsSelector);
  }

  get currentLoopContainerElmt () {
    return this.currentActiveElement.querySelector(this.options.loopContainerSelector) || this.currentActiveElement;
  }

  get currentInsertionElmt () {
    return this.currentActiveElement.querySelector(this.options.insertionPointSelector) || this.currentActiveElement;
  }

  loadPlayer (insertionElmt, videoID) {
    this._videoID = videoID;

    const height = this.currentLoopContainerElmt.offsetHeight + 100;
    const width = height * (16 / 9);

    this.currentActiveElement && this.currentLoopContainerElmt.classList.add('-loading');

    // eslint-disable-next-line no-undef
    return new YT.Player(insertionElmt, {
      videoId: this._videoID,
      width: width,
      height: height,
      playerVars: {
        controls: 0,
        enablejsapi: 1,
        end: PREVIEW_LOOP_START + PREVIEW_LOOP_DURATION,
        fs: 0,
        iv_load_policy: 3,
        loop: 1,
        modestbranding: 1,
        origin: window.location.href,
        playsinline: 1,
        rel: 0,
        start: PREVIEW_LOOP_START,
        showinfo: 0
      },
      events: {
        onReady: (ev) => {
          ev.target.mute();

          const iframe = ev.target.getIframe();
          iframe.style.width = `${iframe.width}px`;
          iframe.style.height = `${iframe.height}px`;

          if(this.currentActiveElement) {
            this.play();
          }
          else {
            this.stop();
            this.removeFromDOM();
          }
        },
        onStateChange: (ev) => {
          // eslint-disable-next-line no-undef
          if(ev.data === YT.PlayerState.PLAYING) {
            if(this.currentActiveElement) {
              this.currentLoopContainerElmt.classList.remove('-loading');
              this.currentLoopContainerElmt.classList.add('-playing');
              document.body.classList.add('-playing');
            }
          }
          // eslint-disable-next-line no-undef
          else if(ev.data === YT.PlayerState.ENDED) {
            ev.target.seekTo(PREVIEW_LOOP_START, true);
          }
        }
      }
    });
  }

  play () {
    if(this.player && 'playVideo' in this.player) {
      this.player.playVideo();
      this._t = setTimeout(this._loopSeek, PREVIEW_LOOP_DURATION * 1000);
    }
  }

  rewind () {
    this.player.seekTo(PREVIEW_LOOP_START, true);
    this._t = setTimeout(this._loopSeek, PREVIEW_LOOP_DURATION * 1000);
  }

  stop () {
    if(this._t) {
      clearTimeout(this._t);
      this._t = null;
    }

    if(this.player && 'stopVideo' in this.player) {
      document.body.classList.remove('-playing');
      this.currentActiveElement && this.currentLoopContainerElmt.classList.remove('-playing');
      this.player.stopVideo();
      this.player.clearVideo();
    }
  }

  removeFromDOM () {
    if(this.player && 'destroy' in this.player) {
      this.player.destroy();
    }
  }
}

function loopSeek () {
  this.rewind();
}

function onClickActiveElement () {
  const activeElmt = this.currentActiveElement;

  if(activeElmt && activeElmt.classList.contains('youtube-full-video')) {
    activeElmt.removeEventListener('mouseenter', this._mouseEnterHandler);
    activeElmt.removeEventListener('mouseleave', this._mouseLeaveHandler);
    activeElmt.removeEventListener('click', this._clickHandler);
    this.currentLoopContainerElmt.classList.remove('-loading');
    this.stop();
    this.removeFromDOM();
    this.currentActiveElement = null;
  }
}

export default YouTubePreviewLoop;
