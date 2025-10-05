document.addEventListener("DOMContentLoaded", function () {
  // Get package details from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const packageName = urlParams.get("package") || "Selected Package";
  const packagePrice = urlParams.get("price") || "₹XX,XXX";
  const packageImage =
    urlParams.get("image") || "assets/pexels-tobiasbjorkli-2104152.jpg";

  // Update package details with dummy data
  document.getElementById("packageName").textContent = packageName;
  document.getElementById("packagePrice").textContent = packagePrice;
  document.getElementById("packageImage").src = packageImage;
  document.getElementById("basePrice").textContent = packagePrice;

  // Calculate dummy taxes (18% of base price)
  const priceNum = parseInt(packagePrice.replace(/[₹,]/g, ""));
  if (!isNaN(priceNum)) {
    const taxes = Math.round(priceNum * 0.18);
    const total = priceNum + taxes;
    document.getElementById("taxes").textContent =
      "₹" + taxes.toLocaleString("en-IN");
    document.getElementById("totalPrice").textContent =
      "₹" + total.toLocaleString("en-IN");
  } else {
    document.getElementById("taxes").textContent = "₹X,XXX";
    document.getElementById("totalPrice").textContent = "₹XX,XXX";
  }

  // Set minimum date to today
  const today = new Date().toISOString().split("T")[0];
  document.getElementById("travelDate").setAttribute("min", today);

  // Form submission
  const bookingForm = document.getElementById("bookingForm");
  bookingForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Show loading state
    const submitBtn = bookingForm.querySelector(".submit-btn");
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = "<span>Processing...</span>";
    submitBtn.disabled = true;

    // Simulate booking process
    setTimeout(() => {
      // Generate dummy booking reference
      const bookingRef =
        "ST-" +
        Math.floor(1000 + Math.random() * 9000) +
        "-" +
        Math.floor(1000 + Math.random() * 9000);
      document.getElementById("bookingRef").textContent = bookingRef;

      // Show success modal
      document.getElementById("successModal").style.display = "block";

      // Reset form
      bookingForm.reset();
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;

      // Store dummy booking data (not sent anywhere)
      const bookingData = {
        reference: bookingRef,
        package: packageName,
        price: packagePrice,
        name: "John Doe",
        email: "john@example.com",
        phone: "+91 9876543210",
        travelers: "2 People",
        date: "2024-XX-XX",
        status: "Pending Confirmation",
      };
      console.log("Dummy Booking Data:", bookingData);
    }, 2000);
  });

  // Update total when travelers change
  document.getElementById("travelers").addEventListener("change", function () {
    const travelers = parseInt(this.value) || 1;
    const basePrice = parseInt(packagePrice.replace(/[₹,]/g, ""));

    if (!isNaN(basePrice)) {
      const newBasePrice = basePrice * travelers;
      const taxes = Math.round(newBasePrice * 0.18);
      const total = newBasePrice + taxes;

      document.getElementById("basePrice").textContent =
        "₹" + newBasePrice.toLocaleString("en-IN");
      document.getElementById("taxes").textContent =
        "₹" + taxes.toLocaleString("en-IN");
      document.getElementById("totalPrice").textContent =
        "₹" + total.toLocaleString("en-IN");
    }
  });

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

  // Auto-fill dummy data for testing (remove in production)
  function fillDummyData() {
    document.getElementById("fullName").value = "John Doe";
    document.getElementById("email").value = "john.doe@example.com";
    document.getElementById("phone").value = "+91 9876543210";
    document.getElementById("travelers").value = "2";
    document.getElementById("duration").value = "5-7";
    document.getElementById("address").value =
      "123 Main Street, Mumbai, Maharashtra";
    document.getElementById("specialRequests").value =
      "Looking forward to a wonderful trip!";
  }

  // Uncomment to auto-fill for testing
  // fillDummyData();
});

// Close modal function
function closeModal() {
  document.getElementById("successModal").style.display = "none";
  window.location.href = "packages.html";
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("successModal");
  if (event.target == modal) {
    closeModal();
  }
};
