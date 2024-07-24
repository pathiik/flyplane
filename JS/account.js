document.getElementById("account-type-left").addEventListener("click", toLoginType)
document.getElementById("login-type-change").addEventListener("click", toLoginType)
document.getElementById("account-type-right").addEventListener("click", toSignupType)
document.getElementById("signup-type-change").addEventListener("click", toSignupType)
function toLoginType() {
    document.querySelector(".account-type-signup").classList.add("hidden");
    document.getElementById("account-type-right").classList.remove("active");
    document.getElementById("account-type-left").classList.add("active");
    document.querySelector(".account-type-login").classList.remove("hidden");
}
function toSignupType() {
    document.querySelector(".account-type-login").classList.add("hidden");
    document.getElementById("account-type-left").classList.remove("active");
    document.getElementById("account-type-right").classList.add("active");
    document.querySelector(".account-type-signup").classList.remove("hidden");
}