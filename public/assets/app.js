function registerOnload() {
  document.getElementById("inputRole").addEventListener("change", changeType);
}


const modalSuccessRegistration = () => {
  window.location.href = "login.php";
}

function addAuthModalExit(elString) {
  const inputElement = document.getElementById(elString);

  inputElement.addEventListener('hidden.bs.modal', modalSuccessRegistration)
}

function delAuthModalExit(elString) {
  const inputElement = document.getElementById(elString);

  inputElement.removeEventListener('hidden.bs.modal', modalSuccessRegistration)
}

const removeDanger = event => {
  const inputElement = event.target;
  inputElement.classList.remove("border-danger");

  inputElement.removeEventListener('onfocusout', removeDanger);

};

function addDanger(elString) {
  const inputElement = document.getElementById(elString);
  inputElement.classList.add("border-danger");
  inputElement.addEventListener('focusout', removeDanger);
}

function shakeForm(form) {
  form.classList.add("animate__animated");
  form.classList.add("animate__headShake");
  setTimeout(() => {
    form.classList.remove("animate__animated");
    form.classList.remove("animate__headShake");

  }, 1000);

}


function pulseForm() {
  const form = document.getElementById("signUpForm");
  form.classList.add("animate__animated");
  form.classList.add("animate__pulse");
  setTimeout(() => {

    form.classList.remove("animate__animated");
    form.classList.remove("animate__pulse");
  }, 1000);
}

function showErrors(errors, id) {
  let err = document.getElementById(id);

  err.innerHTML = "";


  errors.forEach(error => {
    let errorText = document.createElement('p');
    errorText.textContent = error;
    err.appendChild(errorText);
  });

  err.innerHTML += '<button type="button"  class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'


  err.classList.remove("d-none");
}

async function next1() {
  let email = document.getElementById("inputEmail").value;
  let username = document.getElementById("inputUsername").value;
  let password = document.getElementById("inputPassword").value;
  let password2 = document.getElementById("inputCPassword").value;

  let errors = [];


  if (!email || !password || !password2 || !username) {
    if (!email) {
      addDanger("inputEmail");
    }
    if (!password) {
      addDanger("inputPassword");
    }
    if (!password2) {
      addDanger("inputCPassword");
    }
    if (!username) {
      addDanger("inputUsername");
    }
    errors.push("Fill-up all fields");
  }

  if (password.length < 6) {
    errors.push("Password must be at least 6 characters");
  }


  if (password !== password2) {
    errors.push("Passwords do not match");
  }

  let email_username_exists = {
    "email": email,
    "username": username,
    "context": "email_username_exists",
  };

  await fetch("../controller/auth.php", {
    "method": "POST",
    "headers": {
      "Content-Type": "application/json; charset=utf-8"
    },
    "body": JSON.stringify(email_username_exists),
  }).then(function(response) {

    return response.json();

  }).then(function(data) {
    if (data[0]) {
      errors.push("Email is already taken");
      addDanger("inputEmail");
    }
    if (data[1]) {
      errors.push("Username is already taken");
      addDanger("inputUsername");

    }
  }).catch(error => {
    console.error("Err", error);
  })

  if (errors.length > 0) {
    shakeForm(document.getElementById("signUpForm"));
    showErrors(errors, "signUpAlert");
  } else {
    pulseForm();
    document.getElementById("divInputEmail").style.display = "none";
    document.getElementById("divInputUsername").style.display = "none";
    document.getElementById("divInputPassword").style.display = "none";

    document.getElementById("divInputCPassword").style.display = "none";
    document.getElementById("divBackBtn1").style.display = "none";
    document.getElementById("divNextBtn1").style.display = "none";
    document.getElementById("title1").style.display = "none";

    document.getElementById("divInputFName").style.display = "block";
    document.getElementById("divInputLName").style.display = "block";

    document.getElementById("divInputAddress").style.display = "block";
    document.getElementById("divInputCPNumber").style.display = "block";
    document.getElementById("divInputBDate").style.display = "block";
    document.getElementById("divBackBtn2").style.display = "block";
    document.getElementById("divNextBtn2").style.display = "block";
    document.getElementById("title2").style.display = "block";
  }

}

