<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم التسجيل بنجاح - روضة طيور الجنة</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a3093;
            --secondary-color: #a044ff;
            --accent-color: #f5d76e;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e4e8f0);
            color: var(--dark-color);
            margin: 0;
            padding: 0;
            text-align: center;
            min-height: 100vh;
            overflow-x: hidden; /* ✅ منع التمرير الأفقي */
        }


        .container {
            margin: 40px auto;
            padding: 40px;
            background-color: white;
            max-width: 700px;
            width: 90%; /* ✅ اجعل العرض مرن */
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.8s forwards 0.3s;
            z-index: 5;
            border: 1px solid rgba(0,0,0,0.05);
        }
        /* ✅ Media Query لشاشات الجوال */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px 10px;
            }

            h2 {
                font-size: 22px;
            }

            p {
                font-size: 15px;
            }

            .btn {
                padding: 12px 25px;
                font-size: 16px;
            }

            .price {
                font-size: 20px;
            }

            .footer {
                font-size: 14px;
                padding: 15px;
            }
        }

        @keyframes fadeInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 900;
            font-size: 32px;
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), var(--secondary-color));
            border-radius: 2px;
        }

        p {
            font-size: 19px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .btn {
            display: inline-block;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
            position: relative;
            overflow: hidden;
            margin-top: 20px;
            transform: scale(1);
        }

        .btn:hover {
            transform: scale(1.05) translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 48, 147, 0.6);
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }



        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .contact-info {
            background: var(--light-color);
            padding: 18px;
            border-radius: 12px;
            margin: 25px 0;
            border-right: 5px solid var(--secondary-color);
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(106,48,147,0.05), rgba(160,68,255,0.05));
            z-index: 1;
        }

        .price {
            font-size: 28px;
            font-weight: 900;
            color: var(--primary-color);
            margin: 20px 0;
            display: inline-block;
            padding: 10px 25px;
            border-radius: 50px;
            background: linear-gradient(135deg, rgba(106,48,147,0.1), rgba(160,68,255,0.1));
            position: relative;
        }

        .price::before {
            content: "✧";
            position: absolute;
            top: -15px;
            left: 10px;
            color: var(--accent-color);
            font-size: 24px;
        }

        .price::after {
            content: "✧";
            position: absolute;
            bottom: -15px;
            right: 10px;
            color: var(--accent-color);
            font-size: 24px;
        }

        .confetti {
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: var(--accent-color);
            opacity: 0;
            z-index: 1;
        }

        .floating-icons {
            position: absolute;
            font-size: 24px;
            color: rgba(106,48,147,0.2);
            animation: floatIcon 10s infinite linear;
            z-index: 0;
        }

        @keyframes floatIcon {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.5;
            }
            90% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        .footer {
            margin-top: 40px;
            padding: 20px;
            color: var(--dark-color);
            font-size: 16px;
            position: relative;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--secondary-color), transparent);
        }

        /* تأثيرات الطيور */
        .bird {
            position: absolute;
            width: 40px;
            height: 40px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%236a3093"><path d="M23 12l-3-3v2h-5.14c-.14-.38-.32-.74-.54-1.08l1.54-1.54-1.41-1.41-1.8 1.8c-.46-.3-.96-.55-1.49-.73L13 4V1l-3 3 2 2v2.16c-.61.17-1.19.4-1.74.69l-1.92-1.92-1.41 1.41 1.42 1.42c-.27.4-.5.82-.69 1.26l-1.49-1.49-1.41 1.41 1.66 1.66c-.12.5-.18 1.02-.18 1.55 0 .53.06 1.05.18 1.55l-1.66 1.66 1.41 1.41 1.49-1.49c.19.44.42.86.69 1.26l-1.42 1.42 1.41 1.41 1.92-1.92c.55.29 1.13.52 1.74.69V19l-2 2 3 3 3-3-2-2v-2.14c1.72-.44 3.16-1.61 4-3.12h2v-2l3-3z"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0;
            animation: fly 15s linear infinite;
            z-index: 1;
        }

        @keyframes fly {
            0% {
                transform: translateX(-100px) translateY(50px) scale(0.8) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            90% {
                opacity: 0.7;
            }
            100% {
                transform: translateX(calc(100vw + 100px)) translateY(-100px) scale(1.2) rotate(10deg);
                opacity: 0;
            }
        }

        /* تأثير الشرارة عند النقر */
        .click-spark {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--accent-color);
            pointer-events: none;
            opacity: 0;
            z-index: 100;
        }
    </style>
</head>
<body>

<div id="header"></div>
<script>
    fetch("header.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("header").innerHTML = data;
        });
</script>

<!-- طيور متحركة -->
<div class="bird" style="top: 20%; animation-delay: 1s;"></div>
<div class="bird" style="top: 40%; animation-delay: 3s;"></div>
<div class="bird" style="top: 60%; animation-delay: 5s;"></div>
<div class="bird" style="top: 80%; animation-delay: 7s;"></div>

