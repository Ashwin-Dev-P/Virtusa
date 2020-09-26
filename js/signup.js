var password = document.getElementById("password");
var cpassword = document.getElementById("passconfirmation");
var prob = document.getElementById("prob");
var prob1 = password.value;

function validate() {
  /*if (passl >= 6) {
    return true;
  }*/

  if (password.value != cpassword.value) {
    prob.innerHTML = "check your password";
    prob.style.color = "red";
    return false;
  } else if (prob1.length <= 8) {
    prob.innerHTML = "MINIMUM 8 CHARACTER REQUIRED";
    prob.style.color = "red";
    return false;
  } else if (prob1.search(/[0 - 9]/) == 0) {
    prob.innerHTML = "ATLEAST ONE NUMERICAL REQUIRED";
    prob.style.color = "red";
    return false;
  } else if (prob1.search(/[a-z]/) == 0) {
    prob.innerHTML = "ATLEAST ONE LOWER CASE REQUIRED";
    prob.style.color = "red";
    return false;
  } else if (prob1.search(/[A-Z]/) == 0) {
    prob.innerHTML = "ALTEAST ONE UPPER CASE REQUIRED";
    prob.style.color = "red";
    return false;
  } else if (prob1.search(/[!,@,#,$,%,&,*]/) == 0) {
    prob.innerHTML = "ATLEAST ONE SYMBOL REQUIRED";
    prob.style.color = "red";
    return false;
  }
  return true;
}
function visible() {
  var x = document.getElementById("password");
  var y = document.getElementById("show");
  var z = document.getElementById("hide");
  if (x.type === "password") {
    x.type = "text";
    y.style.display = "block";
    z.style.display = "none";
  } else {
    x.type = "password";
    y.style.display = "none";
    z.style.display = "block";
  }
}
function visible1() {
  var x = document.getElementById("passwordconfirmation");
  var y = document.getElementById("show1");
  var z = document.getElementById("hide1");
  if (x.type === "password") {
    x.type = "text";
    y.style.display = "block";
    z.style.display = "none";
  } else {
    x.type = "password";
    y.style.display = "none";
    z.style.display = "block";
  }
}
