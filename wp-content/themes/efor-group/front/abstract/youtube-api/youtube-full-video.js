import UIComponent from '../js-toolbox/ui-component.js';
import * as YouTubeAPI from './youtube-api.js';

class YouTubeFullVideo extends UIComponent {
  constructor (elmt) {
    super(elmt);

    this.player = null;

    this.initYT();

    this.elmt.addEventListener('click', onClick.bind(this));
  }

  async initYT() {
    if(YouTubeAPI.getState() === 'empty') {
      await YouTubeAPI.init();
    }
  }

  get insertionElmt () {
    return this.elmt.querySelector('.youtube-full-video__insertion-point');
  }

  loadPlayer (videoID) {
    this._videoID = videoID;

    const insertionElmt = this.insertionElmt;
    const height = insertionElmt.offsetHeight;
    const width = height * (16 / 9);

    this.elmt.classList.add('-loading');

    // eslint-disable-next-line no-undef
    return new YT.Player(insertionElmt, {
      videoId: this._videoID,
      width: width,
      height: height,
      playerVars: {
        controls: 1,
        enablejsapi: 1,
        fs: 0,
        iv_load_policy: 3,
        loop: 1,
        modestbranding: 1,
        origin: window.location.href,
        playsinline: 1,
        rel: 0,
        showinfo: 0
      },
      events: {
        onReady: (ev) => {
          const iframe = ev.target.getIframe();
          iframe.style.width = '100%';
          iframe.style.height = '100%';

          this.elmt.dataset.youtubeFullVideoId = 'added';
          this.play();
        },
        onStateChange: (ev) => {
          // eslint-disable-next-line no-undef
          if(ev.data === YT.PlayerState.PLAYING) {
            this.elmt.classList.remove('-loading');
            this.elmt.classList.add('-playing');
          }
        }
      }
    });
  }

  play () {
    if(this.player && 'playVideo' in this.player) {
      this.player.playVideo();
    }
  }

  stop () {
    if(this._t) {
      clearTimeout(this._t);
      this._t = null;
    }

    if(this.player && 'stopVideo' in this.player) {
      this.elmt.classList.remove('-playing');
      this.player.stopVideo();
    }
  }

  removeFromDOM () {
    if(this.player && 'destroy' in this.player) {
      this.player.destroy();
    }
  }
}

function onClick () {
  const videoID = this.elmt.dataset.youtubeFullVideoId;

  if(videoID) {
    this.player = this.loadPlayer(videoID.trim());
  }
}

function init (root) {
  return Array.from((root || document).querySelectorAll('.youtube-full-video')).map(elmt => {
    return new YouTubeFullVideo(elmt);
  });
}

export default YouTubeFullVideo;

export { init as initYouTubeFullVideos };
