
const sidebar = document.querySelector('aside'); 
const showSidebarBtn = document.querySelector('#show__sidebar-btn'); 
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn'); 



//showing Side bar for mobile devices for dashboards
const showSidebar = () =>{
    sidebar.style.left='0';
    showSidebarBtn.style.display='none';
    hideSidebarBtn.style.display='inline-block';
}

//Hiding Side bar for mobile devices for dashboards
const hideSidebar = () =>{
    sidebar.style.left='-100%';
    showSidebarBtn.style.display='inline-block';
    hideSidebarBtn.style.display='none';
}

const checkscreen = () => {
  
    if (window.innerWidth <= 600) {
        showSidebarBtn.style.display = 'inline-block'; // Initial state
        hideSidebarBtn.style.display = 'none';

        showSidebarBtn.addEventListener('click', showSidebar);
        hideSidebarBtn.addEventListener('click', hideSidebar);
    } else {
        showSidebarBtn.style.display = 'none';
        hideSidebarBtn.style.display = 'none'; 

        showSidebarBtn.removeEventListener('click', showSidebar);
        hideSidebarBtn.removeEventListener('click', hideSidebar);
    }
}

// Check screen width on initial load
checkscreen();

// Check screen width on window resize
window.addEventListener('resize', checkscreen);
