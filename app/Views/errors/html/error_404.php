<?php if (ENVIRONMENT !== 'production') : ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page Not Found</title>
    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        pre {
            white-space: normal;
            margin-top: 1.5rem;
        }
        code {
            background: #fafafa;
            border: 1px solid #efefef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: block;
        }
        p {
            margin-top: 1.5rem;
        }
        .footer {
            margin-top: 2rem;
            border-top: 1px solid #efefef;
            padding: 1em 2em 0 2em;
            font-size: 85%;
            color: #999;
        }
        a:active,
        a:link,
        a:visited {
            color: #dd4814;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>404</h1>
        <p><?= nl2br(esc($message)) ?></p>
    </div>
</body>
</html>
<?php else : ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background: linear-gradient(135deg, #f4faf6 0%, #ffffff 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3748;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            text-align: center;
            max-width: 550px;
            width: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 172, 55, 0.1);
            padding: 50px 35px;
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(0, 172, 55, 0.05);
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .illustration-container {
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        .floating-icon {
            font-size: 80px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        h1 {
            font-size: 7.5rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #00ac37 0%, #007a27 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            letter-spacing: -2px;
            filter: drop-shadow(0 10px 10px rgba(0, 172, 55, 0.1));
        }
        h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 15px;
        }
        p {
            font-size: 0.95rem;
            color: #718096;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .btn-home {
            display: inline-block;
            background: #00ac37;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 14px 35px;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(0, 172, 55, 0.25);
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: #008a2c;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0, 172, 55, 0.35);
        }
        .btn-home:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="illustration-container">
            <span class="floating-icon">🏫</span>
        </div>
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>
            Maaf, halaman yang Anda tuju tidak tersedia atau telah dipindahkan. Silakan kembali ke halaman utama kami.
        </p>
        <a href="<?= base_url() ?>" class="btn-home">Kembali ke Beranda</a>
    </div>
</body>
</html>
<?php endif; ?>
