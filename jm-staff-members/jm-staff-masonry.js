/**------------------------------------
 *    Javascript to setup masonry on
 * 		    staff grid view
 -------------------------------------*/
jQuery(document).ready(function(){
	jQuery('#jm-staff-grid').masonry({
    // options  
    itemSelector : ".staff-item" , 
    singleMode: true,
    isAnimated: true
  });
	
});
