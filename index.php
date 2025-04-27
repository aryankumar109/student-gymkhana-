<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIT Mandi Student Gymkhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #198754;
            --bg-overlay: rgba(0, 0, 0, 0.6);
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            color: #f8f9fa;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/iit_mandi_campus.jpg') no-repeat center center/cover;
            overflow-x: hidden;
        }
        .landing-content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 30px;
            animation: fadeIn 1.2s ease-out;
        }
        .landing-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
        }
        .landing-content p {
            font-size: 1.2rem;
            max-width: 700px;
            margin-bottom: 40px;
            color: rgba(255, 255, 255, 0.85);
        }
        .btn-custom {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom i {
            margin-right: 8px;
        }
        .btn-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
        }
        footer {
            text-align: center;
            padding: 20px 0;
            font-size: 0.9rem;
            background-color: var(--bg-overlay);
            position: relative;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px);}
            100% { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="landing-content">
    <img src="assets/images/iit_mandi_logo.png" alt="Gymkhana Logo" style="max-width: 120px; margin-bottom: 20px;">
    <h1>Welcome to IIT Mandi Student Gymkhana</h1>
    <p>Empowering student initiatives, supporting clubs, managing proposals, and building a vibrant community together.</p>
    <div class="d-flex gap-3 flex-wrap justify-content-center">
        <a href="login.php" class="btn btn-primary btn-custom">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
        <a href="register.php" class="btn btn-success btn-custom">
            <i class="fas fa-user-plus"></i> Register
        </a>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> The Crazy Coders. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
