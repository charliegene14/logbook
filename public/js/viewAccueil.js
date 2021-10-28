document.title = 'Bienvenue.';

const swiperTrusted = new Swiper('.swiper-trusted', {
	// Optional parameters
	direction: 'horizontal',
	effect: 'cube',
	cubeEffect: {
		shadow: false,
	  },
  
	// Navigation arrows
	navigation: {
	  nextEl: '.swiper-button-next-trusted',
	  prevEl: '.swiper-button-prev-trusted',
	},
});

const swiperTools = new Swiper('.swiper-hours', {
	// Optional parameters
	direction: 'horizontal',
	breakpoints: {
		360: {
			slidesPerView: 2,
		},
		480: {
			slidesPerView: 3,
		},
		660: {
			slidesPerView: 4,
		},
		870: {
			slidesPerView: 5,
		}
	},
  
	// Navigation arrows
	navigation: {
	  nextEl: '.swiper-button-next-hours',
	  prevEl: '.swiper-button-prev-hours',
	},
});

const swiperToolsNo = new Swiper('.swiper-toolsno', {
	// Optional parameters
	direction: 'horizontal',
	breakpoints: {
		360: {
			slidesPerView: 2,
		},
		480: {
			slidesPerView: 3,
		},
		660: {
			slidesPerView: 4,
		},
		870: {
			slidesPerView: 5,
		}
	},
  
	// Navigation arrows
	navigation: {
	  nextEl: '.swiper-button-next-toolsno',
	  prevEl: '.swiper-button-prev-toolsno',
	},
});