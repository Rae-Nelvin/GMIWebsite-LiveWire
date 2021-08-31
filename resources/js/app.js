require('./bootstrap');

import Alpine from 'alpinejs';
 // core version + navigation, pagination modules:
 import Swiper, { Navigation, Pagination } from 'swiper';
 // import Swiper and modules styles
 import 'swiper/css';
 import 'swiper/css/navigation';
 import 'swiper/css/pagination';

 // configure Swiper to use modules
 Swiper.use([Navigation, Pagination]);

 const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    slidesPerView : 4,
    spaceBetween : 30,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });

window.Alpine = Alpine;

Alpine.start();