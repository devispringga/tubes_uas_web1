<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CuanBijak</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #B3565A;
            --secondary-color: #383838;
            --hover-color: #e24a4a;
            --navbar-color: #383838;
            --transition-time: 0.3s;
        }

        html,
        body {
            height: 100%;
            background-color: #f8f9fa;
        }

        body {
            display: flex;
            flex-direction: column;
            padding-top: 60px;
        }

        .content-wrapper {
            flex: 1;
        }

        .navbar-custom {
            background-color: var(--navbar-color);
            box-shadow: 0 4px 6px rgba(150, 8, 8, 0.1);
        }

        .nav-link {
            transition: color var(--transition-time) ease;
        }

        .nav-link:hover {
            color: var(--hover-color) !important;
        }

        /* Profile Card Styling */
        .profile-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin: 2rem 0;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .profile-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-right: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(179, 86, 90, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-card {
                padding: 1.5rem;
                margin: 1rem 0;
            }

            .profile-icon {
                font-size: 2rem;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../image/cuan.png" alt="Logo" width="40" class="me-2">
                <span class="fw-bold">CuanBijak</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="transaction.php">Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="history.php">Riwayat</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>Akun
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profil</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i
                                        class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <main class="flex-grow-1">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card">
                        <div class="profile-header">
                            <i class="fas fa-user-circle profile-icon"></i>
                            <h2 class="mb-0">Profil Pengguna</h2>
                        </div>
                        <form id="profileForm">
                            <div class="mb-4">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" required readonly>
                            </div>

                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required readonly>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone" pattern="[0-9]{10,13}" required
                                    readonly>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password"
                                    placeholder="Kosongkan jika tidak ingin mengganti" disabled>
                            </div>

                            <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary" onclick="toggleEdit()" id="editButton">
                                    <i class="fas fa-edit me-2"></i>Edit Profil
                                </button>
                                <button type="submit" class="btn btn-primary" id="saveButton" disabled>
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        class ProfileController {
            constructor() {
                this.sessionToken = localStorage.getItem('session_token');
                this.formData = new FormData()
                this.isEditMode = false;
                this.init();
            }

            async init() {
                await this.formData.append('session_token', this.sessionToken);
                await this.checkSession();
                await this.loadProfile();
                this.setupEventListeners();
            }


            async loadProfile() {
                this.showLoading(true);
                try {
                    const response = await axios.post('../api/profile/get.php', this.formData);

                    if (response.data.status === 'success') {
                        document.getElementById('name').value = response.data.data.name;
                        document.getElementById('username').value = response.data.data.username;
                        document.getElementById('phone').value = response.data.data.phone;
                    }
                } catch (error) {
                    this.showError('Gagal memuat profil', error);
                } finally {
                    this.showLoading(false);
                }
            }

            toggleEdit() {
                this.isEditMode = !this.isEditMode;
                const inputs = document.querySelectorAll('.form-control');
                const saveButton = document.getElementById('saveButton');
                const editButton = document.getElementById('editButton');

                inputs.forEach(input => {
                    if (input.id !== 'password') {
                        input.readOnly = !this.isEditMode;
                    }
                });

                document.getElementById('password').disabled = !this.isEditMode;
                saveButton.disabled = !this.isEditMode;
                editButton.innerHTML = this.isEditMode ?
                    '<i class="fas fa-times me-2"></i>Batal' :
                    '<i class="fas fa-edit me-2"></i>Edit Profil';
            }

            async handleSubmit(e) {
                e.preventDefault();
                const saveButton = document.getElementById('saveButton');

                try {
                    saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
                    saveButton.disabled = true;

                    let formDataSubmit = new FormData();
                    formDataSubmit.append('session_token', this.sessionToken);
                    formDataSubmit.append('name', document.getElementById('name').value);
                    formDataSubmit.append('username', document.getElementById('username').value);
                    formDataSubmit.append('phone', document.getElementById('phone').value);
                    formDataSubmit.append('password', document.getElementById('password').value);

                    const response = await axios.post('../api/profile/update.php', formDataSubmit);

                    console.log(response);

                    if (response.data.status === 'success') {
                        alert('Profil berhasil diperbarui!');
                        this.toggleEdit();
                    }
                } catch (error) {
                    this.showError('Gagal memperbarui profil', error);
                } finally {
                    saveButton.innerHTML = 'Simpan Perubahan';
                    this.isEditMode = false;
                }
            }

            showLoading(show) {
                document.querySelector('.loading-overlay').style.display =
                    show ? 'flex' : 'none';
            }

            async checkSession() {
                try {
                    const response = await axios.post('../api/session.php', this.formData);
                    if (response.data.status !== 'success') {
                        window.location.href = 'login.php';
                    }
                } catch (error) {
                    window.location.href = 'login.php';
                }
            }

            setupEventListeners() {
                document.getElementById('profileForm')
                    .addEventListener('submit', (e) => this.handleSubmit(e));
            }

            showError(message, error) {
                console.error(error);
                alert(`${message}: ${error.message}`);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            window.profile = new ProfileController();
            window.toggleEdit = () => profile.toggleEdit();
            window.logout = async () => {
                try {
                    await axios.post('../api/logout.php', this.formData);
                    localStorage.removeItem('session_token');
                    window.location.href = 'login.php';
                } catch (error) {
                    console.error('Logout error:', error);
                }
            };
        });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>