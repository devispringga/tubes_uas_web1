<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CuanBijak</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="pages/styles/footerStyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .navbar {
            background: linear-gradient(15deg, rgb(77, 76, 76), rgb(235, 46, 46));
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand { font-weight: bold; }
        .navbar-nav .nav-link:hover { color: rgb(167, 165, 160) !important; }
        .about img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            font-size: 40px;
            color: rgb(235, 46, 46);
            margin-bottom: 10px;
        }
        .features .col-md-4 { transition: transform 0.3s; }
        .features .col-md-4:hover { transform: scale(1.05); }
        .full-text { display: none; 
        }


        .feature-link {
            text-decoration: none; /* Menghapus garis bawah */
            color: inherit; /* Menggunakan warna default teks */
            display: block; /* Membuat seluruh elemen bisa diklik */
        }
        .feature-link:hover {
            color: inherit; /* Menghindari perubahan warna saat hover */
        }

        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand nav-space" href="#">CuanBijak</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About us</a></li>
            </ul>
        </div>
        <div class="a-flex ms-auto me-2">
            <a href="pages/login.php" class="btn btn-outline-light me-2">Login</a>
            <a href="pages/register.php" class="btn btn-light">Sign Up</a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <section id="home" class="hero">
        <div class="container text-center">
            <h1>Selamat Datang di CuanBijak</h1>
            <p>Langkah Cerdas Menuju Keuangan Sejahtera.</p>
            <a href="#about" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Tentang Kami</h2>
                    <p>CuanBijak hadir sebagai solusi praktis dalam mengatur pemasukan, pengeluaran, tabungan, hingga
                        investasi, semua dalam satu aplikasi yang mudah digunakan. Dengan fitur yang intuitif dan data
                        yang aman, kami berkomitmen untuk mendampingi Anda dalam setiap langkah finansial, dari
                        merencanakan anggaran hingga meraih impian finansial Anda.</p>
                    <p>Misi kami adalah membantu masyarakat Indonesia mencapai kebebasan finansial melalui pengelolaan
                        uang yang bijak dan terarah. Bersama CuanBijak, mari kita wujudkan kehidupan yang lebih baik dan
                        sejahtera. </p>
                </div>
                <div class="col-md-6">
                    <img src="image/about-us-image.jpeg" alt="About Us">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container text-center">
            <h2>Fitur Kami</h2>
            <p class="lead">Temukan fitur luar biasa yang kami tawarkan untuk meningkatkan pengalaman Anda.</p>
            <div class="row">
                <div class="col-md-4">
                    <a href="pages/responsive-design.php" class="feature-link">
                        <i class="feature-icon fas fa-mobile-alt"></i>
                        <h3>Responsive Design</h3>
                        <img src="image/img1.png" style="width: 250px; height: auto;">
                        <p>Situs web kami tampak hebat di semua perangkat. Menyesuaikan tampilan dan tata letaknya secara otomatis berdasarkan</p>
                        <p><a href="pages/responsive-design.php" class="read-more">Baca Selengkapnya →</a></p>                 
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="pages/keamanan.php" class="feature-link">
                        <i class="feature-icon fas fa-lock"></i>
                        <h3>Keamanan</h3>
                        <img src="image/img2.png" style="width: 250px; height: auto;">
                        <p> Kami mengutamakan privasi dan keamanan Anda. Di era digital saat ini, keamanan dan privasi adalah hal yang sangat penting.</p>
                        <p><a href="pages/keamanan.php" class="read-more">Baca Selengkapnya →</a></p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="pages/customization.php" class="feature-link">
                        <i class="feature-icon fas fa-cogs"></i>
                        <h3>Dapat Disesuaikan</h3>
                        <img src="image/img3.png" style="width: 250px; height: auto;">
                        <p>Platform kami menawarkan berbagai opsi penyesuaian untuk memenuhi kebutuhan Anda. Kami memahami bahwa setiap pengguna memiliki</p>
                        <p><a href="pages/customization.php" class="read-more">Baca Selengkapnya →</a></p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'pages/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>

    <script>
        $(document).ready(function () {
            $(".toggle-text").click(function (e) {
                e.preventDefault();
                var fullText = $(this).siblings(".full-text");
                var buttonText = $(this);
                fullText.toggle();
                buttonText.text(buttonText.text() === "Selengkapnya" ? "Tutup" : "Selengkapnya");
            });
        });
    </script>
</body>

</html>
