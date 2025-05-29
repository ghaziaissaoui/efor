import './dev.scss';
import { htmlToElements } from './abstract/js-toolbox/dom.js';

function showGrid (type = '') {
  const dataAttr = type === '' ? '' : `data-type="${type}"`;
  const containerClass = type === '' ? 'gs-container' : `gs-${type}-container`;
  const rowClass = type === 'flush' ? 'gs-flush-row' : 'gs-row';
  const columnClass = type === 'flush' ? 'gs-flush-column-1' : 'gs-column-1';
  const columnsHtml = `<div class="${columnClass}"><div></div></div>`.repeat(12);

  const template = `
    <div class="--front-grid-overlay" ${dataAttr}>
      <div class="${containerClass}">
        <div class="${rowClass}">
          ${columnsHtml}
        </div>
      </div>
    </div>
  `;

  const [elmt] = htmlToElements(template);

  document.body.appendChild(elmt);
}

function removeGrid (gridElmt) {
  gridElmt.remove();
}

function switchGrids (type, currentGridElmt) {
  const currentGridType = currentGridElmt.dataset.type;

  removeGrid(currentGridElmt);

  if(type !== currentGridType) {
    showGrid(type);
  }
}

function toggleGrid (type) {
  const gridElmt = document.querySelector('.--front-grid-overlay');

  if(gridElmt) {
    switchGrids(type, gridElmt);
  }
  else {
    showGrid(type);
  }
}

function init () {
  console.log('dev.js');

  const template = `
    <div class="--front-bar">
      <div class="--front-breakpoint-label"></div>
      <div class="--front-utils">
        <button class="--front-grid-toggle">Toggle Grid</button>
        <button class="--front-fluid-grid-toggle">Toggle Fluid Grid</button>
        <button class="--front-flush-grid-toggle">Toggle Flush Grid</button>
      </div>
    </div>
  `;

  const [elmt] = htmlToElements(template);
  const gridToggleElmt = elmt.querySelector('.--front-grid-toggle');
  const fluidGridToggleElmt = elmt.querySelector('.--front-fluid-grid-toggle');
  const flushGridToggleElmt = elmt.querySelector('.--front-flush-grid-toggle');

  gridToggleElmt.addEventListener('click', () => {
    toggleGrid();
  });

  fluidGridToggleElmt.addEventListener('click', () => {
    toggleGrid('fluid');
  });

  flushGridToggleElmt.addEventListener('click', () => {
    toggleGrid('flush');
  });

  document.body.appendChild(elmt);

  window.addEventListener('keydown', (ev) => {
    if (ev.keyCode === 71 && ev.ctrlKey) {
      toggleGrid();
    }

    if (ev.keyCode === 70 && ev.ctrlKey) {
      toggleGrid('fluid');
    }
  });
}

export { init };
