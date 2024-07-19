<?php
include 'partials/header.php';
?>


  <section class="empty__page">
    <h1>About Page</h1>
  </section>


    <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');
        .image {
            margin-top: 15%;
            background-color: #4158D0;
            display: inline-flex;
            border-radius: 12px 0 0 12px;
            position: static;
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .image img {
            margin-top: 20%;
            height: 80vh;
            width: 60vh;
            margin-right: 50%;
            transition: all 0.3s ease;
        }

        .content {
            margin-top: 20px;
             background-color: #4158D0;
             display: flex;
             justify-content: center;
             flex-direction: column;
             align-items: center;
             border-radius: 0  12px 12px 0;
             color: #fff;
             width: 100vh;
             animation: slideInRight 1s ease-out forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .content h2 {
            margin-top: 15%;
            text-transform: uppercase;
            font-size: 36px;
            letter-spacing: 6px;
            opacity: 0.9;
            color: #fff;
        }

        .content span {
            height: 0.5px;
            width: 80px;
            background: #777;
            margin: 30px 0;
        }

        .content p {
            padding-bottom: 15px;
            font-weight: 300;
            opacity: 0.7;
            width: 60%;
            text-align: center;
            margin: 0 auto;
            line-height: 1.7;
            color:#fff;
        }

        .links {
            margin: 15px 0;
        }

        .links li {
            border: 2px solid #4158D0;
            list-style: none;
            border-radius: 5px;
            padding: 10px 15px;
            width: 160px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .links li a {
            text-transform: uppercase;
            color: black;
            text-decoration: none;
        }

        .links li:hover {
            border-color: #C850C0;
            transition: border-color 0.3s ease;
        }

        .vertical-line {
            height: 30px;
            width: 3px;
            background: #C850C0;
            margin: 0 auto;
        }

        .icons {
            display: flex;
            padding: 15px 0;
        }

        .icons li {
            display: block;
            padding: 5px;
            margin: 5px;
        }

        .icons li i {
            font-size: 26px;
            opacity: 0.8;
            transition: transform 0.3s;
        }

        .icons li i:hover {
            color: #C850C0;
            cursor: pointer;
            transform: scale(1.2);
        }

        @media (max-width: 900px) {
            section {
                grid-template-columns: 1fr;
                width: 100%;
                border-radius: none;
            }

            .image {
                height: 100vh;
                border-radius: none;
            }

            .content {
                height: 100vh;
                border-radius: none;
            }

            .content h2 {
                font-size: 20px;
                margin-top: 50px;
            }

            .content span {
                margin: 20px 0;
            }

            .content p {
                font-size: 14px;
            }

            .links li a {
                font-size: 14px;
            }

            .links {
                margin: 5px 0;
            }

            .links li {
                padding: 6px 10px;
            }

            .icons li i {
                font-size: 15px;
            }
        }

        .credit {
            text-align: center;
            color: #000;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .credit a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <section>
        <div class="image">
            <img src="https://cdn.pixabay.com/photo/2017/08/26/23/37/business-2684758__340.png">
        </div>

        <div class="content">
            <h2>About Us</h2>
            <span></span>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis aspernatur voluptas inventore ab voluptates nostrum minus illo laborum harum laudantium earum ut, temporibus fugiat sequi explicabo facilis unde quos corporis! lorem10 Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate numquam dolore laboriosam amet reprehenderit eum temporibus aperiam iure, debitis repellat ut natus officia saepe esse rem magni quis, recusandae atque.</p>
            <ul class="links">
                <li><a href="#">Contact us</a></li>
                <div class="vertical-line"></div>
                <li><a href="#">Service</a></li>
                <div class="vertical-line"></div>
                <li><a href="#">Home</a></li>
            </ul>
            <ul class="icons">
                <li>
                    <i class="fa fa-twitter"></i>
                </li>
                <li>
                    <i class="fa fa-facebook"></i>
                </li>
                <li>
                    <i class="fa fa-github"></i>
                </li>
                <li>
                    <i class="fa fa-pinterest"></i>
                </li>
            </ul>
        </div>
    </section><br>

    <?php
    include 'partials/footer.php';
    ?>
     <script>
    window.addEventListener('load', function () {
      const loadingScreen = document.getElementById('loading-screen');
      loadingScreen.style.display = 'none';
    });
  </script>


  