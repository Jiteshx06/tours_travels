document.addEventListener("DOMContentLoaded", function () {
  // Get post data from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const postTitle = urlParams.get("title") || "Blog Post Title";
  const postCategory = urlParams.get("category") || "Destinations";
  const postDate = urlParams.get("date") || "March 15, 2024";
  const postImage = urlParams.get("image") || "assets/bali.jpg";

  // Update page content
  document.getElementById("postTitle").textContent = postTitle;
  document.title = postTitle + " - Sahyog Tours";

  // Update intro based on category
  const intros = {
    Destinations:
      "Summer is the season of adventure, relaxation, and unforgettable moments under the sun. For 2025, why not indulge in a beach vacation that will leave you with lasting memories? Whether you're drawn to the crystal-clear waters of the Caribbean, the exotic charm of Asia, or the luxury of secluded islands, Sahyog Tours is here to help you explore these remarkable experiences.<br><br>Let's dive into these stunning destinations and discover why they deserve a spot on your travel bucket list.",
    "Travel Tips":
      "Planning your next adventure? These essential travel tips will help you prepare better and make the most of your journey.",
    "Travel Guides":
      "Your complete guide to exploring this destination. From must-see attractions to local insights, we've got you covered.",
    Culture:
      "Immerse yourself in the rich cultural heritage and traditions. Learn about the customs, festivals, and way of life that make this place unique.",
  };

  document.getElementById("postIntro").innerHTML =
    intros[postCategory] || intros["Destinations"];

  // Carousel functionality
  const carouselImages = document.querySelectorAll(".carousel-img");
  const heroImage = document.getElementById("heroImage");
  const prevBtn = document.querySelector(".carousel-btn.prev");
  const nextBtn = document.querySelector(".carousel-btn.next");
  let currentIndex = 0;

  // Click on thumbnail to change image
  carouselImages.forEach((img, index) => {
    img.addEventListener("click", function () {
      carouselImages.forEach((i) => i.classList.remove("active"));
      this.classList.add("active");
      heroImage.src = this.src;
      currentIndex = index;
    });
  });

  // Previous button
  if (prevBtn) {
    prevBtn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      currentIndex =
        (currentIndex - 1 + carouselImages.length) % carouselImages.length;
      carouselImages.forEach((i) => i.classList.remove("active"));
      carouselImages[currentIndex].classList.add("active");
      heroImage.src = carouselImages[currentIndex].src;
    });
  }

  // Next button
  if (nextBtn) {
    nextBtn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      currentIndex = (currentIndex + 1) % carouselImages.length;
      carouselImages.forEach((i) => i.classList.remove("active"));
      carouselImages[currentIndex].classList.add("active");
      heroImage.src = carouselImages[currentIndex].src;
    });
  }

  // Share functionality
  const shareButtons = document.querySelectorAll(".share-btn");
  const pageUrl = window.location.href;
  const pageTitle = postTitle;

  shareButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const platform = this.classList[1];

      switch (platform) {
        case "facebook":
          window.open(
            `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
              pageUrl
            )}`,
            "_blank"
          );
          break;
        case "twitter":
          window.open(
            `https://twitter.com/intent/tweet?url=${encodeURIComponent(
              pageUrl
            )}&text=${encodeURIComponent(pageTitle)}`,
            "_blank"
          );
          break;
        case "whatsapp":
          window.open(
            `https://wa.me/?text=${encodeURIComponent(
              pageTitle + " - " + pageUrl
            )}`,
            "_blank"
          );
          break;
        case "email":
          window.location.href = `mailto:?subject=${encodeURIComponent(
            pageTitle
          )}&body=${encodeURIComponent("Check out this article: " + pageUrl)}`;
          break;
      }
    });
  });

  // Related posts click
  document.querySelectorAll(".related-post").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const title = this.querySelector("h4").textContent;
      alert(
        `Opening: ${title}\n\nThis is a demo. Full post functionality coming soon!`
      );
    });
  });

  // Smooth scroll for back button
  document
    .querySelector(".back-to-blog")
    .addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "blog.html";
    });

  // Animate elements on scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  document.querySelectorAll(".post-section, .sidebar-widget").forEach((el) => {
    el.style.opacity = "0";
    el.style.transform = "translateY(30px)";
    el.style.transition = "all 0.6s ease";
    observer.observe(el);
  });
});
