
// Function for the user profile that hides and reaveal the side navigation 

function showSideNav(e) {
    var sideNav = $('#sideNav');
    var sideIcon = $('#arrowIcon');
    if(e.name === 'chevron-back-sharp') {
        e.name = 'chevron-forward-sharp';
        sideNav.css('position','absolute');
        sideNav.css('left', '-185px');
        sideIcon.css('left', '12rem')
    }
    else {
        e.name = 'chevron-back-sharp';
        sideNav.css('position','relative');
        sideNav.css('left','0');
       sideIcon.css('left', '9rem');
    }
    
    
}
