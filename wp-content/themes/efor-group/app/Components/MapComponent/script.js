import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import Swiper, { Navigation } from 'swiper';

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
  slider: '.map-slider',
  accordionItem: '.accordion .item',
  positionSidebar: '.map .accordion.accordion--desktop .item .implantation',
  accordionItemContent: '.item__content',
  implantation: '.implantation',
  implantationTitle: '.implantation-title',
  markers: '.leaflet-marker-icon',
};

const M_CLASSES = {
  accordionItemOpen: 'item--open',
};

/*
  • Component Class
  ---------- ---------- ---------- ---------- ----------
*/

class MapComponent extends CEComponent {
  constructor() {
    super()

    // map Init
    setTimeout(() => { mapInit.call(this) }, (100))
  }

  static get observedAttributes() {
    return [];
  }

  connectedCallback() {
    console.log('Connected:', this);
    // Slider on mobile for accordion item
    const mdBreakpoint = window.matchMedia('(max-width: 720px)');
    const trigger = document.querySelectorAll(SELECTORS.slider);

    if (mdBreakpoint.matches) {
      trigger.forEach(item => {
        if (item) {
          new Swiper(item, {
            modules: [Navigation],
            slidesPerView: 'auto',
            loop: false,
            spaceBetween: 16
          });
        }
      });
    }
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

function mapInit() {
  const coordinates = JSON.parse(this.dataset.coordinates);
  const key = this.dataset.api_key;
  const mapId = this.dataset.map_id;
  const implantation = document.querySelectorAll(SELECTORS.implantation);
  let mapZoom = 3;
  const mdBreakpoint = window.matchMedia('(max-width: 560px)');
  if (mdBreakpoint.matches) {
    mapZoom = 5
  }
  let map = L.map('map').setView([46.884119, 2.820743], mapZoom);
  let popup = L.popup();

  // Init map
  L.maplibreGL({
    maxZoom: 19,
    attribution: '\u003ca href="https://www.maptiler.com/copyright/" target="_blank"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href="https://www.openstreetmap.org/copyright" target="_blank"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e',
    style: `https://api.maptiler.com/maps/${mapId}/style.json?key=${key}`
  }).addTo(map);

  // Style for markers on map
  const customMarker = L.icon({
    iconUrl: '/wp-content/themes/efor-group/front/public/images/marker.png',
    iconSize: [34, 38],
    iconAnchor: [17, 46],
    shadowAnchor: [4, 62],
    popupAnchor: [-3, -76],
  });

  // Zoom Map by filter continent
  const continentTabs = document.querySelectorAll('.continent_list .tab-btn');

  continentTabs.forEach(tab => {
    tab.addEventListener('click', () => {

    const coords = JSON.parse(tab.dataset.coords);

    if (coords) {
      map.flyTo([coords.lat, coords.lng], coords.zoom);

      // Toggle "active" class
      continentTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    }
    });
  });

  // Add marker on map
  coordinates.forEach(marker => {
    let m = L.marker([marker[1], marker[2]], { icon: customMarker }).addTo(map);

    if (m) {
      m.bindPopup(popup)
      m._icon.setAttribute('id', marker[0])

      m.addEventListener('click', (ev) => {
        map.flyTo(ev.latlng, 16)
      })


      // On click on accordion item fly to marker associated
      implantation.forEach(place => {
        place.classList.remove('place--active')
        place.addEventListener('click', () => {
          implantation.forEach(el => el.classList.remove('place--active'))
          place.classList.add('place--active')
          const placeId = place.dataset.id
          const implantationTitle = place.querySelector(SELECTORS.implantationTitle).innerHTML
          const iconId = m._icon.id

          coordinates.forEach(coord => {
            const coordId = coord[0]
            let lat = coord[1];
            let lgn = coord[2];

            if (coordId == placeId && coordId == iconId) {
              map.flyTo([lat, lgn], 16);
              popup.setContent(`<p>${implantationTitle}</p>`)
              m.bindPopup(popup).openPopup();
            }
          })
        })
      })

      // On click on marker open accordion item associated
      document.querySelectorAll(SELECTORS.markers).forEach(icon => {
        icon.addEventListener('click', (ev) => {
          const mId = ev.target.getAttribute('id')
          const accordions = document.querySelectorAll(SELECTORS.accordionItem);

          //close all accordion (region)
          accordions.forEach(accordion => {
            accordion.classList.remove(M_CLASSES.accordionItemOpen)
            const accordionItemContent = accordion.querySelector(SELECTORS.accordionItemContent)
            accordionItemContent.style.maxHeight = '';
          })
          implantation.forEach(el => { el.classList.remove('place--active') })

          //get the card by id
          const card = document.querySelector(`[data-id="${mId}"]`);
          const cardTitle = card.querySelector(SELECTORS.implantationTitle).innerHTML
          card.classList.add('place--active')
          popup.setContent(`<p>${cardTitle}</p>`)
          setTimeout(() => {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }, 300)

          //get the region item by card
          const accordionItem = card.closest(SELECTORS.accordionItem)

          //open the previously getted region
          accordionItem.classList.add(M_CLASSES.accordionItemOpen);
          const accordionItemContent = accordionItem.querySelector(SELECTORS.accordionItemContent)
          accordionItemContent.style.maxHeight = accordionItemContent.scrollHeight + 'px';
        })
      })
    }
  })
}
/*
  • Event Handlers
  ---------- ---------- ---------- ---------- ----------
*/

/*
  • Init and Exports
  ---------- ---------- ---------- ---------- ----------
*/
window.customElements.define('map-component', MapComponent);

export default MapComponent;
