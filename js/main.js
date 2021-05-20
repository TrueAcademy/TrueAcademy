/*-----------------signup page js------------------------*/
var modalbtn = document.querySelector('.modal_btn_teacher');
var modalcon = document.querySelector('.modal_teacher');
var modalclose = document.querySelector('.close_btn_teacher');

modalbtn.addEventListener('click', function () {
  modalcon.classList.add('active_form')
});

modalclose.addEventListener('click', function () {
  modalcon.classList.remove('active_form')
});
/*-----------------signup page js------------------------*/
var modalbtn2 = document.querySelector('.modal_btn_student');
var modalcon2 = document.querySelector('.modal_student');
var modalclose2 = document.querySelector('.close_btn_student');

modalbtn2.addEventListener('click', function () {
  modalcon2.classList.add('active_form')
});

modalclose2.addEventListener('click', function () {
  modalcon2.classList.remove('active_form')
});
/*-----------------signin page teacher js------------------------*/
var modalBtn3 = document.querySelector('.modal_btn_signin');
var modalCon3 = document.querySelector('.modal_signin_teacher');
var modalClose3 = document.querySelector('.close_btn_signin');


modalBtn3.addEventListener('click', function () {
  modalCon3.classList.add('active_signin')
});

modalClose3.addEventListener('click', function () {
  modalCon3.classList.remove('active_signin')
});
/*-----------------signin page teacher 2 for toggler span js------------------------*/
var modalBtn3 = document.querySelector('.modal_btn_signin_teacher');
var modalCon3 = document.querySelector('.modal_signin_teacher');
var modalClose3 = document.querySelector('.close_btn_signin');


modalBtn3.addEventListener('click', function () {
  modalCon3.classList.add('active_signin')
});

modalClose3.addEventListener('click', function () {
  modalCon3.classList.remove('active_signin')
});




