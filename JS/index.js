document.querySelector(".main-search-form").addEventListener("submit", function (event) {
    event.preventDefault();
    document.querySelector(".main-search-result").classList.add("visible");
    setTimeout(function () {
        document.querySelector(".main-search-result").classList.remove("visible");
    }, 3000);
});