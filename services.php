<?php
include 'partials/header.php';
?>

  <style>

    .services-cards {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .services-card {
      width: 350px;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 20px;
      text-align: center;
      cursor: pointer;
      transition: 0.5s ease;
      background-color: #fff;
      background: var(--color-gray-200);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .services-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .services-card i {
      font-size: 38px;
      margin-bottom: 20px;
      color: #3498db;
    }

    .services-card img {
      width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .services-card h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .services-card p {
      font-size: 15px;
      color: #666;
      line-height: 1.5;
    }

    @media screen and (max-width: 768px) {
      .services-cards {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>


  <div class="container">
    <h1 style="margin-top:4rem;">Our Services</h1>
    <div class="services-cards">
      <div class="services-card">
        <img src="images/WhatsApp Image 2024-05-21 at 12.07.19_6e116b4b.jpg" alt="Web Design">
        <i class="fas fa-desktop"></i>
        <h2>Web Design</h2>
        <p>We specialize in designing websites that are attractive and easy to use. Our goal is to turn your vision into reality, providing a positive user experience.</p>
      </div>
      <div class="services-card">
        <img src="images/WhatsApp Image 2024-05-21 at 12.14.07_19ef73ea.jpg" alt="Web Development">
        <i class="fas fa-code"></i>
        <h2>Web Development</h2>
        <p>We're skilled in different coding languages and frameworks. Our web development services aim to create strong and adaptable solutions customized for your business needs.</p>
      </div>
      <div class="services-card">
        <img src="images/WhatsApp Image 2024-05-21 at 12.11.49_9c9ba62a.jpg" alt="Mobile App Development">
        <i class="fas fa-mobile-alt"></i>
        <h2>Mobile App Development</h2>
        <p>We develop mobile applications that are functional, user-friendly, and visually appealing. Our apps are tailored to meet your specific business requirements.</p>
      </div>
    </div>
  </div>

  <?php
include 'partials/footer.php';
?>