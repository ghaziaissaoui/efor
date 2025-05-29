import CEComponent from '../../../front/abstract/js-toolbox/ce-component.js';
import _ from 'underscore';
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
  root: '.header-component',
  searchCloseBtn: '.--search-close',
  container: '.header-component-container',
  searchSection: '.header-component-search',
};

const M_CLASSES = {
  open: 'header-component--open',
  searchOpened: 'header-component-search--open',
  showMenu: '--show',
  activeMenuLink: 'navlink--active',
  disabledLinkColor: 'c-gray-40',
};

/*
 • Component Class
 ---------- ---------- ---------- ---------- ----------
 */

class HeaderComponent extends CEComponent {

  constructor() {
    super()
  }

  static get observedAttributes() {
    return ['data'];
  }

  get bodyElmt() {
    return document.querySelector('body');
  }

  get burgerElmt() {
    return this.dataset.burger ? this.querySelector(this.dataset.burger) : null;
  }

  get navCloseElmt() {
    return this.dataset.close ? this.querySelector(this.dataset.close) : null;
  }

  get navlinksElmt() {
    return this.dataset.navlinks ? [...this.querySelectorAll(this.dataset.navlinks)] : [];
  }

  get navMenusElmt() {
    return this.dataset.navMenu ? [...this.querySelectorAll(this.dataset.navMenu)] : [];
  }

  get navSubmenusElmt() {
    return this.dataset.navSubmenu ? [...this.querySelectorAll(this.dataset.navSubmenu)] : [];
  }

  get navMenuLinksElmt() {
    return this.dataset.navMenuLinks ? [...this.querySelectorAll(this.dataset.navMenuLinks)] : [];
  }

  get currentMenuElmt() {
    return this._currentMenuElmt;
  }

  get currentSubmenuElmt() {
    return this._currentSubmenuElmt;
  }

  get searchBtnElmt() {
    return this.dataset.searchBtn ? this.querySelector(this.dataset.searchBtn) : null;
  }

  get searchSectionElmt() {
    return this.dataset.searchElmt ? this.querySelector(this.dataset.searchElmt) : null;
  }

  get searchCloseBtnElmt() {
    return this.querySelector(SELECTORS.searchCloseBtn);
  }

  get previousScrollPos() {
    return this._previousScrollPos;
  }

  set currentMenuElmt(menuTarget) {
    const menuName = menuTarget?.dataset.menuName ?? '';
    this._currentMenuElmt = [...this.navMenusElmt].find(menu => menu.dataset.menuName === menuName);
  }

  set currentSubmenuElmt(submenuTargeted) {
    const submenuName = submenuTargeted?.dataset.submenuName ?? '';
    this._currentSubmenuElmt = [...this.navSubmenusElmt].find(menu => menu.dataset.submenuName === submenuName);
  }

  set previousScrollPos(pos) {
    this._previousScrollPos = pos;
  }

  connectedCallback() {
    this.countScroll = 0;
    this.burgerElmt?.addEventListener('click', handleBurgerClick.bind(this));
    this.navCloseElmt?.addEventListener('click', handleCloseNavClick.bind(this));
    this.searchBtnElmt?.addEventListener('click', handleSearchBtnClick.bind(this));
    this.searchCloseBtnElmt?.addEventListener('click', handleSearchCloseClick.bind(this));
    this.bodyElmt.addEventListener('click', handleBodyClick.bind(this));
    this.manageDesktopMenu();

    const handleScroll = () => {
      if (
        this.isScrollingDown() &&
        window.innerWidth <= 1000 &&
        window.scrollY > 100
      ) {
        this.style.transform = `translateY(-${this.offsetHeight}px)`;
      } else {
        this.style.transform = 'translateY(0)';
      }
    }

    const scrollThrottle = _.throttle(handleScroll, 500);
    window.addEventListener('scroll', scrollThrottle)

    var timer = null;
    window.addEventListener('scroll', () => {
      if (timer !== null) {
        clearTimeout(timer);
      }
      timer = setTimeout(() => {
        if (window.innerWidth <= 1000 && window.scrollY > 100) {
          this.style.transform = `translateY(-${this.offsetHeight}px)`;
        }
      }, 3000);
    }, false);

    window.addEventListener('resize', () => {
      this.manageDesktopMenu();
    })
  }

