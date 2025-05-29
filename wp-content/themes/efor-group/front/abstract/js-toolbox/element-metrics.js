import viewportMetrics from './viewport-metrics.js';

/*
  Index
  ---------- ---------- ---------- ---------- ----------
  • Main class
  • Helper(s)
  • Event handler(s)
  • Export(s)
*/

/*
  • Main class
  ---------- ---------- ---------- ---------- ----------
*/

class ElementMetrics {
  constructor (elmt, args) {
    if(args === undefined) {
      args = {};
    }

    if(args.autoUpdate === undefined) {
      args.autoUpdate = true;
    }

    this.elmt = elmt;

    if(args.onBeforeUpdate) {
      this.onBeforeUpdate = args.onBeforeUpdate;
    }

    if(args.onUpdate) {
      this.onUpdate = args.onUpdate;
    }

    this.update();

    if(args.autoUpdate) {
      this.onResize = _onResize.bind(this);
      this.onScroll = _onScroll.bind(this);
      window.addEventListener('resize', this.onResize);
      this.elmt.addEventListener('scroll', this.onScroll);
    }
  }

  get width () { return this._width; }
  get height () { return this._height; }
  get scrollX () { return this._scrollX; }
  get scrollY () { return this._scrollY; }
  get scrollMaxX () { return this._scrollMaxX; }
  get scrollMaxY () { return this._scrollMaxY; }
  get localX () { return this._localX; }
  get localY () { return this._localY; }
  get globalX () { return this._globalX; }
  get globalY () { return this._globalY; }
  get entersAtScrollX () { return this._entersAtScrollX; }
  get leavesAtScrollX () { return this._leavesAtScrollX; }
  get entersAtScrollY () { return this._entersAtScrollY; }
  get leavesAtScrollY () { return this._leavesAtScrollY; }

  get elementIsInViewport () {
    var vx = this._globalX - viewportMetrics().scrollX,
      vy = this._globalY - viewportMetrics().scrollY;

    return vx < viewportMetrics().width
      && vx + this._width > 0
      && vy < viewportMetrics().height
      && vy + this._height > 0;
  }

  update () {
    this.onBeforeUpdate && this.onBeforeUpdate();

    this._width = this.elmt.offsetWidth;
    this._height = this.elmt.offsetHeight;
    this._scrollX = this.elmt.scrollLeft;
    this._scrollY = this.elmt.scrollTop;
    this._scrollMaxX = this.elmt.scrollWidth - this._width;
    this._scrollMaxY = this.elmt.scrollHeight - this._height;
    this._localX = this.elmt.offsetLeft;
    this._localY = this.elmt.offsetTop;
    this._globalX = getGlobalX(this.elmt);
    this._globalY = getGlobalY(this.elmt);
    this._entersAtScrollX = this._globalX - Math.min(this._globalX, viewportMetrics().width);
    this._leavesAtScrollX = this._globalX + this._width;
    this._entersAtScrollY = this._globalY - Math.min(this._globalY, viewportMetrics().height);
    this._leavesAtScrollY = this._globalY + this._height;

    this.onUpdate && this.onUpdate();

    return this;
  }

  tearDown () {
    if(this.onResize) {
      window.removeEventListener('resize', this.onResize);
    }

    if(this.onScroll) {
      this.elmt.removeEventListener('scroll', this.onScroll);
    }

    this.elmt = this._width = this._height = this._scrollX = this._scrollY = this._scrollMaxX = this._scrollMaxY = this._localX = this._localY = this._globalX = this._globalY = null;
    this._entersAtScrollX = this._leavesAtScrollX = this._entersAtScrollY = this._leavesAtScrollY = null;
    this.onBeforeUpdate = this.onUpdate = null;
  }
}

/*
  • Helper(s)
  ---------- ---------- ---------- ---------- ----------
*/

function getGlobalX (el) {
  return el.getBoundingClientRect().left + viewportMetrics().scrollX;
}

function getGlobalY (el) {
  return el.getBoundingClientRect().top + viewportMetrics().scrollY;
}

function elementMetrics (el, args) {
  if(el === window) {
    return viewportMetrics();
  }

  return new ElementMetrics(el, args);
}

/*
  • Event handler(s)
  ---------- ---------- ---------- ---------- ----------
*/

function _onResize () {
  this.update();
}

function _onScroll () {
  this._scrollX = this.elmt.scrollLeft;
  this._scrollY = this.elmt.scrollTop;
}

/*
  • Export(s)
  ---------- ---------- ---------- ---------- ----------
*/

export default elementMetrics;

export {
  getGlobalX,
  getGlobalY
};