function back2() {
  document.getElementById("divInputEmail").style.display = "block";

  document.getElementById("divInputUsername").style.display = "block";
  document.getElementById("divInputPassword").style.display = "block";

  document.getElementById("divInputCPassword").style.display = "block";
  document.getElementById("divBackBtn1").style.display = "block";
  document.getElementById("divNextBtn1").style.display = "block";
  document.getElementById("title1").style.display = "block";
  document.getElementById("divInputFName").style.display = "none";
  document.getElementById("divInputLName").style.display = "none";
  document.getElementById("divInputAddress").style.display = "none";

  document.getElementById("divInputCPNumber").style.display = "none";
  document.getElementById("divInputBDate").style.display = "none";
  document.getElementById("divBackBtn2").style.display = "none";
  document.getElementById("divNextBtn2").style.display = "none";
  document.getElementById("title2").style.display = "none";
  pulseForm();
}

function next2() {
  let fName = document.getElementById("inputFName").value;
  let lName = document.getElementById("inputLName").value;
  let phoneNumber = document.getElementById("inputCPNum").value;
  let address = document.getElementById("inputAddress").value;
  let birthday = document.getElementById("inputBDate").value;
  let errors = [];



  if (!fName || !lName || !phoneNumber || !address || !birthday) {
    if (!fName) {
      addDanger("inputFName");
    }

    if (!lName) {
      addDanger("inputLName");
    }
    if (!phoneNumber) {
      addDanger("inputCPNum");
    }
    if (!address) {
      addDanger("inputAddress");
    }
    if (!birthday) {
      addDanger("inputBDate");
    }
    errors.push("Fill-up all fields");
  }


  if (!phoneNumber.startsWith("09") || phoneNumber.length !== 11) {
    errors.push("Phone number must start with '09' and be 11 digits long");
  }

  if (errors.length > 0) {
    shakeForm(document.getElementById("signUpForm"));
    showErrors(errors, "signUpAlert");
  } else {

    document.getElementById("divInputFName").style.display = "none";
    document.getElementById("divInputLName").style.display = "none";
    document.getElementById("divInputAddress").style.display = "none";
    document.getElementById("divInputCPNumber").style.display = "none";
    document.getElementById("divInputBDate").style.display = "none";
    document.getElementById("divBackBtn2").style.display = "none";
    document.getElementById("divNextBtn2").style.display = "none";
    document.getElementById("title2").style.display = "none";
    document.getElementById("divInputRole").style.display = "block";
    document.getElementById("title3").style.display = "block";
    document.getElementById("divBackBtn3").style.display = "block";
    document.getElementById("divNextBtn3").style.display = "block";
    document.getElementById("divSignUpBtn").style.display = "block";
    changeType();
    pulseForm();
  }
}

function back3() {
  document.getElementById("divInputFName").style.display = "block";
  document.getElementById("divInputLName").style.display = "block";
  document.getElementById("divInputAddress").style.display = "block";
  document.getElementById("divInputCPNumber").style.display = "block";
  document.getElementById("divInputBDate").style.display = "block";
  document.getElementById("divBackBtn2").style.display = "block";

  document.getElementById("divNextBtn2").style.display = "block";
  document.getElementById("title2").style.display = "block";
  document.getElementById("divInputRole").style.display = "none";
  document.getElementById("title3").style.display = "none";
  document.getElementById("divBackBtn3").style.display = "none";
  document.getElementById("divNextBtn3").style.display = "none";
  document.getElementById("divSignUpBtn").style.display = "none";
  document.getElementById("divInputSID").style.display = "none";
  document.getElementById("divInputFID").style.display = "none";
  document.getElementById("divInputCompanyName").style.display = "none";

  document.getElementById("divInputEID").style.display = "none";

  pulseForm();
}


function changeType() {
  let role = document.getElementById("inputRole").value;

  if (role == 1) {

    document.getElementById("divInputSID").style.display = "block";
    document.getElementById("inputSID").required = true;


    document.getElementById("divInputEID").style.display = "none";
    document.getElementById("divInputCompanyName").style.display = "none";
    document.getElementById("divInputFID").style.display = "none";

    document.getElementById("inputEID").required = false;
    document.getElementById("inputCompanyName").required = false;
    document.getElementById("inputFID").required = false;
  } else if (role == 2) {
    document.getElementById("divInputSID").style.display = "none";
    document.getElementById("inputSID").required = false;

    document.getElementById("divInputEID").style.display = "block";
    document.getElementById("inputEID").required = true;
    document.getElementById("divInputCompanyName").style.display = "block";
    document.getElementById("inputCompanyName").required = true;

    document.getElementById("divInputFID").style.display = "none";
    document.getElementById("inputFID").required = false;
  } else if (role == 3) {
    document.getElementById("divInputSID").style.display = "none";
    document.getElementById("divInputEID").style.display = "none";
    document.getElementById("divInputCompanyName").style.display = "none";
    document.getElementById("inputSID").required = false;

    document.getElementById("inputEID").required = false;
    document.getElementById("inputCompanyName").required = false;

    document.getElementById("divInputFID").style.display = "block";
    document.getElementById("inputFID").required = true;
  }
}

