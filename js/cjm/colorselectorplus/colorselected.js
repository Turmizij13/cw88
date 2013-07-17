// Swatch Selector Javascript - Copyright 2011 CJM Creative Designs

document.observe("dom:loaded", function() {
	
	// If Custom Stock Status extension is installed and dynamic status change enabled, set vars
	if (dynamicStatus == 1) { var availTxt, shipTxt; }
	
	var firstAttribute = $$('.super-attribute-select').first().id;		

	// If the first option has swatches, disable unavailable swatches
	if ($('ul-' + firstAttribute)) {
		var theoptions = [],
			thisAttrib = $(firstAttribute),
			l = 0;
			
		// Get all available option values
		$(thisAttrib).select('option').each(function(item) {
			if (item.value) {
				theoptions.push(item.value); }
		});
		
		// Disable swatches that are not available
		$$('#ul-' + firstAttribute + ' .swatch').each(function(item) {
			if (theoptions[l]) {
				if (theoptions[l] === item.id) {
					$(item.id).removeClassName('disabledSwatch');
					l += 1;
				} else {
					$(item.id).addClassName('disabledSwatch'); }
			} else {
				$(item.id).addClassName('disabledSwatch'); }
		});
	}

	// Make the selects act as swatches
	$$('select').each(function(item) {
		if(item.hasClassName('super-attribute-select')){ setClickHandler(item); }
	});
	
	// Disable all swatches below the first selectable swatch
	$$('ul[id^="ul-attribute"]').each(function(item) {
		var attributeId = item.id.split('-')[1];
		if($(attributeId).disabled){
			$(item.id).select('img', 'div').invoke('addClassName', 'disabledSwatch'); }
	});

});


// Dropdown observer function
		
function setClickHandler(element) {
	element.onchange = function () {
		
		var id = this.options[this.selectedIndex].value,
			runMeArgs = [this.id, '', 'optionzero'],
			selectorid = this.id,
			selectors = $$('.super-attribute-select'),
			optionArr = [],
			l = 0,
			isSwatch = 0,
			theIndex = 0,
			nextSelect;
		
		// Decide if this attribute has swatches
		if($('ul-' + selectorid)){ isSwatch = 1; }
		
		// Set what the next attribute is and the index of the selected attribute
		$$('.super-attribute-select').each(function(item, index) {
			if(selectorid == item.id){
				theIndex = index; 
				if(selectors[index+1]){ nextSelect = selectors[index+1].id; }
			}
		});
		
		// If Please Select is selected
		if (!id) {
			
			// If this is a swatch attribute
			if (isSwatch == 1) {
			
				// Apply the onclick function
				colorSelected.apply(this, runMeArgs);
			
				if ($('ul-moreviews') !== null) {
					themoreviewimgs = $$('#ul-moreviews div');
					onloadMoreViews = $('onload-moreviews');
					selectedmoreviewtitle = $('moreviews-title');
					if (onloadMoreViews.select('li') != '') {
						onloadMoreViews.show(); }
				}
			
				// If there are moreviews displayed, display the more views title
				if (themoreviewimgs !== undefined && themoreviewimgs.length > 0) {
					visibleViews = $$('#ul-moreviews div[style=""]').length;
					if (visibleViews > 0) {
						selectedmoreviewtitle.show();
					} else {
						selectedmoreviewtitle.hide(); }
				}
			
			} else {
			
				// Disable all swatch attributes after the current attribute
				$$('.super-attribute-select').each(function(item, index) {
					if (index > theIndex){
						$$('#ul-' + item.id + ' .swatch').invoke('removeClassName', 'swatchSelected').invoke('addClassName', 'disabledSwatch'); }
				});
			}
		
		} else {
			
			// If this drop-down is for a swatch attribute, give it the same onclick
			if ($(id) && $(id) !== null) {
			
				clickHandler = $(id).onclick;
				clickHandler.apply(this);
		
			// If the next attribute is a swatch attribute, reset the swatches
			} else {
			
				// Disable all swatch attributes after the current attribute
				$$('.super-attribute-select').each(function(item, index) {
					if (index > theIndex){
						$$('#ul-' + item.id + ' .swatch').invoke('removeClassName', 'swatchSelected').invoke('addClassName', 'disabledSwatch'); }
				});
				
				// If the next attribute has swatches
				if($('ul-' + nextSelect)) {
			
					//Enable selected swatches
					$$('#ul-' + nextSelect + ' .swatch').invoke('removeClassName', 'disabledSwatch');
				
					// Get all available option values
					$(nextSelect).select('option').each(function(item) {
						if (item.value) {
							optionArr.push(item.value); }
					});
				
					// Disable swatches that are not available
					$$('#ul-' + nextSelect + ' .swatch').each(function(item) {
						if (optionArr[l]) {
							if (optionArr[l] === item.id) {
								$(item.id).removeClassName('disabledSwatch');
								l += 1;
							} else {
								$(item.id).addClassName('disabledSwatch'); }
						} else {
							$(item.id).addClassName('disabledSwatch'); }
					});
				}
			}
		}
		
		// If Custom Stock Status extension is installed and dynamic status change enabled
		if (dynamicStatus == 1) {
			
			if ($$('.availability')) { $$('.availability').invoke('update', spConfig.config.mainstock); }
			if ($$('.shipsin')) { $$('.shipsin').invoke('update', spConfig.config.mainship); }
		
			if (element.options[element.selectedIndex].config !== undefined && element.options[element.selectedIndex].config.shipsby !== undefined) {
				availTxt = element.options[element.selectedIndex].config.customstock;
				shipTxt = element.options[element.selectedIndex].config.shipsby;
				
				$$('.availability').invoke('update', availTxt);
				if ($$('.shipsin') !== null) {
					$$('.shipsin').invoke('update', shipTxt); }
			}  
		}
	};
}


