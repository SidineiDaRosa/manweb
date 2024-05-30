(function () {
  
    const menuToggle = document.querySelector('.menu-toggle');
    const body = document.querySelector('body');
    body.classList.toggle('hide-sidebar').valueOf;
    menuToggle.onclick = function (e) {
        const body = document.querySelector('body');
        body.classList.toggle('hide-sidebar');
    }

})()

