import UIComponent from '../../abstract/js-toolbox/ui-component.js';
import {initAccordion} from '../../components/accordion/accordion.js';
import {cssVhFix} from '../../abstract/css-vh-fix/css-vh-fix.js';
import initCollapsibles from '../../components/collapsible/collapsible.js';
import {loadAxeptio} from '../../components/consentAxeptio/consentAxeptio';
import Swiper from 'swiper';


// If you choose to exclude a component's js from the generated index,
// you have to import it manually:
// import './routes/my-component/my-component.js';
// or, if it's not based on a custom element:
// import { initMyComponents } './routes/my-component/my-component.js';

export default {
  // The init() function is called on page load.
  initCommons(root) {
    initAccordion(root);
    initCollapsibles(root);
  },

  init() {
    loadAxeptio();
    // Fix for crappy vh size on iOS
    cssVhFix();
    this.initCommons();

    // Some helpers
    const replaceClass = (elmt, remove, add) => {
      for (const item of Array.from(elmt.classList)) {
        // remove is a function returning a boolean
        if (remove(item)) {
          elmt.classList.remove(item);
        }
      }

      // add is a an array of strings
      elmt.classList.add.apply(elmt.classList, add);
    };

    const isColorClass = item => item.startsWith('bg-') || item.startsWith('c-');

    // Sendify events
    document.querySelectorAll('.sendify-optin-form').forEach(component => {
      const newsletterCpt = UIComponent.get(component)
      newsletterCpt.on('validate', ev => console.log(ev.detail))
    })

    // Ajax Buttons events (via <click-fetch> custom elements)
    const AJAX_OUTPUT_SELECTOR = '.ajax-output';

    window.addEventListener('beforeClickFetch', ev => {
      const outputElmt = ev.detail.elmt.closest('div').nextElementSibling.querySelector(AJAX_OUTPUT_SELECTOR);
      replaceClass(outputElmt,
        isColorClass,
        ['bg-gray-40', 'c-black']
      );
    });

    window.addEventListener('clickFetchComplete', ev => {
      const outputElmt = ev.detail.elmt.closest('div').nextElementSibling.querySelector(AJAX_OUTPUT_SELECTOR);
      outputElmt.innerHTML = ev.detail.data || 'Error';

      if (ev.detail.success) {
        replaceClass(outputElmt,
          isColorClass,
          ['bg-green', 'c-black']
        );
      }
    });

    window.addEventListener('clickFetchError', ev => {
      const outputElmt = ev.detail.elmt.closest('div').nextElementSibling.querySelector(AJAX_OUTPUT_SELECTOR);
      replaceClass(outputElmt,
        isColorClass,
        ['bg-pink', 'c-black']
      );
    });

    if (document.body.classList.contains('template-implantations')) {
      const buttons = document.querySelectorAll('.tab-btn');
      const contents = document.querySelectorAll('.tab-content');

      buttons.forEach(button => {
        button.addEventListener('click', () => {
          // Remove active classes
          buttons.forEach(btn => btn.classList.remove('active'));
          contents.forEach(content => content.classList.remove('active'));

          // Add active class to clicked button and related content
          button.classList.add('active');
          document.getElementById(button.dataset.tab).classList.add('active');
        });
      });



      document.querySelectorAll('.accordion-toggle').forEach(button => {
        button.addEventListener('click', () => toggleAccordion(button));
      });

      const mdBreakpoint = window.matchMedia('(max-width: 720px)');
      const trigger = document.querySelectorAll('.map-slider-accordion');

      if (mdBreakpoint.matches) {
        trigger.forEach(item => {
          if (item) {
            new Swiper(item, {
              slidesPerView: 'auto',
              loop: false,
              spaceBetween: 16
            });
          }
        });
      }
    }

    // Reacting to first DemoComponent instance actions
    const firstDemoComponent = document.querySelector('.demo-component');

    if (firstDemoComponent) {
      firstDemoComponent.on('changeMode', ev => {
        document.body.classList.toggle('--dark-mode', ev.detail.mode === 'dark');
      });
    }

    // Reacting to first Dummy instance actions
    // UIComponent.get returns the component instance
    // for a given element.
    const firstDummy = document.querySelector('.dummy');

    if (firstDummy) {
      firstDummy.on('increment', (ev) => {
        console.log('Incrementing first dummy');
        console.log(ev.detail.component);
      });

      firstDummy.on('reset', (ev) => {
        console.log('Resetting first dummy');
        console.log(ev.detail.component);
      });
    }
  },

  // The finalize() function is called on page load,
  // after all the init() functions have been called.
  // Remove if not needed.
  finalize() {
    //
  }


};

function updateParentHeights(el) {
  let parent = el.parentElement;
  while (parent) {
    if (parent.classList.contains('accordion-content')) {
      parent.style.maxHeight = parent.scrollHeight + 'px';
    }
    parent = parent.parentElement;
  }
}

function closeOtherAccordions(currentButton) {
  const currentLevel = currentButton.closest('.accordion-content') || document;
  const buttons = currentLevel.querySelectorAll('.accordion-toggle');

  buttons.forEach(button => {
    if (button !== currentButton) {
      const content = button.nextElementSibling;
      if (content && content.classList.contains('accordion-content')) {
        button.classList.remove('active');
        content.classList.remove('active');
        content.style.maxHeight = null;

        // Close nested inside
        const nestedToggles = content.querySelectorAll('.accordion-toggle.active');
        nestedToggles.forEach(nested => {
          nested.classList.remove('active');
          const nestedContent = nested.nextElementSibling;
          if (nestedContent) {
            nestedContent.classList.remove('active');
            nestedContent.style.maxHeight = null;
          }
        });
      }
    }
  });
}

function toggleAccordion(button) {
  const content = button.nextElementSibling;
  const isOpen = content.classList.contains('active');

  closeOtherAccordions(button);

  if (isOpen) {
    button.classList.remove('active');
    content.classList.remove('active');
    content.style.maxHeight = null;
  } else {
    button.classList.add('active');
    content.classList.add('active');

    // Temporarily set no max-height to get scrollHeight
    content.style.maxHeight = content.scrollHeight + 'px';

    // 🪄 Recalculate parent heights to include expanded child
    requestAnimationFrame(() => updateParentHeights(content));
    setTimeout(() => updateParentHeights(content), 500); // In case content has transition
  }
}
