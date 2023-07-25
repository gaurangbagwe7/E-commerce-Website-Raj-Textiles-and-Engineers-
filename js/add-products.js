
  // Get the date input field
  var dateInput = document.getElementById("date");
  
  // Get today's date
  var today = new Date();
  
  // Set the value of the input field to today's date
  dateInput.value = today.toISOString().substr(0, 10);
