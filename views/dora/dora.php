<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Be My Valentine</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: center;
            background: linear-gradient(to right, #ff66b2, #cc99ff);
            font-family: 'Arial', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Animated background hearts */
        @keyframes floating {
            0% {
                transform: translateY(0px);
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh);
                opacity: 0;
            }
        }

        .heart {
            position: absolute;
            bottom: -10px;
            width: 20px;
            height: 20px;
            background: red;
            transform: rotate(-45deg);
            animation: floating 10s linear infinite;
        }

        .heart:before,
        .heart:after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            background: red;
            border-radius: 50%;
        }

        .heart:before {
            top: -10px;
            left: 0;
        }

        .heart:after {
            left: 10px;
            top: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: white;
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            /* Responsive font size */
            padding: 0 20px;
        }

        #yesButton {
            background-color: #ff4b5c;
            color: white;
            font-size: clamp(1rem, 4vw, 1.5rem);
            /* Responsive font size */
            border: none;
            padding: clamp(10px, 3vw, 15px) clamp(20px, 5vw, 30px);
            cursor: pointer;
            border-radius: 50px;
            transition: 0.3s;
        }

        #yesButton:hover {
            background-color: #ff1e3c;
        }

        .slideshow-container {
            display: none;
            position: relative;
            width: 100%;
            height: 100vh;
        }

        .slide {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            padding-top: 5vh;
            transition: opacity 0.5s ease-in-out;
        }

        .slide img {
            width: min(300px, 85vw);
            /* Responsive width */
            height: min(300px, 85vw);
            /* Maintain aspect ratio */
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(204, 153, 255, 0.3);
            border: 5px solid rgba(204, 153, 255, 0.6);
            transform: rotate(-3deg);
            transition: all 0.3s ease;
            animation: imgFloat 3s ease-in-out infinite;
        }

        .slide img:hover {
            transform: rotate(0deg) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .message {
            color: #9a53f2;
            /* Light purple color */
            font-size: clamp(1rem, 4vw, 1.5rem);
            /* Responsive font size */
            margin-top: 20px;
            padding: 0 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: messageFloat 3s ease-in-out infinite;
        }

        @keyframes imgFloat {

            0%,
            100% {
                transform: rotate(-3deg) translateY(0px);
            }

            50% {
                transform: rotate(-3deg) translateY(-10px);
            }
        }

        @keyframes messageFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Add polaroid effect */
        .slide::before {
            content: '';
            position: absolute;
            top: 5vh;
            left: 50%;
            transform: translateX(-50%);
            width: min(330px, 90vw);
            /* Responsive width */
            height: min(380px, calc(90vw + 80px));
            /* Responsive height */
            background: linear-gradient(45deg, #f3e5f5, #e1bee7);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(204, 153, 255, 0.2);
            z-index: -1;
        }

        .final-message {
            display: none;
            color: white;
            font-size: 2.5rem;
            text-align: center;
            margin-top: 20%;
        }

        .final-message h2 {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            /* Responsive font size */
            padding: 0 20px;
        }

        /* Add media queries for better mobile experience */
        @media screen and (max-width: 768px) {
            .slide::before {
                top: 2vh;
            }

            .heart {
                width: 15px;
                height: 15px;
            }

            .heart:before,
            .heart:after {
                width: 15px;
                height: 15px;
            }

            .heart:before {
                top: -7.5px;
            }

            .heart:after {
                left: 7.5px;
            }

            .container {
                padding: 20px;
            }

            .final-message {
                margin-top: 40%;
            }
        }

        /* Animation tweaks for mobile */
        @media (hover: none) {
            .slide img:hover {
                transform: rotate(-3deg);
                box-shadow: 0 10px 20px rgba(204, 153, 255, 0.3);
            }
        }
    </style>
</head>

<body>
    <div class="container" id="valentinePrompt">
        <h1>Will you be my Valentine? yessss yesss yes 💖</h1>
        <button id="yesButton">Yes</button>
    </div>

    <div class="slideshow-container" id="slideshow"></div>

    <div class="final-message" id="finalMessage">
        <h2>You are my forever Valentine! ❤️</h2>
    </div>

    <audio id="bgMusic" loop>
        <source src="<?= Yii::getAlias('@web/song/song.mp3') ?>" type="audio/mpeg">
    </audio>

    <script>
        document.getElementById("yesButton").addEventListener("click", function() {
            document.getElementById("valentinePrompt").style.display = "none";
            document.getElementById("slideshow").style.display = "block";
            document.getElementById("bgMusic").play();
            loadImages();
        });

        function loadImages() {
            // Manually specify the images and messages
            const photos = [{
                    file: 'image3.jpeg',
                    message: 'A Love That Shines ❤️'
                },
                {
                    file: 'image1.jpeg',
                    message: 'Endless Happiness💕'
                },
                {
                    file: 'image2.jpeg',
                    message: 'A Walk to Remember💝'
                },
                {
                    file: 'image4.jpeg',
                    message: 'A Dream Come True 💖'
                },
                {
                    file: 'image5.jpeg',
                    message: 'My Heart Beats for You 💖'
                },
                {
                    file: 'image6.jpeg',
                    message: 'Pure Bliss 💖'
                },
                {
                    file: 'image7.jpeg',
                    message: 'In Your Eyes 💖'
                },
                {
                    file: 'image8.jpeg',
                    message: 'Cherished Moments 💖'
                },
                {
                    file: 'image9.jpeg',
                    message: 'Together Forever 💖'
                },
                {
                    file: 'image10.jpeg',
                    message: 'A Love Like Magic 💖'
                },
                {
                    file: 'image11.jpeg',
                    message: 'Love in Every Glance 💖'
                },
                {
                    file: 'image12.jpeg',
                    message: 'You make my heart smile! 💖'
                },
                // Add more photos as needed
            ];

            let slideshow = document.getElementById("slideshow");
            photos.forEach((photo, index) => {
                let slide = document.createElement("div");
                slide.classList.add("slide");
                slide.innerHTML = `
                    <img src="/photos/${photo.file}" alt="Valentine Image ${index + 1}">
                    <p class="message">${photo.message}</p>
                `;
                slideshow.appendChild(slide);
            });
            showSlides();
        }

        let slideIndex = 0;

        function showSlides() {
            let slides = document.getElementsByClassName("slide");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                document.getElementById("slideshow").style.display = "none";
                document.getElementById("finalMessage").style.display = "block";
                return;
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(() => {
                slides[slideIndex - 1].style.opacity = "1";
            }, 100);
            setTimeout(showSlides, 5000);
        }

        // Generate floating hearts
        function createHeart() {
            const heart = document.createElement("div");
            heart.classList.add("heart");
            heart.style.left = Math.random() * 100 + "vw";
            // Slower animation for mobile
            heart.style.animationDuration = (Math.random() * 3 + 7) * (window.innerWidth < 768 ? 1.5 : 1) + "s";
            document.body.appendChild(heart);
            setTimeout(() => heart.remove(), 10000);
        }
        // Reduce hearts on mobile
        setInterval(createHeart, window.innerWidth < 768 ? 500 : 300);

        // Add touch support
        document.addEventListener('touchstart', function() {
            const bgMusic = document.getElementById("bgMusic");
            if (bgMusic.paused) {
                bgMusic.play().catch(function(error) {
                    console.log("Audio play failed:", error);
                });
            }
        }, {
            once: true
        });
    </script>
</body>

</html>