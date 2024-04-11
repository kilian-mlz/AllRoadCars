onscroll = (event) => {
    if(window.scrollY > 5 && !document.querySelector('header').classList.contains('sticky')) {
        document.querySelector('header').classList.add('sticky');
        document.querySelector('.pNavbar').classList.add('pDisplay');
    }
    if(window.scrollY < 6) {
        document.querySelector('header').classList.remove('sticky');
        document.querySelector('.pNavbar').classList.remove('pDisplay');
    }
};