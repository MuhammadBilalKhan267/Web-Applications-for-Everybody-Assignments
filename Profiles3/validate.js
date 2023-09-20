function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('password').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
    } catch(e) {
        return false;
    }
    try {
        email = document.getElementById('name').value;
        console.log("Validating email="+email);
        if (email == null || email == "") {
            alert("Email is Required");
            return false;
        }
        else if (!email.includes("@")){
            alert("Email is Invalid");
            return false;
        }
    } catch(e) {
        return false;
    }
    return true;
}