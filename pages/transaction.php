<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi - CuanBijak</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #860505;
            --hover-color: #e24a4a;
            --navbar-color: #383838;
            --transition-time: 0.3s;
        }

        body {
            padding-top: 4rem;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .transaction-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            transition: transform var(--transition-time) ease;
        }

        .transaction-card:hover {
            transform: translateY(-5px);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, var(--hover-color), var(--primary-color));
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            transition: all var(--transition-time) ease;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            transform: scale(1.02);
        }

        .form-control:focus {
            border-color: var(--hover-color);
            box-shadow: 0 0 0 0.25rem rgba(226, 74, 74, 0.25);
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

        .error-alert {
            position: fixed;
            top: 70px;
            /* Adjust based on navbar height */
            right: 20px;
            z-index: 1000;
            max-width: 400px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .transaction-card {
                border-radius: 0.75rem;
                margin: 0.5rem;
            }

            .btn-custom {
                width: 100%;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

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
                            <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="card transaction-card">
                        <div class="card-header card-header-gradient text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Transaksi</h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="transactionForm" novalidate>
                                <div class="mb-4">
                                    <label for="transactionDate" class="form-label fw-medium"><i class="fas fa-calendar-alt me-2"></i>Tanggal Transaksi</label>
                                    <input type="text" class="form-control form-control-lg" id="transactionDate" required>
                                </div>
                                <div class="mb-4">
                                    <label for="amount" class="form-label fw-medium"><i class="fas fa-coins me-2"></i>Jumlah</label>
                                    <input type="number" class="form-control form-control-lg" id="amount" placeholder="Masukkan Jumlah" required>
                                </div>
                                <div class="mb-4">
                                    <label for="type" class="form-label fw-medium"><i class="fas fa-exchange-alt me-2"></i>Tipe Transaksi</label>
                                    <select class="form-select form-select-lg" id="type" required>
                                        <option value="0">Pengeluaran</option>
                                        <option value="1">Pemasukan</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="form-label fw-medium"><i class="fas fa-tag me-2"></i>Kategori</label>
                                    <select class="form-select form-select-lg" id="category" required>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-custom w-100 fw-bold py-3">
                                    <i class="fas fa-save me-2"></i>Simpan Transaksi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        class TransactionManager {
            constructor() {
                this.sessionToken = localStorage.getItem('session_token');
                this.formData = new FormData();
                this.init();
            }

            async init() {
                await this.formData.append('session_token', this.sessionToken);
                await this.initDatePicker();
                await this.loadCategories();
                await this.setupForm();
                await this.checkSession();
            }

            initDatePicker() {
                $('#transactionDate').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    orientation: 'auto'
                }).datepicker('setDate', new Date());
            }

            async loadCategories() {
                try {
                    const response = await axios.get('../api/category/get.php');
                    const categorySelect = document.getElementById('category');
                    categorySelect.innerHTML = '<option value="" selected disabled>Pilih Kategori</option>';

                    response.data.data.forEach(category => {
                        categorySelect.innerHTML += `
                            <option value="${category.id}">${category.name}</option>
                        `;
                    });
                } catch (error) {
                    this.showError('Gagal memuat kategori', error);
                }
            }

            async handleSubmit(event) {
                event.preventDefault();
                this.showLoading(true);

                const formData = new FormData();
                formData.append('session_token', this.sessionToken);
                formData.append('date', document.getElementById('transactionDate').value);
                formData.append('amount', document.getElementById('amount').value);
                formData.append('statustransaction', document.getElementById('type').value);
                formData.append('idcategory', document.getElementById('category').value);

                try {
                    const response = await axios.post('../api/transaction/add.php', formData);

                    if (response.data.status === 'success') {
                        this.showSuccess('Transaksi berhasil ditambahkan!');
                        window.location.href = 'history.php';
                    } else {
                        this.showError('Gagal menambahkan transaksi', Error(response.data.message));
                    }
                } catch (error) {
                    this.showError('Gagal menambahkan transaksi', error);
                } finally {
                    this.showLoading(false);
                }
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

            showLoading(show) {
                document.querySelector('.loading-overlay').style.display = show ? 'flex' : 'none';
            }

            showSuccess(message) {
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
            }

            async showError(message, error) {
                console.error(error);
                const navbarHeight = document.querySelector('.navbar-custom').offsetHeight;
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show error-alert';
                alert.style.top = `${navbarHeight + 20}px`;
                alert.innerHTML = `
                    <strong>Error!</strong> ${message}
                    <div class="small">${error.message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;

                // Auto-remove after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);

                document.body.appendChild(alert);
            }

            setupForm() {
                document.getElementById('transactionForm').addEventListener('submit', (e) => this.handleSubmit(e));
                document.querySelectorAll('form input, form select').forEach(element => {
                    element.addEventListener('input', () => {
                        element.classList.remove('is-invalid');
                    });
                });
            }
        }

        // Initialize application
        document.addEventListener('DOMContentLoaded', () => {
            window.transactionApp = new TransactionManager();
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
</body>

</html>