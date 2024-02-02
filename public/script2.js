
// Function for the user profile that hides and reaveal the side navigation 

function showSideNav(e) {
    var sideNav = $('#sideNav');
   
    if(e.name === 'chevron-back-sharp') {
        e.name = 'chevron-forward-sharp';
        sideNav.css('position','absolute');
        sideNav.css('left','-190px');
    }
    else {
        e.name = 'chevron-back-sharp';
        sideNav.css('left','0');
       
    }
    
    
}
