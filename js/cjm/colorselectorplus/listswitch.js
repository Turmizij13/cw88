// Copyright CJM Creative Designs
// Function to switch list and grid view images

function listSwitcher(id, src) {
	base_image = $(id);
	if (src) { base_image.setAttribute("src", src); }
}