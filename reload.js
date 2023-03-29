emergencyContactPhoneInput.addEventListener('input', function() {
    if (emergencyContactPhoneInput.validity.patternMismatch) {
      emergencyContactPhoneError.textContent = 'Please enter a valid phone number in the format of 123-234-2334';
    } else {
      emergencyContactPhoneError.textContent = '';
    }
  });