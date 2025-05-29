function htmlToNodes (html) {
  const wrapper = document.createElement('div');
  wrapper.innerHTML = html.trim();

  const domNodes = [];

  for(let i = 0 ; i < wrapper.childNodes.length ; i++) {
    domNodes.push(wrapper.childNodes[i]);
  }

  return domNodes.length > 1
    ? Array.from(domNodes)
    : [domNodes[0]];
}

function htmlToElements (html) {
  const wrapper = document.createElement('div');
  wrapper.innerHTML = html.trim();

  const domElements = [];

  for(let i = 0 ; i < wrapper.children.length ; i++) {
    domElements.push(wrapper.children[i]);
  }

  return domElements.length > 1
    ? Array.from(domElements)
    : [domElements[0]];
}

export {
  htmlToNodes,
  htmlToElements
};
