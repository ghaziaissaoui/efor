import { getRouter } from './abstract/js-toolbox/router.js';

import './_generated-indexes/for-front-components.js';
import './_generated-indexes/for-app-components.js';
import routes from './_generated-indexes/for-front-routes.js';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// If you choose to exclude a route's js from the generated index,
// you have to import it manually:
// import someRoute './routes/some-route/some-route.js';

// Create router
export const router = getRouter({
  ...routes,
  // Add manually imported route files here
});

// React to the router's 'routed' events.
// One 'routed' event is dispatched for each matching route
document.addEventListener('routed', ev => {
  console.log(`Routed to ${ev.detail.route}, ${ev.detail.fn}`);
});

// Launch the router
window.addEventListener('load', () => {
  router.loadEvents();

  // If compiling in dev mode, import dev.js
  // import.meta.env is provided by Vite
  if(import.meta.env.DEV) {
    import('./dev.js').then(module => module.init());
  }
});

/*
  The end
  ---------- ---------- ---------- ---------- ----------
  It should not be necessary to add anything more from
  this point. Any new code should go either in an abstract
  lib, ui component or route file.
*/