  manageDesktopMenu() {
    if (window.innerWidth > 1000) {
      this.bodyElmt.addEventListener('mouseover', handleBodyHover.bind(this));

      this.navlinksElmt.forEach(navlink => {
        navlink.addEventListener('mouseover', handleNavlinkHover.bind(this));
      });

      this.navMenuLinksElmt.forEach(navMenuLink => {
        navMenuLink.addEventListener('mouseover', handleNavMenulinkHover.bind(this));
      })
    }
  }

  openMenus(target) {
    this.currentMenuElmt = target;

    this.navlinksElmt.forEach(navlink => {
      navlink.classList.remove(M_CLASSES.activeMenuLink);
    });

    this.resetSubmenu();

    target.classList.add(M_CLASSES.activeMenuLink);

    this.navMenusElmt.forEach(menu => menu.classList.remove(M_CLASSES.showMenu));
    this.currentMenuElmt.classList.add(M_CLASSES.showMenu);

    setTimeout(() => {
      this.bodyElmt.classList.add(M_CLASSES.open);
    }, 300);
  }

  closeMenus() {
    this.navMenusElmt.forEach(menu => menu.classList.remove(M_CLASSES.showMenu));
    this.navlinksElmt.forEach(navlink => navlink.classList.remove(M_CLASSES.activeMenuLink));
    this.resetSubmenu();

    setTimeout(() => {
      this.bodyElmt.classList.remove(M_CLASSES.open);
    }, 200);
  }

  openSubmenus(target) {
    this.currentSubmenuElmt = target;

    this.navMenuLinksElmt.forEach(navMenuLink => {
      navMenuLink.classList.remove(M_CLASSES.disabledLinkColor);
      navMenuLink.classList.remove(M_CLASSES.activeMenuLink);
      if (this.currentSubmenuElmt) navMenuLink.classList.add(M_CLASSES.disabledLinkColor);
    });

    if (this.currentSubmenuElmt) target.classList.remove(M_CLASSES.disabledLinkColor);
    target.classList.add(M_CLASSES.activeMenuLink);

    this.navSubmenusElmt.forEach(menu => menu.classList.remove(M_CLASSES.showMenu));
    this.currentSubmenuElmt?.classList.add(M_CLASSES.showMenu);
  }

  resetSubmenu() {
    this.navMenuLinksElmt.forEach(navMenuLink => {
      navMenuLink.classList.remove(M_CLASSES.activeMenuLink);
      navMenuLink.classList.remove(M_CLASSES.disabledLinkColor);
    });

    this.currentSubmenuElmt?.classList.remove(M_CLASSES.showMenu);
  }

  hideSearch() {
    this.bodyElmt.classList.remove(M_CLASSES.searchOpened);
  }

  isScrollingDown() {
    let goingDown = false;
    const scrollPosition = window.scrollY;

    if (scrollPosition > this.previousScrollPos) {
      goingDown = true;
    }

    this.previousScrollPos = scrollPosition;

    return goingDown;
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
function handleNavlinkHover(e) {
  if (!e.currentTarget.dataset.menuName) {
    this.closeMenus();
    return;
  }

  this.openMenus(e.currentTarget);
}

function handleNavMenulinkHover(e) {
  this.openSubmenus(e.currentTarget);
}

function handleBodyClick(e) {
  if (
    (this.bodyElmt.classList.contains(M_CLASSES.open) || this.bodyElmt.classList.contains(M_CLASSES.searchOpened)) &&
    (!e.target.closest(SELECTORS.container) && !e.target.closest(SELECTORS.searchSection))
  ) {
    this.closeMenus();
    this.hideSearch();
  }
}

function handleBodyHover(e) {
  if (
    this.bodyElmt.classList.contains(M_CLASSES.open) &&
    !e.target.closest(SELECTORS.root)
  ) {
    this.closeMenus();
  }
}

function handleBurgerClick() {
  this.bodyElmt.classList.add(M_CLASSES.open);
}

function handleCloseNavClick() {
  this.bodyElmt.classList.remove(M_CLASSES.open);
}

function handleSearchBtnClick() {
  this.bodyElmt.classList.add(M_CLASSES.searchOpened);
  this.closeMenus();
}

function handleSearchCloseClick() {
  this.hideSearch();
}

/*
 • Init and Exports
 ---------- ---------- ---------- ---------- ----------
 */

window.customElements.define('header-component', HeaderComponent);

export default HeaderComponent;
