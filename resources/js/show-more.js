const readMoreBtn = document.querySelector(".more-text-btn");
const text = document.querySelector(".filters-group");
readMoreBtn.addEventListener("click", () => {
    text.classList.toggle("show-more");
    if (readMoreBtn.innerText === "Advanced Filter") {
        readMoreBtn.innerText = "Basic Filter";
    } else {
        readMoreBtn.innerText = "Advanced Filter";
    }
});
