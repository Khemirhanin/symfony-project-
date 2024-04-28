const stars = document.querySelectorAll(".star");

stars.forEach(star => {
  star.addEventListener("click", function() {
    const rating = parseInt(star.getAttribute("value"));
    resetStars();
    markStars(rating);
  });
});

function resetStars() {
  stars.forEach(star => {
    star.classList.remove("active");
  });
}

function markStars(rating) {
  for (let i = 0; i < rating; i++) {
    stars[4-i].classList.add("active");
  }
}
document.getElementById('reviewForm').addEventListener('submit', function(event) {
  var title = document.getElementById('reviewTitle').value.trim();
  var message = document.getElementById('reviewMessage').value.trim();
  var rating = document.querySelector('input[name="rate"]:checked');

  if (!title || !message || !rating) {
      event.preventDefault(); // Prevent form submission
      alert('Please fill out all required fields.');
  }
});