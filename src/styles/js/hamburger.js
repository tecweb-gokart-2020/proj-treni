var initial_height = document.getElementsByTagName("header")[0].style.height;
function displayNav() {
  var x = document.getElementById("header-nav-tools");
  var h = document.getElementsByTagName("header")[0];
  if (x.style.display === "block") {
    x.style.display = "none";
    h.style.height = initial_height;
  } else {
    x.style.display = "block";
    h.style.height = "225px";
  }
}
