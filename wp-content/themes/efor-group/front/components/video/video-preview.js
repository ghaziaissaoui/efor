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


/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class VideoPreviewComponent {
  constructor(options) {

    this.options = Object.assign({
      activeElementsSelector: '.video-preview',
      loopContainerSelector: '.video-preview',
      videoElementSelector: 'video',
      coverElementSelector: '.video-preview__cover-image'
    }, options);

    this._clickHandler = onClickActiveElement.bind(this);

    this.activeElements.forEach(elmt => {
      elmt.addEventListener('mouseenter', this._mouseEnterHandler);
      elmt.addEventListener('mouseleave', this._mouseLeaveHandler);
      elmt.addEventListener('click', this._clickHandler);
    });
  }

  static get observedAttributes() {
    return [];
  }

  get activeElements () {
    return document.querySelectorAll(this.options.activeElementsSelector);
  }

  get currentContainerElmt () {
    return this.currentActiveElement.querySelector(this.options.videoElementSelector) || this.currentActiveElement;
  }

  get currentLoopContainerElmt () {
    return this.currentActiveElement.querySelector(this.options.loopContainerSelector) || this.currentActiveElement;
  }

  play () {
    this.currentContainerElmt.play();

    this.currentLoopContainerElmt.classList.add('-playing');
    document.body.classList.add('-playing');
  }

  stop () {
    this.currentContainerElmt.pause();
    this.currentContainerElmt.currentTime = 0;

    this.currentActiveElement && this.currentLoopContainerElmt.classList.remove('-playing');
    document.body.classList.remove('-playing');
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

function onClickActiveElement () {
  const activeElmt = this.currentActiveElement;
  activeElmt.removeEventListener('mouseenter', this._mouseEnterHandler);
  activeElmt.removeEventListener('mouseleave', this._mouseLeaveHandler);
  this.currentLoopContainerElmt.classList.add('-playing-full');
  this.stop();
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

export default VideoPreviewComponent;
