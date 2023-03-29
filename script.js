const dateInput = document.getElementById("date-input");
const errorMessage = document.getElementById("error-message");


dateInput.addEventListener('input', function() {
  const enteredDate = dateInput.value;
  const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
  
  if (!dateRegex.test(enteredDate)) {
    errorMessage.textContent = "Please enter a valid date in the format MM/DD/YYYY";
  } else {
    errorMessage.textContent = "";
  }
});
const phoneInput = document.getElementById('patientphone');
const phoneError = document.getElementById('phone-error');

phoneInput.addEventListener('input', () => {
  if (!isValidPhone(phoneInput.value)) {
    phoneError.textContent = 'Please enter a valid phone number in the format 123-456-7890';
  } else {
    phoneError.textContent = '';
  }
});


function isValidPhone(phone) {
  const regex = /^\d{3}-\d{3}-\d{4}$/;
  return regex.test(phone);
}


const emergencyContactPhoneInput = document.getElementById('emergencyContactPhone');
const emergencyContactPhoneError = document.getElementById('emergencyContactPhoneError');




