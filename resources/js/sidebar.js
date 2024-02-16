const menuToggle = document.querySelector('.menu-toggle input');
const sidebar = document.querySelector('.wrap-sidebar .wrap-content-sidebar');

menuToggle.addEventListener('click', function(){
    sidebar.classList.toggle('show');
})p