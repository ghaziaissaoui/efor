import Greeting from './Greeting.jsx';

const { render, createElement, unmountComponentAtNode } = window.wp.element;

class GreetingElement extends HTMLElement {
  connectedCallback () {
    const props = Object.values(this.attributes).map(attribute => [attribute.name, attribute.value]);
    render(createElement(Greeting, Object.fromEntries(props)), this);
  }

  disconnectedCallback () {
    unmountComponentAtNode(Greeting);
  }
}

customElements.define('x-greeting', GreetingElement);

export default GreetingElement;