async function login() {
  let success = false;
  const loading = document.getElementById("registerLoading");
  loading.style.display = "block";

  let register_request = {
    "email": document.getElementById("inputEmail").value,
    "username": document.getElementById("inputUsername").value,
    "password": document.getElementById("inputPassword").value,
    "fName": document.getElementById("inputFName").value,
    "lName": document.getElementById("inputLName").value,

    "lName": document.getElementById("inputLName").value,
    "address": document.getElementById("inputAddress").value,
    "cpNumber": document.getElementById("inputCPNum").value,
    "bDate": document.getElementById("inputBDate").value,
    "role": document.getElementById("inputRole").value,
    "context": "register",
    "studentId": null,
    "employerId": null,
    "companyName": null,
    "facultyId": null,

  };


  if (register_request.role == 1) {
    register_request.studentId = document.getElementById("inputSID").value;
    register_request.specContext = "registerAlumni";
  } else if (register_request.role == 2) {
    register_request.employerId = document.getElementById("inputEID").value;

    register_request.companyName = document.getElementById("inputCompanyName").value;
    register_request.specContext = "registerEmployer";
  } else {

    register_request.facultyId = document.getElementById("inputFID").value;
    register_request.specContext = "registerFaculty";
  }

  await fetch("../controller/auth.php", {
    "method": "POST",
    "headers": {
      "Content-Type": "application/json; charset=utf-8"
    },
    "body": JSON.stringify(register_request)
  }).then(function(response) {
    return response.json();
  }).then(function(data) {
    success = data;
  }).catch(error => {
    console.log(error);
  }).finally(() => {
    loading.style.display = "none";
  });


  let modalSuccess = new bootstrap.Modal(document.getElementById("registerModal"), {
    keyboard: true,
    backdrop: 'static',
  });



  let modalBody = document.getElementById("registerModalBody");

  let modalTitle = document.getElementById("registerModalTitle");
  if (success) {
    modalTitle.innerHTML = "Successful Registration";
    modalBody.innerHTML = "Wait for Account Verification";
  } else {
    modalTitle.innerHTML = "Something Went Wrong";
    modalBody.innerHTML = "Try Again Later";
  }

  modalSuccess.show();
}

async function register() {
  let success = false;
  const loading = document.getElementById("registerLoading");
  loading.style.display = "block";

  let register_request = {
    "email": document.getElementById("inputEmail").value,
    "username": document.getElementById("inputUsername").value,

    "password": document.getElementById("inputPassword").value,
    "fName": document.getElementById("inputFName").value,
    "lName": document.getElementById("inputLName").value,
    "lName": document.getElementById("inputLName").value,

    "address": document.getElementById("inputAddress").value,
    "cpNumber": document.getElementById("inputCPNum").value,

    "bDate": document.getElementById("inputBDate").value,
    "role": document.getElementById("inputRole").value,
    "context": "register",

  };


  if (register_request.role == 1) {
    register_request.studentId = document.getElementById("inputSID").value;
    register_request.specContext = "registerAlumni";
  } else if (register_request.role == 2) {
    register_request.employerId = document.getElementById("inputEID").value;

    register_request.companyName = document.getElementById("inputCompanyName").value;
    register_request.specContext = "registerEmployer";
  } else {

    register_request.facultyId = document.getElementById("inputFID").value;
    register_request.specContext = "registerFaculty";
  }

  await fetch("../controller/auth.php", {
    "method": "POST",
    "headers": {
      "Content-Type": "application/json; charset=utf-8"
    },
    "body": JSON.stringify(register_request)
  }).then(function(response) {
    return response.json();
  }).then(function(data) {
    success = data;
  }).catch(error => {
    console.log(error);
  }).finally(() => {
    loading.style.display = "none";
  });


  let modalSuccess = new bootstrap.Modal(document.getElementById("registerModal"), {
    keyboard: true,
    backdrop: 'static',
  });

  let modalBody = document.getElementById("registerModalBody");
  let modalTitle = document.getElementById("registerModalTitle");

  if (success) {
    modalTitle.innerHTML = "Successful Registration";
    modalBody.innerHTML = "Wait for Account Verification";
    addAuthModalExit("registerModal");
  } else {
    modalTitle.innerHTML = "Something Went Wrong";
    modalBody.innerHTML = "Try Again Later";
    delAuthModalExit("registerModal");
  }

  modalSuccess.show();
}


