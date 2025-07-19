//DOM Elements
const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
const loginForm = document.querySelector(".login-form");


//Event Listeners
mobileMenuBtn.addEventListener("click", openMobileNav);
loginForm.addEventListener("submit", validateForm);



//Functions
function openMobileNav() {
const mainNav = document.querySelector(".main-nav");
mainNav.classList.toggle("show");
}

function validateForm (e) {

//Select error messages
const usernameError = document.getElementById("username-error");
const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");
const confirmPasswordError = document.getElementById("confirm-password-error");

//Clear Error Messages
usernameError.textContent = "";
emailError.textContent = "";
passwordError.textContent = "";
confirmPasswordError.textContent = "";

//Check for Error
let hasError = false;

//Input DOM Elements
const usernameInput = document.getElementById("username-input").value.trim();
const emailInput = document.getElementById("email-input").value.trim();
const passwordInput = document.getElementById("password-input").value;
const confirmPasswordInput = document.getElementById("confirm-password-input").value;


//Regular Expressions (Regex)

//Username must be at least 3 chracters, letters numbers only
const usernamePattern = /^[a-zA-Z0-9]{3,}$/;
//Must have no whitespace, @ symbol, and a .com
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//Must be at least 6 chracters, one number, one special chracter
const passwordPattern = /^(?=.*\d)(?=.*[\W_]).{6,}$/;

//Check Username
if(!usernamePattern.test(usernameInput)) {
  usernameError.textContent = "Username must be at least 3 characters and only letters and numbers";
  hasError = true;
}

//Check Email
if(!emailPattern.test(emailInput)) {
  emailError.textContent = "Email must have no spaces, an @ and a .com";
  hasError = true;
}

//Check Password
if(!passwordPattern.test(passwordInput)) {
  passwordError.textContent = "Password must be at least 6 characters, include a number, and one special chracter";
  hasError = true;
}

//Check Confirm Password
if(passwordInput !== confirmPasswordInput) {
 confirmPasswordError.textContent = "Passwords do not match";
  hasError = true;
}

//Prevent form submission if input are incorrect
if (hasError) {
 e.preventDefault();
} else {
  alert("User has been registered!");
}

}


