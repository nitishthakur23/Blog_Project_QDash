const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

const openNav = () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
}

const closeNav = () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';
}



const checkScreenWidth = () => {
    if (window.innerWidth <= 1024) {
        openNavBtn.style.display = 'inline-block';
        closeNavBtn.style.display = 'none'; // Initial state
        navItems.style.display = 'none';

        openNavBtn.addEventListener('click', openNav);
        closeNavBtn.addEventListener('click', closeNav);
    } else {
        openNavBtn.style.display = 'none';
        closeNavBtn.style.display = 'none';

        // Ensure the navItems is always displayed when the screen is larger than 600px
        navItems.style.display = 'flex';

        // Remove event listeners when screen width is above 600px
        openNavBtn.removeEventListener('click', openNav);
        closeNavBtn.removeEventListener('click', closeNav);
    }
  

}

// Check screen width on initial load
checkScreenWidth();

// Check screen width on window resize
window.addEventListener('resize', checkScreenWidth);
