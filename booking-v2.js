// Booking page JavaScript - works with PHP backend
document.addEventListener("DOMContentLoaded", function () {
  // Only run on booking page
  const bookingForm = document.getElementById("bookingForm");
  if (!bookingForm) {
    console.log("Not on booking page, skipping booking.js initialization");
    return;
  }

  console.log("Booking form found, initializing...");

  // Form validation animations
  const inputs = bookingForm.querySelectorAll("input, select, textarea");
  inputs.forEach((input) => {
    input.addEventListener("blur", function () {
      if (this.value.trim() !== "") {
        this.style.borderColor = "#4CAF50";
      } else if (this.hasAttribute("required")) {
        this.style.borderColor = "#f44336";
      }
    });

    input.addEventListener("focus", function () {
      this.style.borderColor = "#2196F3";
    });
  });

  // Enhanced form submission
  bookingForm.addEventListener("submit", function (e) {
    const submitBtn = bookingForm.querySelector(".submit-btn");
    if (submitBtn) {
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span>Processing...</span><span class="btn-icon">→</span>';
      submitBtn.disabled = true;
    }
  });

  // Smooth scroll to any validation errors from PHP
  const errorMsg = document.querySelector(".error-msg");
  if (errorMsg) {
    errorMsg.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  console.log("Booking form initialization complete");
});

// Price update function will be called from PHP when package is selected
// This is defined in the PHP file itself when a package is loaded
