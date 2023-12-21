<?php include "admin/get_ip.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php
  include "config.php";

  $headerQuery = "SELECT * FROM headers";
  $headerResult = $conn->query($headerQuery);

  if ($headerResult->num_rows > 0) {
    while ($row = $headerResult->fetch_assoc()) {
      echo '<meta content="' . htmlspecialchars($row['meta_description']) . '" name="description">';
      echo '<meta content="' . htmlspecialchars($row['meta_keywords']) . '" name="keywords">';
      echo '<title>' . htmlspecialchars($row['title']) . '</title>';
    }
  }


  // Include favicon link from the database
  $faviconQuery = "SELECT * FROM favicons";
  $faviconResult = $conn->query($faviconQuery);

  if ($faviconResult->num_rows > 0) {
    while ($faviconRow = $faviconResult->fetch_assoc()) {
      echo '<link href="' . htmlspecialchars($faviconRow['favicon_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['apple_touch_icon_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['favicon_192_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['favicon_512_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['favicon_16_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['favicon_32_link']) . '" rel="icon">';
      echo '<link href="' . htmlspecialchars($faviconRow['manifest_link']) . '" rel="manifest">';
    }
  }
  ?>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <?php
  // Include additional CSS files from the database
  $additionalCssQuery = "SELECT * FROM additional_css";
  $additionalCssResult = $conn->query($additionalCssQuery);

  if ($additionalCssResult->num_rows > 0) {
    while ($cssRow = $additionalCssResult->fetch_assoc()) {
      echo '<link href="' . htmlspecialchars($cssRow['css_link']) . '" rel="stylesheet">';
    }
  }

  // <!-- Vendor JS Files -->

  // Include additional JS files from the database
  $additionalJsQuery = "SELECT * FROM additional_js";
  $additionalJsResult = $conn->query($additionalJsQuery);

  if ($additionalJsResult->num_rows > 0) {
    while ($jsRow = $additionalJsResult->fetch_assoc()) {
      echo '<script src="' . htmlspecialchars($jsRow['js_link']) . '"></script>';
    }
  }
  ?>

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>

</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

    <!-- ======= Header ======= -->
    <header id="header">
        <div class="d-flex flex-column">

            <div class="profile">
                <img src="assets/img/profile-image-nobg.png" alt="" class="img-fluid rounded-circle">

                <?php
      // Fetch values from the 'contents' table
      $contentQuery = "SELECT * FROM contents";
      $contentResult = $conn->query($contentQuery);

      if ($contentResult->num_rows > 0) {
        $contentRow = $contentResult->fetch_assoc();
        ?>
                <h1 class="text-light"><a href="/">
                        <?php echo htmlspecialchars($contentRow['hero_title']); ?>
                    </a></h1>
                <?php } ?>

                <div class="social-links mt-3 text-center">
                    <?php
        // Fetch social media links from the 'contents' table
        $socialMediaLinks = array(
          'twitter' => $contentRow['twitter_link'],
          'facebook' => $contentRow['facebook_link'],
          'instagram' => $contentRow['instagram_link'],
          'skype' => $contentRow['skype_link'],
          'linkedin' => $contentRow['linkedin_link'],
        );

        foreach ($socialMediaLinks as $platform => $link) {
          if ($link) {
            echo '<a href="' . htmlspecialchars($link) . '" target="_blank" class="' . $platform . '"><i class="bx bxl-' . $platform . '"></i></a>';
          }
        }
        ?>
                </div>
            </div>

            <nav id="navbar" class="nav-menu navbar">
                <ul>
                    <li><a href="#hero" class="nav-link scrollto active"><i class="bx bx-home"></i>
                            <span>Home</span></a></li>
                    <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a>
                    </li>
                    <li><a href="#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i>
                            <span>Resume</span></a></li>
                    <li><a href="#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i>
                            <span>Portfolio</span></a></li>
                    <li><a href="#services" class="nav-link scrollto"><i class="bx bx-server"></i>
                            <span>Services</span></a></li>
                    <li><a href="#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i>
                            <span>Contact</span></a></li>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="hero-container" data-aos="fade-in">
            <h1>
                <?php echo htmlspecialchars($contentRow['hero_title']); ?>
            </h1>
            <p>I'm Software <span class="typed"
                    data-typed-items="<?php echo htmlspecialchars($contentRow['hero_subtitle']); ?>"></span></p>

            <!-- Download Resume Button -->
            <a href="<?php echo htmlspecialchars($contentRow['resume_link']); ?>" download class="btn btn-primary"
                style="margin-top: 20px;">Download My Resume</a>
        </div>
    </section>
    <!-- End Hero -->




    <main id="main">

        <?php

// Fetch about details from the database
$aboutQuery = "SELECT * FROM about LIMIT 1";
$aboutResult = $conn->query($aboutQuery);

if ($aboutResult->num_rows > 0) {
    $aboutRow = $aboutResult->fetch_assoc();
?>

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">

                <div class="section-title">
                    <h2>About</h2>
                    <p>
                        <?php echo $aboutRow['description']; ?>
                    </p>
                </div>

                <div class="row">
                    <div class="col-lg-4" data-aos="fade-right">
                        <img src="<?php echo $aboutRow['image_path']; ?>" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                        <h3>
                            <?php echo $aboutRow['role']; ?>
                        </h3>
                        <p class="fst-italic">
                            <?php echo $aboutRow['role_description']; ?>
                        </p>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong>
                                        <span>
                                            <?php echo $aboutRow['birthday']; ?>
                                        </span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                        <span><a href="<?php echo $aboutRow['website']; ?>" target="_blank">
                                                <?php echo $aboutRow['website']; ?>
                                            </a></span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong>
                                        <span>
                                            <?php echo $aboutRow['phone']; ?>
                                        </span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>City:</strong>
                                        <span>
                                            <?php echo $aboutRow['city']; ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong>
                                        <span>
                                            <?php echo $aboutRow['age']; ?>
                                        </span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Qualification:</strong>
                                        <span>
                                            <?php echo $aboutRow['qualification']; ?>
                                        </span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                        <span>
                                            <?php echo $aboutRow['email']; ?>
                                        </span>
                                    </li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                        <span
                                            style="color: <?php echo $aboutRow['freelance_status'] ? 'green' : 'red'; ?>;">
                                            <?php echo $aboutRow['freelance_status'] ? 'Available' : 'Not Available'; ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p>
                            <?php echo $aboutRow['additional_information']; ?>
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <?php } // End if ?>

        <!-- ======= Facts Section ======= -->
        <section id="facts" class="facts">
            <div class="container">

                <div class="section-title">
                    <h2>Facts</h2>
                    <?php
      // Include your database connection file
      include 'config.php';

      // Fetch facts data from the database
      $factsQuery = "SELECT * FROM facts";
      $factsResult = $conn->query($factsQuery);

      if ($factsResult->num_rows > 0) {
          $factsData = $factsResult->fetch_assoc();
          echo '<p>' . $factsData['facts_description'] . '</p>';
      }
      ?>
                </div>

                <div class="row no-gutters">

                    <?php
      // Fetch and display each fact
      $factBoxesQuery = "SELECT * FROM fact_boxes";
      $factBoxesResult = $conn->query($factBoxesQuery);

      if ($factBoxesResult->num_rows > 0) {
          while ($factBox = $factBoxesResult->fetch_assoc()) {
              echo '<div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up">';
              echo '<div class="count-box">';
              echo '<i class="' . $factBox['icon_class'] . '"></i>';
              echo '<span data-purecounter-start="0" data-purecounter-end="' . $factBox['counter_value'] . '" data-purecounter-duration="1" class="purecounter"></span>';
              echo '<p><strong>' . $factBox['fact_title'] . '</strong></p>';
              echo '</div>';
              echo '</div>';
          }
      }
      ?>

                </div>

            </div>
        </section><!-- End Facts Section -->


        <!-- ======= Skills Section ======= -->
        <section id="skills" class="skills section-bg">
            <div class="container">

                <?php
    // Include your database connection file
    include 'config.php';

    // Fetch skills description from the database
    $skillsDescriptionQuery = "SELECT * FROM skills_description";
    $skillsDescriptionResult = $conn->query($skillsDescriptionQuery);

    if ($skillsDescriptionResult->num_rows > 0) {
        $skillsDescriptionData = $skillsDescriptionResult->fetch_assoc();
        echo '<div class="section-title">';
        echo '<h2>Skills</h2>';
        echo '<p>' . $skillsDescriptionData['description'] . '</p>';
        echo '</div>';
    }
    ?>

                <div class="row skills-content">

                    <?php
      // Fetch skills data from the database
      $skillsQuery = "SELECT * FROM skills";
      $skillsResult = $conn->query($skillsQuery);

      if ($skillsResult->num_rows > 0) {
          while ($skill = $skillsResult->fetch_assoc()) {
              echo '<div class="col-lg-6" data-aos="fade-up">';
              echo '<div class="progress">';
              echo '<span class="skill">' . $skill['skill_name'] . ' <i class="val">' . $skill['skill_percentage'] . '%</i></span>';
              echo '<div class="progress-bar-wrap">';
              echo '<div class="progress-bar" role="progressbar" aria-valuenow="' . $skill['skill_percentage'] . '" aria-valuemin="0" aria-valuemax="100"></div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
      }
      ?>

                </div>

            </div>
        </section><!-- End Skills Section -->


        <?php
// Include your database connection file
include 'config.php';

// Fetch summary data
$summaryQuery = "SELECT * FROM summary";
$summaryResult = $conn->query($summaryQuery);

if ($summaryResult->num_rows > 0) {
    $summaryData = $summaryResult->fetch_assoc();
}

// Fetch education data
$educationQuery = "SELECT * FROM education";
$educationResult = $conn->query($educationQuery);

if ($educationResult->num_rows > 0) {
    $educationData = $educationResult->fetch_assoc();
}

// Fetch experience data
$experienceQuery = "SELECT * FROM experience";
$experienceResult = $conn->query($experienceQuery);

if ($experienceResult->num_rows > 0) {
    $experienceData = $experienceResult->fetch_assoc();
}
?>

        <!-- ======= Resume Section ======= -->
        <section id="resume" class="resume">
            <div class="container">

                <div class="section-title">
                    <h2>Resume</h2>
                    <p>
                        <?php echo isset($summaryData['description']) ? $summaryData['description'] : ''; ?>
                    </p>
                </div>

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-up">
                        <h3 class="resume-title">Summary</h3>
                        <div class="resume-item pb-0">
                            <h4>
                                <?php echo isset($summaryData['name']) ? $summaryData['name'] : ''; ?>
                            </h4>
                            <p><em>
                                    <?php echo isset($summaryData['designation']) ? $summaryData['designation'] : ''; ?>
                                </em></p>
                            <ul>
                                <li>
                                    <?php echo isset($summaryData['address']) ? $summaryData['address'] : ''; ?>
                                </li>
                                <li>
                                    <?php echo isset($summaryData['phone']) ? $summaryData['phone'] : ''; ?>
                                </li>
                                <li>
                                    <?php echo isset($summaryData['email']) ? $summaryData['email'] : ''; ?>
                                </li>
                            </ul>
                        </div>

                        <h3 class="resume-title">Education</h3>
                        <div class="resume-item">
                            <h4>
                                <?php echo isset($educationData['degree']) ? $educationData['degree'] : ''; ?>
                            </h4>
                            <h5>
                                <?php echo isset($educationData['year']) ? $educationData['year'] : ''; ?>
                            </h5>
                            <p><em>
                                    <?php echo isset($educationData['institution']) ? $educationData['institution'] : ''; ?>
                                </em></p>
                            <p>
                                <?php echo isset($educationData['description']) ? $educationData['description'] : ''; ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="resume-title">Professional Experience</h3>
                        <div class="resume-item">
                            <h4>
                                <?php echo isset($experienceData['position']) ? $experienceData['position'] : ''; ?>
                            </h4>
                            <h5>
                                <?php echo isset($experienceData['year']) ? $experienceData['year'] : ''; ?>
                            </h5>
                            <p><em>
                                    <?php echo isset($experienceData['location']) ? $experienceData['location'] : ''; ?>
                                </em></p>
                            <ul>
                                <?php
                        $responsibilities = isset($experienceData['responsibilities']) ? json_decode($experienceData['responsibilities'], true) : [];
                        foreach ($responsibilities as $responsibility) {
                            echo '<li>' . $responsibility . '</li>';
                        }
                        ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Resume Section -->

        <?php
// Close the database connection
$conn->close();
?>


        <?php
include "config.php";

// Fetch portfolio description data
$portfolioDescriptionQuery = "SELECT * FROM portfolio_description";
$portfolioDescriptionResult = $conn->query($portfolioDescriptionQuery);

// Check if there is portfolio description data
if ($portfolioDescriptionResult->num_rows > 0) {
    $portfolioDescriptionData = $portfolioDescriptionResult->fetch_assoc();
    $portfolioDescription = $portfolioDescriptionData['description'];
} else {
    // Default description if no data is available
    $portfolioDescription = "My portfolio showcases my expertise and achievements as a software developer. It highlights my proficiency
    in programming languages, problem-solving abilities, and successful project deliveries. It demonstrates my
    dedication to creating innovative and user-friendly software solutions.";
}

// Fetch portfolio data
$portfolioDataQuery = "SELECT * FROM portfolio_items";
$portfolioDataResult = $conn->query($portfolioDataQuery);

// Check if there is portfolio data
if ($portfolioDataResult->num_rows > 0) {
    $portfolioData = $portfolioDataResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Provide a default empty array if no data is available
    $portfolioData = [];
}

// Close the database connection
$conn->close();
?>

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio section-bg">
            <div class="container">
                <div class="section-title">
                    <h2>Portfolio</h2>
                    <p>
                        <?php echo $portfolioDescription; ?>
                    </p>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <!-- You can dynamically generate filter options based on categories in your database -->
                            <?php
                    $categories = array_unique(array_column($portfolioData, 'category'));
                    foreach ($categories as $category) {
                        echo '<li data-filter=".filter-' . strtolower($category) . '">' . $category . '</li>';
                    }
                    ?>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">
                    <?php
            foreach ($portfolioData as $item) {
            ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-<?php echo strtolower($item['category']); ?>">
                        <div class="portfolio-wrap">
                            <img src="<?php echo $item['image_path']; ?>" class="img-fluid" alt="">
                            <div class="portfolio-links">
                                <a href="<?php echo $item['image_path']; ?>" data-gallery="portfolioGallery"
                                    class="portfolio-lightbox" title="<?php echo $item['title']; ?>"><i
                                        class="bx bx-plus"></i></a>
                                <a href="<?php echo $item['details_link']; ?>" title="More Details"><i
                                        class="bx bx-link"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section><!-- End Portfolio Section -->


        <?php
include "config.php";

// Fetch services description data
$servicesDescriptionQuery = "SELECT * FROM services_description";
$servicesDescriptionResult = $conn->query($servicesDescriptionQuery);

// Check if there is services description data
if ($servicesDescriptionResult->num_rows > 0) {
    $servicesDescriptionData = $servicesDescriptionResult->fetch_assoc();
    $servicesDescription = $servicesDescriptionData['description'];
} else {
    // Default description if no data is available
    $servicesDescription = "I offer a range of services as a software developer, including website and application development, software customization, and bug fixing. With a focus on quality and efficiency, I provide tailored solutions to meet clients' specific needs, ensuring seamless user experiences and optimal functionality.";
}

// Fetch individual services data
$servicesQuery = "SELECT * FROM services";
$servicesResult = $conn->query($servicesQuery);

// Check if there are services data
if ($servicesResult->num_rows > 0) {
    $servicesData = $servicesResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Default services data if no data is available
    $servicesData = array(
        array('icon' => 'bi-briefcase', 'title' => 'Website Development', 'description' => 'Building responsive and visually appealing websites using modern web technologies and frameworks.'),
        array('icon' => 'bi-card-checklist', 'title' => 'Mobile App Development', 'description' => 'Creating native or cross-platform mobile applications for iOS and Android devices.'),
        array('icon' => 'bi-bar-chart', 'title' => 'E-commerce Solutions', 'description' => 'Building secure and user-friendly online stores with features like shopping carts, payment gateways, and inventory management.'),
    );
}

// Close the database connection
$conn->close();
?>

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <div class="container">
                <div class="section-title">
                    <h2>Services</h2>
                    <p>
                        <?php echo $servicesDescription; ?>
                    </p>
                </div>

                <div class="row">
                    <?php
            foreach ($servicesData as $service) {
            ?>
                    <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up">
                        <div class="icon"><i class="bi <?php echo $service['icon']; ?>"></i></div>
                        <h4 class="title"><a href="">
                                <?php echo $service['title']; ?>
                            </a></h4>
                        <p class="description">
                            <?php echo $service['description']; ?>
                        </p>
                    </div>
                    <?php
            }
            ?>
                </div>
            </div>
        </section><!-- End Services Section -->


        <?php
include "config.php"; // Include your database connection file

// Fetch testimonials data
$testimonialsQuery = "SELECT * FROM testimonials";
$testimonialsResult = $conn->query($testimonialsQuery);

// Check if there are testimonials
if ($testimonialsResult->num_rows > 0) {
    $testimonialsData = [];
    while ($row = $testimonialsResult->fetch_assoc()) {
        $testimonialsData[] = $row;
    }
} else {
    // Default data if no testimonials are available
    $testimonialsData = [
        [
            'text' => 'Default testimonial text.',
            'image_url' => 'assets/img/testimonials/no-preview.png',
            'customer_name' => 'Default Customer',
            'customer_title' => 'Default Title',
        ]
    ];
}

// Close the database connection
$conn->close();
?>

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials section-bg">
            <div class="container">
                <div class="section-title">
                    <h2>Testimonials</h2>
                    <p>Testimonials from satisfied clients are a powerful way to showcase the quality of your work. They
                        provide
                        social proof and build trust. Including testimonials in your portfolio allows potential clients
                        to see the
                        positive experiences and results others have had working with you.</p>
                </div>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        <?php
                foreach ($testimonialsData as $testimonial) {
                ?>
                        <div class="swiper-slide">
                            <div class="testimonial-item" data-aos="fade-up">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    <?php echo $testimonial['text']; ?>
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="<?php echo $testimonial['image_url']; ?>" class="testimonial-img" alt="">
                                <h3>
                                    <?php echo $testimonial['customer_name']; ?>
                                </h3>
                                <h4>
                                    <?php echo $testimonial['customer_title']; ?>
                                </h4>
                            </div>
                        </div><!-- End testimonial item -->
                        <?php
                }
                ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section><!-- End Testimonials Section -->


        <?php

include "config.php";

// Fetch contact information data
$contactInfoQuery = "SELECT * FROM contact_info";
$contactInfoResult = $conn->query($contactInfoQuery);

// Check if there is contact information data
if ($contactInfoResult->num_rows > 0) {
    $contactInfoData = $contactInfoResult->fetch_assoc();
    $location = $contactInfoData['location'];
    $locationLink = $contactInfoData['location_link'];
    $email = $contactInfoData['email'];
    $phone = $contactInfoData['phone'];
    $mapIframe = $contactInfoData['map_iframe'];
} else {
    // Default values if no data is available
    $location = "Bomai Zaingair, Baramulla JK";
    $locationLink = "https://www.google.com/maps/dir/34.5307458,74.3822042/Ruhban+abdullah,+Sopore,+Jammu+and+Kashmir+193201/@34.4444123,74.1724585,11z/data=!3m1!4b1!4m10!4m9!1m1!4e1!1m5!1m1!1s0x38e10ff7a3f2f6dd:0xfffa3ced58878666!2m2!1d74.4175353!2d34.3637227!3e0?entry=ttu";
    $email = "admin@ruhbanabdulla.in";
    $phone = "+91 6006292134";
    $mapIframe = '<iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d680.7820301745144!2d74.41707337445216!3d34.363606040596096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38e10ff7a3f2f6dd%3A0xfffa3ced58878666!2sRuhban%20abdullah!5e1!3m2!1sen!2sin!4v1685790299931!5m2!1sen!2sin"
    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"></iframe>';
}
?>

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Feel free to get in touch with me to discuss your software development needs. I'm available for
                        consultation, project inquiries, or any questions you may have.</p>
                </div>

                <div class="row" data-aos="fade-in">

                    <div class="col-lg-5 d-flex align-items-stretch">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p><a href="<?php echo $locationLink; ?>">
                                        <?php echo $location; ?>
                                    </a></p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p><a href="mailto:<?php echo $email; ?>">
                                        <?php echo $email; ?>
                                    </a></p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Call:</h4>
                                <p><a href="tel:<?php echo $phone; ?>">
                                        <?php echo $phone; ?>
                                    </a></p>
                            </div>

                            <?php echo $mapIframe; ?>
                        </div>
                    </div>

                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="forms/mail" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Your Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">Your Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Message</label>
                                <textarea class="form-control" name="message" rows="10" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->


    </main><!-- End #main -->

    <?php
include "config.php";

// Fetch footer information
$footerQuery = "SELECT * FROM footer_info WHERE id=1";
$footerResult = $conn->query($footerQuery);

$copyright = $credits = $link = '';

if ($footerResult->num_rows > 0) {
    $footerData = $footerResult->fetch_assoc();
    $copyright = $footerData['copyright'];
    $credits = $footerData['credits'];
    $link = $footerData['link'];
}

$conn->close();
?>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                Copyright &copy; <strong><span>
                        <?php echo $copyright; ?>
                    </span></strong>
            </div>
            <div class="credits">
                Designed by <a href="<?php echo $link; ?>">
                    <?php echo $credits; ?>
                </a>
            </div>
        </div>
    </footer><!-- End  Footer -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/typed.js/typed.umd.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>