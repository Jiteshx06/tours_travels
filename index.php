<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sahyog Tours - Your Trusted Travel Partner</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="logo">
          <img src="assets/logo.png" alt="TravelMaddy" />
          <span>Sahyog Tours</span>
        </div>
        <ul class="nav-menu">
          <li><a href="index.php" class="active">HOME</a></li>
          <li><a href="about.html">ABOUT US</a></li>
          <li><a href="packages.php">PACKAGES</a></li>
          <li><a href="corporate.html">CORPORATE</a></li>
          <li><a href="blog.html">BLOG</a></li>
          <li><a href="contact.html">CONTACT US</a></li>
        </ul>
        <div class="phone">
          <span>📞 9988776655</span>
          <?php if(isset($_SESSION['logged_in'])): ?>
              <a href="dashboard.php" style="margin-left: 20px; color: #fff; text-decoration: none;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></a>
              <a href="logout.php" style="margin-left: 10px; color: #fff; text-decoration: none;">Logout</a>
          <?php else: ?>
              <a href="login.php" style="margin-left: 20px; color: #fff; text-decoration: none;">Login</a>
          <?php endif; ?>
        </div>
      </nav>
    </header>

    <main class="hero">
      <div class="hero-content">
        <h1>EXPLORE THE WORLD<br />WITH SAHYOG TOURS</h1>
        <p>
          Welcome to Sahyog Tours- Best Travel Agency in Thane, Mumbai, where
          your travel dreams come to life. Discover a world of extraordinary
          journeys, whether you're exploring India's diverse landscapes or
          venturing to international destinations. With Sahyog Tours, your
          adventure begins now.
        </p>

        <div class="travel-options">
          <button class="option-btn active" id="international">
            International
          </button>
          <button class="option-btn" id="domestic">Domestic</button>
        </div>
      </div>
    </main>

    <section class="features">
      <div class="features-grid">
        <div class="feature-card blue">
          <div class="feature-icon">🏢</div>
          <h3>Local & Global Expertise</h3>
          <p>
            Our team of travel experts combines local knowledge with a global
            perspective, offering you a diverse array of travel options.
          </p>
        </div>
        <div class="feature-card white">
          <div class="feature-icon">🗺️</div>
          <h3>Customized Itineraries</h3>
          <p>
            We create bespoke itineraries for all types of travelers, tailored
            to your preferences and interests.
          </p>
        </div>
        <div class="feature-card blue">
          <div class="feature-icon">✈️</div>
          <h3>Travel for All</h3>
          <p>
            We're dedicated to making travel inclusive, ensuring that everyone,
            regardless of ability, can partake in the joys of exploration.
          </p>
        </div>
        <div class="feature-card white">
          <div class="feature-icon">🎒</div>
          <h3>Inclusive Travel</h3>
          <p>
            At Sahyog Tours, we're committed to ensuring that everyone can
            experience the joy of exploration.
          </p>
        </div>
      </div>
    </section>

    <section class="about">
      <div class="about-content">
        <div class="about-text">
          <h2>About Sahyog Tours-<br />leading Travel Agency in Thane</h2>
          <h3>Your Journey, Our Passion</h3>
          <p>
            At Sahyog Tours, we're more than just a
            <span class="highlight">travel agency in Mumbai</span>, we're your
            partners in creating enduring memories. Our mission is to elevate
            your travel experience, and our dedicated team of experts is
            committed to turning your dreams into remarkable adventures.
          </p>
          <div class="stats">
            <div class="stat">
              <span class="stat-number">1,000+</span>
              <span class="stat-label">Happy Customers</span>
            </div>
            <div class="stat">
              <span class="stat-number">20,000+</span>
              <span class="stat-label">Tours Completed</span>
            </div>
            <div class="stat">
              <span class="stat-number">5,000+</span>
              <span class="stat-label">Destinations</span>
            </div>
          </div>
        </div>
        <div class="about-images">
          <img src="assets/kashmir.jpg" alt="Kashmir" class="about-img main" />
          <img
            src="assets/kashmirwomen.jpg"
            alt="Kashmir Women"
            class="about-img small"
          />
        </div>
      </div>
    </section>

    <section class="packages">
      <div class="packages-container">
        <div class="packages-header">
          <span class="featured-label">FEATURED TOUR</span>
          <h2>Popular International Travel Packages From Mumbai</h2>
        </div>
        <div class="packages-grid">
          <div class="package-card">
            <div class="package-image">
              <img src="assets/Europe.jpg" alt="Europe" />
            </div>
            <div class="package-content">
              <h3>GLIMPSES OF EUROPE</h3>
              <p>
                It offers a short experience in Europe at an affordable budget.
              </p>
              <button class="book-btn">Book Now</button>
              <div class="package-details">
                <span>🕐 8 Nights / 9 Days</span>
                <span>👥 Max. Group Size: 40</span>
              </div>
            </div>
          </div>
          <div class="package-card">
            <div class="package-image">
              <img src="assets/londan.jpg" alt="London" />
            </div>
            <div class="package-content">
              <h3>LONDON</h3>
              <p>
                Explore the iconic Big Ben, Buckingham Palace, and Thames River
                in England's historic capital city.
              </p>
              <button class="book-btn">Book Now</button>
              <div class="package-details">
                <span>🕐 15 Nights / 16 Days</span>
                <span>👥 Max. Group Size: 45</span>
              </div>
            </div>
          </div>
          <div class="package-card">
            <div class="package-image">
              <img src="assets/bali.jpg" alt="Bali" />
            </div>
            <div class="package-content">
              <h3>BALI</h3>
              <p>It offers best of Bali experience at an affordable budget.</p>
              <button class="book-btn">Book Now</button>
              <div class="package-details">
                <span>🕐 5 Days / 6 Days</span>
                <span>👥 No. of Adults: 2</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="trusted-partner">
      <div class="trusted-content">
        <div class="trusted-header">
          <span class="trusted-subtitle"
            >Best Travel Agency in Thane, Mumbai and Navi Mumbai</span
          >
          <h2>Your Trusted Travel Partner</h2>
          <p>
            At Sahyog Tours, we're more than just a travel agency in Thane,
            Mumbai, and Navi Mumbai. We're your trusted partner in creating
            unforgettable memories. Learn about our mission, values, and the
            dedicated team that makes it all possible.
          </p>
        </div>
        <div class="trusted-features">
          <div class="trusted-card">
            <div class="trusted-icon">🎯</div>
            <h3>Experienced</h3>
            <p>
              With years of experience in the industry, we bring a wealth of
              knowledge to every journey. Sahyog Tours is committed to curating
              experiences that are informed by a deep understanding of travel.
            </p>
          </div>
          <div class="trusted-card">
            <div class="trusted-icon">💰</div>
            <h3>Affordable Price</h3>
            <p>
              We believe that exceptional travel experiences shouldn't come at a
              premium. Sahyog Tours offers competitive pricing, ensuring that
              you can explore the world without breaking the bank.
            </p>
          </div>
          <div class="trusted-card">
            <div class="trusted-icon">📞</div>
            <h3>24/7 Support</h3>
            <p>
              At Sahyog Tours, your journey is our priority. We provide 24/7
              support, ensuring that you have assistance whenever you need it,
              no matter the time zone.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Floating buttons -->
    <a href="tel:+919988776655" class="call-button" title="Call Us"> 📞 </a>
    <a
      href="https://wa.me/919988776655"
      class="whatsapp-button"
      title="WhatsApp"
      target="_blank"
    >
      💬
    </a>

    <script src="script.js"></script>
  </body>
</html>
