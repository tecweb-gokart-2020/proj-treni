function displayNav() {
  var x = document.getElementById("header-nav-tools");
  var h = document.getElementsByTagName("header")[0];
  if (x.style.display === "block") {
    x.style = "";
    h.style = "";
  } else {
    x.style.display = "block";
    h.style.height = "225px";
  }
}
