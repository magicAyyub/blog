/* --------------
    Variables 
 --------------- */
 const navbar = document.querySelector('.nav__ul');
 const menu_btn = document.querySelector('#menu-btn');
 const dashbord_btn = document.querySelector('#dashbord-btn');
 const sideBar = document.querySelector('.dashboard aside');
 const alert_msg = document.querySelector('.alert__message.absolute');
 
 
 window.addEventListener("load", () =>{
    alert_msg.classList.add("fade-in");

    setTimeout(() =>{
        alert_msg.classList.add("fade-out");
    },5000);
   
});


 
 /* --------------
     fonctions 
  --------------- */
 function toggleNavBar(){
     menu_btn.classList.toggle('fa-times');
     navbar.classList.toggle('active');
 }
 
 function removeToggle(){
     navbar.classList.remove('active');
     menu_btn.classList.remove('fa-times');
 }
 function sideBarToggle(){
    dashbord_btn.classList.toggle('fa-angle-right');
    sideBar.classList.toggle('active');
 }
 function sideBarRemove(){
    dashbord_btn.classList.remove('fa-angle-right');
    sideBar.classList.remove('active');
 }
 
  
 /* -------------------
     Partie principale
  --------------------- */
  
 menu_btn.addEventListener('click',() =>{
     toggleNavBar();
     window.addEventListener("scroll",removeToggle);
     
 });

 dashbord_btn.addEventListener('click',()=>{
    sideBarToggle();
    window.addEventListener("scroll",sideBarRemove);
 });

 

