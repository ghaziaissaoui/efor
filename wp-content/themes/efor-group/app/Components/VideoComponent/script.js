import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import YouTubePreviewLoop from '../../../front/abstract/youtube-api/youtube-preview-loop.js';
import { initYouTubeFullVideos } from '../../../front/abstract/youtube-api/youtube-full-video.js';
import videoPreview from '../../../front/components/video/video-preview';

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

const SELECTORS = {};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class VideoComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    
    new videoPreview({
      activeElementsSelector: '.video-item'
    })

    new YouTubePreviewLoop({
      activeElementsSelector: '.video-item'
    });

    initYouTubeFullVideos();
  }

  disconnectedCallback() {
    console.log('Disconnected:', this);
  }

  adoptedCallback() {
    console.log('Adopted:', this);
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue && oldValue !== newValue) {
      console.log('Attribute Changed:', name, oldValue, newValue);
    }
  }
}

/*
  • Private Functions
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('video-component', VideoComponent);

export default VideoComponent;
