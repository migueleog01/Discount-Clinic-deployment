const dateInput = document.getElementById("date");
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


var startHour = 8; // 8am
var endHour = 14; // 2pm
var select = document.getElementById("time");
for (var hour = startHour; hour < endHour; hour++) {
    for (var minute = 0; minute < 60; minute += 30) {
        var time = new Date();
        time.setHours(hour);
        time.setMinutes(minute);
        var option = document.createElement("option");
        option.value = time.toLocaleTimeString('en-US', {hour: 'numeric', minute: 'numeric'});
        option.text = time.toLocaleTimeString('en-US', {hour: 'numeric', minute: 'numeric'});
        select.add(option);
    }
}