// Main Swatch Function

function colorSelected(id, value, product_image_src, front_label, imageName) {
	//"use strict";
	
	var theswitchis = 'off',
	    howMany = '',
		switchCounter = 0,
		l = 0,
		nextAttribute = '',
		nextAttrib = [],
		theoptions = [],
		selectedmoreview = [],
		onloadMoreViews = [],
		moreviews = [],
		zoomDone = [],
		dropdownEl = $(id),
		i, dropdown, themoreviewimgs, textdiv, theattributeid, thedropdown, thetextdiv, dropdownval, base_image, theSwatch, selectedmoreviewtitle, visibleViews, isAswatch;
	
	// If the dropdown is disabled, do nothing because we are not allowed to select an option yet
	if (dropdownEl.disabled) { return; }
		
	// Get the swatch that was just clicked
	theSwatch = $$('#ul-' + id + ' li img[id="' + value + '"], div[id="' + value + '"]');
	/* this line add by henryzxj bof */
	jQuery(theSwatch[0]).parent('li.swatchContainer').addClass('selected').siblings('li.swatchContainer').removeClass('selected');
	/* this line add by henryzxj eof */
	// If swatch is disabled or already selected, do nothing
	if (theSwatch.invoke('hasClassName', 'disabledSwatch') == 'true' || theSwatch.invoke('hasClassName', 'swatchSelected') == 'true') { return; }
	
	// Set the base image and more views to the selected swatch
	if (value) {
		if (imageName !== 'nozoom') {
			if (product_image_src) {
				jQuery("#zoomWrapper a").hide();
				jQuery("#image" + imageName).show();
				jQuery("#anchor_image" + imageName).attr("style", "display:block");
				
				if (!zoomDone.in_array(imageName)) {
					jQuery("#anchor_image" + imageName).jqzoom(zoomOptions);
					zoomDone.push(imageName);
				}
			}
		} else {
			
			base_image = $('image');
			if (product_image_src && base_image && (base_image.src !== product_image_src)) {
				base_image.hide();
				Element.show.delay(0.3, 'loadingImage');
				base_image.src = product_image_src;
				base_image.onload = function(){
					Element.hide.delay(0.3, 'loadingImage');
  					base_image.appear({ duration: 0.25, from: 0.0, to: 1.0 }); };
			}
		}
		
		if ($('ul-moreviews') !== null) {
			themoreviewimgs = $$('#ul-moreviews div');
			onloadMoreViews = $('onload-moreviews');
			if (themoreviewimgs) {
				selectedmoreview = $$('#ul-moreviews div[id="moreview' + value + '"]');
				howMany = $$('#ul-moreviews div[id="moreview' + value + '"] li').length;
				selectedmoreviewtitle = $('moreviews-title'); }
			if (onloadMoreViews) {
				onloadMoreViews.hide(); }
		}
	}
		
	// ------------------------------------------------------------------------------------------
	// --- RESET ALL SWATCH BORDERS, DROPDOWNS, MORE VIEWS AND TEXT BELOW THE SELECTED SWATCH ---
	// ------------------------------------------------------------------------------------------
	
	// If Custom Stock Status extension is installed, reset the availability text
	if (dynamicStatus == 1) {
		if ($$('.availability')) { $$('.availability').invoke('update', spConfig.config.mainstock); }
		if ($$('.shipsin')) { $$('.shipsin').invoke('update', spConfig.config.mainship); }
	}
				
	// Go through every attribute on product
	$$('.super-attribute-select').each(function(item, index) {
		thedropdown = 'attribute' + item.id.replace(/[a-z]*/, '');
		isAswatch = 0;
		theattributeid = item.id.replace(/[a-z]*/, '');
		thetextdiv = 'divattribute' + theattributeid;
		ulId = 'ul-' + thedropdown;
		
		// If this attribute is a swatch attribute, set to yes
		if($('ul-' + thedropdown)){ isAswatch = 1; }
	
		// If we are on the selected swatch dropdown, turn the switch on
		if (id === thedropdown) {
			theswitchis = 'on'; } 
				
		// If we are either on the dropdown we selected the swatch from or a dropdown below
		if (theswitchis === 'on') {
			// If we are on the dropdown after the selected swatch dropdown, get the next attribute id
			if (switchCounter === 1) {
				if(isAswatch == 1){ nextAttribute = theattributeid; } else { nextAttribute = '' ; } 
			} 
			if (isAswatch == 1){
				dropdown = $(thedropdown);
				textdiv =  $(thetextdiv);	
				if (textdiv !== null) { textdiv.update(selecttitle); }
				
				dropdown.selectedIndex = 0;
			
				// Go through all the swatches of this attribute and reset
				$$('#' + ulId + ' ' + ' .swatch').invoke('removeClassName', 'swatchSelected');
			
				// Hide the more view images of the swatch
				$(thedropdown).select('option').each(function(option) {
					moreviews = $('moreview' + option.value);
					if (moreviews !== null) { moreviews.hide(); }
				});

				// Disable all swatches below the first selectable swatch
				if (switchCounter >= 1) {
					$$('#' + ulId + ' ' + ' .swatch').invoke('addClassName', 'disabledSwatch'); }
			}
			
			switchCounter += 1;
		}
	});
	
	// If there is only one attribute on this product, set the next attribute to none
	if (nextAttribute === null || nextAttribute === '') { nextAttribute = 'none'; }
			
	// ------------------------------------------------------------------------
	// ------------------- SELECT THE CORRECT SWATCH --------------------------
	// ------------------------------------------------------------------------
			
	if (value) {
		
		// Set the swatch and dropdown to selected option
		$(value).addClassName('swatchSelected');
		dropdownEl.value = value;
		
		// Set the title of the option
		if ($('div' + id) !== null) {
			if (front_label !== 'null') {
				$('div' + id).update(front_label);
			} else {
				$('div' + id).update(dropdownEl.options[dropdownEl.selectedIndex].text); }
		}
		
		// Show the correct more view images and if there are moreviews displayed, display the more views title
		if (selectedmoreview !== null && selectedmoreview !== undefined && howMany > 0) {
			selectedmoreviewtitle.show();
			selectedmoreview.invoke('show');
		} else {
			if(howMany > 0){ selectedmoreviewtitle.hide(); }
		}
		
		spConfig.configureElement(dropdownEl);
	}
	
	// If Custom Stock Status extension is installed and set to enable dynamic change
	if (dynamicStatus == 1) {
		// Set the availability text and shipping date when a swatch is clicked
		if (dropdownEl.options[dropdownEl.selectedIndex].config !== undefined && dropdownEl.options[dropdownEl.selectedIndex].config.shipsby !== undefined) {
			availTxt = dropdownEl.options[dropdownEl.selectedIndex].config.customstock;
			shipTxt = dropdownEl.options[dropdownEl.selectedIndex].config.shipsby;
				
			$$('.availability').invoke('update', availTxt);
			if ($$('.shipsin') !== null) {
				$$('.shipsin').invoke('update', shipTxt); }
		}  
   	}
   		
	// -------------------------------------------------------------------------
	// -------------------- HIDE UNAVAILABLE SWATCHES --------------------------
	// -------------------------------------------------------------------------
	
	// If there is more then one swatch attribute on this product
	if (nextAttribute !== 'none' && value) {
		
		// Set the next attributes dropdown
		nextAttrib = $('attribute' + nextAttribute);
		
		// Get all available option values
		$(nextAttrib).select('option').each(function(item) {
			if (item.value) {
				theoptions.push(item.value); }
		});

		// Disable swatches that are not available
		$$('#ul-attribute' + nextAttribute + ' .swatch').each(function(item) {
			if (theoptions[l]) {
				if (theoptions[l] === item.id) {
					$(item.id).removeClassName('disabledSwatch');
					l += 1;
				} else {
					$(item.id).addClassName('disabledSwatch'); }
			} else {
				$(item.id).addClassName('disabledSwatch'); }
		});
	}
	
	// Not sure if this is still needed
	//this.reloadPrice();
}