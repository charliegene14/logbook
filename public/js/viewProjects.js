document.title = 'Portfolio.';

const swiper = new Swiper('.swiper', {
	// Optional parameters
	direction: 'horizontal',
	centeredSlides: true,
	spaceBetween: 32,
  
	// If we need pagination
	pagination: {
	  el: '.swiper-pagination',
	  type: 'progressbar',
	},
  
	// Navigation arrows
	navigation: {
	  nextEl: '.swiper-button-next',
	  prevEl: '.swiper-button-prev',
	},
});

