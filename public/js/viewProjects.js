let slide = document.getElementsByClassName("previewProject");
let slideIndex = 1;
showSlide(slideIndex);

function changeSlide(n)
{
	showSlide(slideIndex += n);
}

function showSlide(n)
{
	let i;

	if (n > slide.length)
	{
		slideIndex = 1;
	}

	if (n < 1)
	{
		slideIndex = slide.length;
	}
	 
	for (i = 0; i < slide.length; i++)
	{
	   	slide[i].classList.remove('current');
	}

	slide[slideIndex-1].classList.add('current');
}