<!-- أيقونات عائمة -->
<div class="floating-icons" style="left: 10%; animation-delay: 0.5s; animation-duration: 12s;"><i class="fas fa-star"></i></div>
<div class="floating-icons" style="left: 20%; animation-delay: 2s; animation-duration: 15s;"><i class="fas fa-heart"></i></div>
<div class="floating-icons" style="left: 30%; animation-delay: 1s; animation-duration: 18s;"><i class="fas fa-cloud"></i></div>
<div class="floating-icons" style="left: 70%; animation-delay: 3s; animation-duration: 14s;"><i class="fas fa-feather"></i></div>
<div class="floating-icons" style="left: 85%; animation-delay: 0s; animation-duration: 16s;"><i class="fas fa-moon"></i></div>

<div class="container">
    <h2 class="animate__animated animate__fadeIn">🎉 تم إتمام التسجيل بنجاح</h2>
    <p class="animate__animated animate__fadeIn animate__delay-1s">شكرًا لكم على التسجيل في <strong>روضة طيور الجنة</strong></p>

    <div class="contact-info animate__animated animate__fadeIn animate__delay-1s">
        <p>للتواصل: <strong>0597145645</strong></p>
    </div>

    <div class="price animate__animated animate__bounceIn animate__delay-2s">
        230 شيكل
        <small style="display: block; font-size: 16px; font-weight: normal;">لمرة واحدة فقط</small>
    </div>

    <p class="animate__animated animate__fadeIn animate__delay-2s">سيتم التواصل معكم قريبًا لتأكيد التسجيل ودفع الرسوم</p>

    <div class="animate__animated animate__fadeIn animate__delay-3s">
        <a href="registration.php" class="btn">تعبئة نموذج جديد</a>
    </div>
</div>


<div id="footer"></div>
<script>
    fetch("footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer").innerHTML = data;
        });
</script>

<script>
    // إنشاء تأثير الكونفيتي
    document.addEventListener('DOMContentLoaded', function() {
        const colors = ['#6a3093', '#a044ff', '#f5d76e', '#ff7675', '#74b9ff'];

        // إنشاء 100 قطعة كونفيتي
        for (let i = 0; i < 100; i++) {
            createConfetti();
        }

        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';

            // أشكال مختلفة للكونفيتي
            const shapes = ['circle', 'rect', 'star'];
            const shape = shapes[Math.floor(Math.random() * shapes.length)];

            if (shape === 'circle') {
                confetti.style.borderRadius = '50%';
                confetti.style.width = Math.random() * 10 + 8 + 'px';
                confetti.style.height = confetti.style.width;
            } else if (shape === 'rect') {
                confetti.style.width = Math.random() * 15 + 5 + 'px';
                confetti.style.height = Math.random() * 5 + 3 + 'px';
                confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
            } else {
                confetti.innerHTML = '✧';
                confetti.style.fontSize = Math.random() * 10 + 12 + 'px';
                confetti.style.width = 'auto';
                confetti.style.height = 'auto';
                confetti.style.background = 'transparent';
            }

            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.top = -20 + 'px';

            const animationDuration = Math.random() * 3 + 2;
            const animationDelay = Math.random() * 5;

            confetti.style.animation = `fall ${animationDuration}s linear ${animationDelay}s forwards`;
            document.body.appendChild(confetti);

            // إزالة الكونفيتي بعد انتهاء الحركة
            setTimeout(() => {
                confetti.remove();
                createConfetti(); // إنشاء كونفيتي جديدة لاستمرار التأثير
            }, (animationDuration + animationDelay) * 1000);
        }

        // إضافة أنيميشن السقوط للكونفيتي
        const style = document.createElement('style');
        style.textContent = `
                @keyframes fall {
                    0% {
                        transform: translateY(0) rotate(0deg);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(100vh) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
        document.head.appendChild(style);

        // تأثير الشرارة عند النقر
        document.addEventListener('click', function(e) {
            const spark = document.createElement('div');
            spark.className = 'click-spark';
            spark.style.left = e.clientX + 'px';
            spark.style.top = e.clientY + 'px';
            document.body.appendChild(spark);

            // حركة الشرارة
            const angle = Math.random() * Math.PI * 2;
            const velocity = 5 + Math.random() * 5;
            const distance = 20 + Math.random() * 30;

            let posX = 0;
            let posY = 0;
            let opacity = 1;

            const moveSpark = setInterval(() => {
                posX += Math.cos(angle) * velocity;
                posY += Math.sin(angle) * velocity;
                opacity -= 0.02;

                spark.style.transform = `translate(${posX}px, ${posY}px)`;
                spark.style.opacity = opacity;

                if (opacity <= 0 ||
                    Math.abs(posX) > distance ||
                    Math.abs(posY) > distance) {
                    clearInterval(moveSpark);
                    spark.remove();
                }
            }, 20);

            // ظهور الشرارة
            setTimeout(() => {
                spark.style.opacity = '0.8';
                spark.style.width = '6px';
                spark.style.height = '6px';
            }, 10);
        });
    });
</script>
</body>
</html>