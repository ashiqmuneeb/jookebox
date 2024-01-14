
function validateForm() {
    
    var mobile = document.getElementById("mobile").value;
    var password = document.getElementById("password").value;


    var mobileRegex = /^[0-9]{10}$/;
    if (!mobileRegex.test(mobile)) {
        alert("Invalid mobile number");
        return false;
    }

    
    if (password.length < 6) {
        alert("Password should be at least 6 characters long");
        return false;
    }

    return true; 
}

function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var icon = document.querySelector(".toggle-password i");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

  
