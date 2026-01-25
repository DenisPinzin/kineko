// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss'; 

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

const menu = document.querySelector('.menu')
const nav = document.querySelector('.links-menu')
let count = 0

//MENU BURGER

menu.addEventListener('click', function (menu){
    if (count == 0) {
        nav.classList.add('nav-menu')
        count = 1
        return
    } else if (count == 1) {
        nav.classList.remove('nav-menu')
        count = 0
        return
    }
})