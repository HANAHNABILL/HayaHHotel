
document.getElementById('con').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting the traditional way

  // Get the input values
  const checkInDate = document.getElementById('checkInDate').value;
  const checkOutDate = document.getElementById('checkOutDate').value;
  const adults = document.getElementById('adults').value;
  const children = document.getElementById('children').value;

  // Validate the input (you can add more validation as needed)
  if (!checkInDate || !checkOutDate || !adults || !children) {
    alert('Please fill in all fields.');
    return;
  }

  // Create a query string
  const queryString = `checkInDate=${checkInDate}&checkOutDate=${checkOutDate}&adults=${adults}&children=${children}`;

  // Redirect to the results page with the query string
  window.location.href = `results.html?${queryString}`;
});
