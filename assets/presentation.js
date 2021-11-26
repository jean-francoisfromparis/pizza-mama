import './styles/presentation.scss';
import $ from 'jquery';
global.$ = $;

import "@fancyapps/ui/dist/fancybox.css";
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
// import { createPopper } from '@popperjs/core';

// import 'bootstrap';
import "@fortawesome/fontawesome-free/css/all.min.css";
import "@fortawesome/fontawesome-free/js/all.js";
// import './scripts/dropdown';
// import './scripts/intro.js';
// import './bootstrap';
// any CSS you import will output into a single css file (app.css in this case)

// start the Stimulus application

var scrollSpy = new bootstrap.ScrollSpy(document.body, {
  target: '#list-example'
})

Fancybox.bind("[data-fancybox]", {
  // Your options go here
});


// console.log('test');