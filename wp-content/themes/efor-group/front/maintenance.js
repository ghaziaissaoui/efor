const root = document.documentElement;
const slideElementsDisplayed = getComputedStyle(root).getPropertyValue('--slide-elements-displayed');
const slideContent = document.querySelector('.slide-content');

root.style.setProperty('--slide-elements', slideContent.children.length);

for(let i=0; i<slideElementsDisplayed; i++) {
  slideContent.appendChild(slideContent.children[i].cloneNode(true));
}
