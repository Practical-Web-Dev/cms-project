document.addEventListener("DOMContentLoaded", function (){

//Tiny MCE Code
tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Aug 5, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
 
  });

});

//DOM Elements
const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
const registerForm = document.querySelector(".login-form");
const loginForm = document.getElementById("login-form-page");
console.log(registerForm);
console.log(loginForm);

//Event Listeners
mobileMenuBtn.addEventListener("click", openMobileNav);
registerForm.addEventListener("submit", validateRegistrationForm);
loginForm.addEventListener("submit", validateLoginForm);



//Functions
function openMobileNav() {
const mainNav = document.querySelector(".main-nav");
mainNav.classList.toggle("show");
}

function validateRegistrationForm (e) {

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

function validateLoginForm(e) {

const usernameError = document.getElementById("username-error");
const passwordError = document.getElementById("password-error");

usernameError.textContent = "";
passwordError.textContent = "";

let hasError = false;

const usernameInput = document.getElementById("username-input").value.trim();
const passwordInput = document.getElementById("password-input").value;

if (usernameInput.length < 3) {
  usernameError.textContent = "Please enter the correct username for this acccount";
  hasError = true;
}

if (passwordInput.length < 6) {
  passwordError.textContent = "Please enter the correct password for this account";
  hasError = true;
}

if (hasError) {
  e.preventDefault();
}

}

