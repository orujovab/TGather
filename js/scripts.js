if (typeof(Storage) !== "undefined") {
  var current = localStorage.recent;
  if (current) {
      // Hide content
      var tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      } // Remove Active Class 
      var tablink = document.getElementsByClassName("tablink");
      for (i = 0; i < tablink.length; i++) {
          tablink[i].classList.remove("active");
      } // Show Appropriate Content + Add Active Class to appropriate tab
      if (current == "link1")
          document.getElementById("home").style.display = "block";
      else if(current == "link2")
          document.getElementById("signin").style.display = "block";
      else
          document.getElementById("signup").style.display = "block";
      document.getElementById(current).classList.add("active");
  }
}

function openTab(evt, choice) {
  // Hide All Content
  var tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  } // Remove Active Class
  var tablink = document.getElementsByClassName("tablink");
  for (i = 0; i < tablink.length; i++) {
      tablink[i].classList.remove("active");
  } // Show Appropriate Content + Add Active Class to appropriate tab
  document.getElementById(choice).style.display = "block";
  evt.currentTarget.classList.add("active");
  // Save
  if (typeof(Storage) !== "undefined") {
      localStorage.recent = evt.currentTarget.getAttribute('id');
  }
}

function validateLogin() {
  clearRequiredFields();
  var required = document.getElementsByClassName("required");
  var username = document.getElementById("loginusername").value;
  var password = document.getElementById("loginuserpass").value;
  var result = true;
  if (username == "") {
      required[0].innerHTML = "This field cannot be empty.";
      result = false;
  } 
  
  if (password == "") {
      required[1].innerHTML = "This field cannot be empty.";
      result = false;
  }
  return result;
}

function validateRegister() {
  clearRequiredFields();
  var error;
  var name = document.getElementById("name").value;
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var cpassword = document.getElementById("cpassword").value;
  var email = document.getElementById("email").value;
  var result = true;
  if (name == "" || email == "" || username == "" || password == "" || cpassword == "") {
      error.innerHTML = "This field cannot be empty.";
      result = false;
  }
  if (!validateEmail(email)) {
    error.innerHTML = "Invalid Email Format.";
    result = false;
  }
  
  if (password != "" && cpassword != "" && password != cpassword) {
      error.innerHTML = "Passwords doesn't match.";
      result = false;
  }
  return result;
}

function clearRequiredFields() {
  var required = document.getElementsByClassName("required");
  for (i = 0; i < required.length; i++) {
      required[i].innerHTML = "";
  }
}

function validateEmail(email) {
  var emailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\"[^\s@]+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (!email.match(emailformat))
      return false;
  return true;
}



function password_show_hide() {
 var x = document.getElementById("password"); //id of password field
 var show_eye = document.getElementById("show_eye");  //element id is "show-eye"(means when user clicks on show eye button)
 var hide_eye = document.getElementById("hide_eye");
 hide_eye.classList.remove("d-none");
 if (x.type === "password") {  //if the type of text in password field was pointer it will become a text type
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
 } else {  //in other case, type will become a password type
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
 }
}


/* Email Format
-----------------> Start <-------------------------------
Matching the beginning of a regular expression --->      /^
-------------------> Local Part <---------------------------
Doesn't Start with a Special Character --->      [^<>()[\]\\.,;:\s@\"]+
Start with any Character Else --->   (\.[^<>()[\]\\.,;:\s@\"]+)*
Or Anything between Quotes ---->     |(\"\S+\")
-------------------> Domain <---------------------------
IP Address May be surrounded by squared brackets ---->   (\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])
Or Words and Hyphen included(provided it's not the first or last character) Followed by at least 1 dot then a word (Can be Repeated) Followed by the last word, it must contain 3 characters at most ([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})
-------------------> End <---------------------------
Matching the end of a regular expression ---> $/
*/

/* ---------------------------> RegExp Reference <-------------------------------
// All regular expressions start and end with forward slashes.
^ Matches the beginning of the string or line
$ Matches the end of the string or line
* Matches the previous character 0 or more times.
? Matches the previous character 0 or 1 time.
+ Matches the previous character 1 or more times.
\ Indicates that the next character is special and not to be interpreted literally.
[] Indicates range of characters
[^] Any character Not in between brackets.
\s whitespace character
n{x,y} Matches a string that contains a sequence of x to y n's
n{x,} Matches a string that contains a sequence of at least x n's
. Any single character
*/
