// Collecting DOM for the Mobile friendly interface
const TogglerBtn = document.getElementById("toggleIcon");
const Navbar = document.getElementById("navbar");

//FOR The Toggle Button when clicked on
TogglerBtn.addEventListener("click", () => {
  Navbar.classList.toggle("show");
  TogglerBtn.classList.toggle("show");
  TogglerBtn.style.right = "3%";
});

//when a link is clicked, i want the toggle menu to disappear
document.querySelectorAll("li").forEach((n) =>
  n.addEventListener("click", () => {
    Navbar.classList.remove("show");
    TogglerBtn.classList.remove("show");
  })
);
