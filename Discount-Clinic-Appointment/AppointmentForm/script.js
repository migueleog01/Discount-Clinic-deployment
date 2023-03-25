const form = document.querySelector('form');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const dateInput = document.getElementById('date');
const timeInput = document.getElementById('time');
const messageInput = document.getElementById('message');
const submitBtn = document.getElementById('submitBtn');

form.addEventListener('submit', function(event) {
  event.preventDefault();

  const name = nameInput.value.trim();
  const email = emailInput.value.trim();
  const phone = phoneInput.value.trim();
  const date = dateInput.value;
  const time = timeInput.value;
  const message = messageInput.value.trim();

  // Add code here to send data to server, save to database, or perform any other necessary action

  alert('Appointment successfully scheduled!');
  
  // Clear form fields
  nameInput.value = '';
  emailInput.value = '';
  phoneInput.value = '';
  dateInput.value = '';
  timeInput.value = '';
  messageInput.value = '';
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