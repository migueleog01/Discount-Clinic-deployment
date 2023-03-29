const dateInput = document.getElementById("date");
const errorMessage = document.getElementById("error-message");
//const selectState = document.getElementById("state")

/*
selectState.addEventListener('change', () => {
  document.getElementById('offices').classList.toggle("hidden")
})
*/

dateInput.addEventListener('input', function() {
  const enteredDate = dateInput.value;
  const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
  if (!dateRegex.test(enteredDate)) {
    errorMessage.textContent = "Please enter a valid date in the format MM/DD/YYYY";
  } else {
    errorMessage.textContent = "";
  }
});


  // Add code here to send data to server, save to database, or perform any other necessary action

 


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

/*
const doctorId = document.getElementById("physician1").value;
const addressElement = document.getElementById("address");

if (doctorId === "physician1") {
  addressElement.value = "158 Easton Glen Ln";
  addressElement.setAttribute("value", "1011");
}
*/

/*
document.getElementById('state').addEventListener('change', function() {
  var state = this.value;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var offices = JSON.parse(xhr.responseText);
      var officeSelect = document.getElementById('office');
      officeSelect.innerHTML = '';
      for (var i = 0; i < offices.length; i++) {
        var option = document.createElement('option');
        option.value = offices[i].id;
        option.textContent = offices[i].name;
        officeSelect.appendChild(option);
      }
    }
  };
  xhr.open('GET', 'getOffices.php?state=' + state, true);
  xhr.send();
});
*/
