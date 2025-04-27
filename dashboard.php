<?php
session_start(); // Start the session

// --- Authentication Check ---
// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Optional: Add an error query parameter for context on the login page
    header("Location: login.php?error=notloggedin");
    exit; // Stop script execution after redirect
}

// Get user email from session if available (for display)
// Use htmlspecialchars to prevent XSS if displaying user input/data
$user_email = isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'User';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gymkhana Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
     <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <!-- Your Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Specific styles for the dashboard */
        body.dashboard-body {
            background-color: #f4f7f6; /* Light, clean background */
            font-family: 'Open Sans', sans-serif;
        }
        .navbar {
             box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Subtle shadow */
        }
        .main-content {
            padding-top: 80px; /* Space below fixed navbar */
            padding-bottom: 40px;
        }
         .welcome-banner {
             background: linear-gradient(to right, #0056b3, #007bff); /* Primary gradient */
             color: white;
             padding: 2rem 1.5rem;
             border-radius: 0.5rem;
             margin-bottom: 2rem;
             box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
         }
         .welcome-banner h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin-bottom: 0.5rem;
         }
         .content-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem; /* Add margin between sections */
         }
         .content-section h3 {
            font-family: 'Poppins', sans-serif;
            color: #333;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 0.5rem;
         }

        /* Re-scoping gallery styles slightly for dashboard context */
        .dashboard-gallery .gallery { /* Ensure gallery class exists within this section */
            /* Existing gallery styles from style.css should apply */
        }
        .dashboard-gallery .gallery .card {
             box-shadow: 0 3px 8px rgba(0,0,0,0.08);
             border: none; /* Remove default border if desired */
        }
         /* Ensure navbar dropdowns look good on dark bg */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255,255,255,.8);
        }
        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link:focus {
            color: rgba(255,255,255,1);
        }
         .navbar-dark .navbar-text {
             color: rgba(255,255,255,.8);
         }
         /* Style for alerts */
         .alert {
             margin-top: 1rem; /* Add some space above alerts */
         }

    </style>
</head>
<body class="dashboard-body">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="dashboard.php" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
           <i class="fas fa-university me-2"></i>
           Gymkhana Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fas fa-user-circle me-1"></i> <?php echo $user_email; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                           <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                </ul>
             </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content container">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <!-- Display username only (part before @) -->
            <h2>Welcome back, <?php echo htmlspecialchars(explode('@', $user_email)[0]); ?>!</h2>
            <p class="lead mb-0">Manage club activities and proposals from your dashboard.</p>
        </div>

        <!-- Notification Area -->
        <div class="notification-area mb-3"> <!-- Wrap notifications -->
            <?php
            // Display Proposal Success Message
            if (isset($_GET['success']) && $_GET['success'] == 'proposal_submitted') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo '  <strong>Success!</strong> Your proposal has been submitted successfully.';
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }

            // Display Proposal Error Message
            if (isset($_GET['error']) && strpos($_GET['error'], 'proposal_') === 0) { // Check for proposal-specific errors
                $errorCode = $_GET['error'];
                $errorMessage = 'An unknown error occurred while submitting the proposal.'; // Default
                switch ($errorCode) {
                    case 'proposal_missing_fields':
                        $errorMessage = 'Proposal submission failed: Please fill out all required fields.';
                        break;
                    case 'proposal_db_connect':
                        $errorMessage = 'Proposal submission failed: Could not connect to the database.';
                        break;
                    case 'proposal_db_prepare':
                    case 'proposal_db_execute':
                        $errorMessage = 'Proposal submission failed: Could not save the proposal.';
                        break;
                    // Add more specific cases if needed
                }
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '  <strong>Error!</strong> ' . htmlspecialchars($errorMessage); // Use htmlspecialchars for security
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            ?>
        </div>
        <!-- End Notification Area -->


        <!-- Content Section for Clubs -->
        <div class="content-section dashboard-gallery">
             <h3><i class="fas fa-cubes me-2"></i>Explore Clubs & Sections</h3>

            <!-- Club Gallery -->
            <div class="gallery">
                 <figure class="card">
                    <a href="thirdpage.php"> <!-- This link still goes to the form page -->
                        <img src="assets/images/ArtGeeks.jpeg" alt="ArtGeeks">
                    </a>
                    <figcaption>ArtGeeks</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/SAE.png" alt="SAE">
                    </a>
                    <figcaption>SAE</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/HnT.png" alt="HNT">
                    </a>
                    <figcaption>Hiking & Trekking</figcaption>
                </figure>
                 <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Yantrik.jpeg" alt="Yantrik">
                    </a>
                    <figcaption>Yantrik</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Robotronics.jpeg" alt="Robotronics">
                    </a>
                    <figcaption>Robotics</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/MTB.jpeg" alt="MTB">
                    </a>
                    <figcaption>Mountain Biking Club</figcaption>
                </figure>
                 <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/GDSC.jpeg" alt="GDSC">
                    </a>
                    <figcaption>GDSC</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Stac.jpeg" alt="Stac">
                    </a>
                    <figcaption>STAC</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/PMC.png" alt="PMC">
                    </a>
                    <figcaption>Photography & Movie Making Club </figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Designauts.png" alt="Designaut">
                    </a>
                    <figcaption>Designauts</figcaption>
                </figure>
                 <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Kamandprompt.jpeg" alt="Kamandprompt">
                    </a>
                    <figcaption>Kamandprompt</figcaption>
                </figure>
                <figure class="card">
                    <a href="thirdpage.php">
                        <img src="assets/images/Nirmaan.jpeg" alt="Nirmaan">
                    </a>
                    <figcaption>Nirmaan</figcaption>
                </figure>
                <!-- Add other figures similarly, ensuring paths are correct -->
            </div>
            <!-- End Gallery Div -->

        </div> <!-- End Content Section -->

        <!-- You could add more content sections here for other dashboard features -->

    </div> <!-- End Main Content Container -->

    <!-- Bootstrap 5 Bundle JS (Needs to be included for dropdowns and alert dismissal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>