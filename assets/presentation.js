import './styles/presentation.scss';
// import { createPopper } from '@popperjs/core';
import $ from 'jquery';
global.$ = $;
// import 'bootstrap';
import "@fortawesome/fontawesome-free/css/all.min.css";
import "@fortawesome/fontawesome-free/js/all.js";
// import './scripts/dropdown';
// import './scripts/intro.js';
// import './bootstrap';
// any CSS you import will output into a single css file (app.css in this case)

// start the Stimulus application
console.log('test');
var scrollSpy = new bootstrap.ScrollSpy(document.body, {
  target: '#list-example'
})

