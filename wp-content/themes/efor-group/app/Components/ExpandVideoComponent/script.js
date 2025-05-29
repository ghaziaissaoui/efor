import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { initYouTubeAutoplayVideos } from '../../../front/abstract/youtube-api/youtube-autoplay';

gsap.registerPlugin(ScrollTrigger)

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
  videoContainer: '.expand-video-component',
  videoItem: '.expand-video',
  videoItemRatioImg: '.expand-video .ratio-block'
};

const M_CLASSES = {};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class ExpandVideoComponent extends CEComponent {
  constructor() {
    super()
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);

    if (true === checkYoutubeCookie()) {
      initYouTubeAutoplayVideos()
    }

    window._axcb.push(function(axeptio) {
      axeptio.on('cookies:complete', function(choices) {
        if (true === choices.Youtube) {
          initYouTubeAutoplayVideos()
        }
      })
    });
    //videoReveal()
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
function checkYoutubeCookie()
{
  const value = `; ${document.cookie}`;
  const parts = value.split('axeptio_authorized_vendors=');
  if (parts.length === 2) {
    return parts.pop().split(';').shift().includes('Youtube');
  }
}

function videoReveal()
{
  const trigger = document.querySelectorAll(SELECTORS.videoContainer);

  trigger.forEach(item => {
    if (item) {
      if (window.screen.width <= 720) {
        gsap.to(item.querySelector(SELECTORS.videoItemRatioImg), {
          '--block-ratio': 'calc(56.25%)',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })

        gsap.to(item.querySelector(SELECTORS.videoItem), {
          maxWidth: '100%',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })
      } else if(window.screen.width <= 1280) {
        gsap.to(item.querySelector(SELECTORS.videoItemRatioImg), {
          '--block-ratio': 'calc(56.25% - 286px)',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 50%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })

        gsap.to(item.querySelector(SELECTORS.videoItem), {
          maxWidth: '100%',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 50%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })
      } else if (window.screen.width <= 1920) {
        gsap.to(item.querySelector(SELECTORS.videoItemRatioImg), {
          '--block-ratio': 'calc(56.25%)',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 50%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })

        gsap.to(item.querySelector(SELECTORS.videoItem), {
          maxWidth: '100%',
          duration: 1,
          stagger: 0.1,
          ease: 'none',
          scrollTrigger: {
            trigger: item,
            start: 'top 80%',
            end: 'top 10%',
            scrub: true,
            markers: false
          },
        })
      }
    }
  });
}

/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/

window.customElements.define('expand-video-component', ExpandVideoComponent);

export default ExpandVideoComponent;
