<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>History Transaksi - CuanBijak</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
        rel="stylesheet" />
    <style>
        :root {
            --primary-color: #860505;
            --hover-color: #e24a4a;
            --navbar-color: #383838;
            --transition-time: 0.3s;
        }

        body {
            padding-top: 60px;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background-color: var(--navbar-color);
            box-shadow: 0 4px 6px rgba(150, 8, 8, 0.1);
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            transition: color var(--transition-time) ease;
        }

        .nav-link:hover {
            color: var(--hover-color) !important;
        }


        .transaction-card {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .transaction-card:hover {
            transform: scale(1.01);
        }

        .toast-container {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1055;
        }
    </style>
</head>

<body>
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

    <!-- Toast Container -->
    <div id="toast-container" class="toast-container"></div>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container my-5">
            <h2 class="text-center mb-4">History Transaksi</h2>
            <div id="transaction-history" class="row g-3">
                <!-- Kartu transaksi akan dimuat secara dinamis -->
            </div>
            <div id="pagination" class="d-flex justify-content-center mt-4">
                <!-- Tombol pagination akan dimuat secara dinamis -->
            </div>
        </div>
    </main>

    <!-- Edit Transaction Modal -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTransactionForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="transactionDate" class="form-label">Tanggal Transaksi</label>
                            <input type="text" class="form-control" id="transactionDate" placeholder="Pilih Tanggal"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editAmount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="editAmount" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="editCategory" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status Transaksi</label>
                            <select class="form-select" id="editStatus" required>
                                <option value="1">Pemasukan</option>
                                <option value="0">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDeleteButton" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap Bundle JS -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        // Global Variables
        let currentTransactionId = null;
        let currentPage = 1;
        let transactionsData = [];
        let totalPages = 1;
        const ITEMS_PER_PAGE = 10;
        const sessionToken = localStorage.getItem('session_token');

        function showToast(message, type = 'success') {
            // type: 'success', 'danger', 'warning', 'info'
            const toastId = `toast-${Date.now()}`;
            const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      `;
            const container = document.getElementById('toast-container');
            container.insertAdjacentHTML('beforeend', toastHTML);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl, { delay: 3000, autohide: true });
            bsToast.show();
            // Hapus toast setelah menghilang
            toastEl.addEventListener('hidden.bs.toast', () => {
                toastEl.remove();
            });
        }

        // Cek session pengguna
        function checkSession() {
            const formData = new FormData();
            formData.append('session_token', sessionToken);
            axios.post('../api/session.php', formData)
                .then(response => {
                    if (response.data.status !== 'success') {
                        window.location.href = 'login.php';
                    }
                })
                .catch(error => {
                    console.error('Error checking session:', error);
                    showToast('Gagal memeriksa sesi pengguna', 'danger');
                });
        }
        checkSession();

        // Fungsi Logout
        function logout() {
            const formData = new FormData();
            formData.append('session_token', sessionToken);
            axios.post('../api/logout.php', formData)
                .then(response => {
                    if (response.data.status === 'success') {
                        localStorage.removeItem('session_token');
                        window.location.href = 'login.php';
                    } else {
                        showToast('Logout gagal: ' + response.data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                    showToast('Error saat logout', 'danger');
                });
        }

        // Fungsi untuk memuat data transaksi
        function loadTransactionHistory() {
            axios.get(`../api/transaction/get.php?session_token=${sessionToken}`)
                .then(response => {
                    if (response.data.status === 'success') {
                        transactionsData = response.data.data;
                        totalPages = Math.ceil(transactionsData.length / ITEMS_PER_PAGE);
                        renderTransactions();
                        renderPagination();
                    } else {
                        showToast('Gagal mengambil data: ' + response.data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error fetching transactions:', error);
                    showToast('Error mengambil data transaksi', 'danger');
                });
        }

        // Render transaksi dalam bentuk kartu
        function renderTransactions() {
            const container = document.getElementById('transaction-history');
            container.innerHTML = '';
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, transactionsData.length);
            const currencyFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            for (let i = startIndex; i < endIndex; i++) {
                const transaction = transactionsData[i];
                // Format tanggal: Today, Yesterday atau tanggal biasa
                const tDate = new Date(transaction.date);
                const today = new Date();
                const diffDays = Math.floor((today - tDate) / (1000 * 3600 * 24));
                let dateLabel = diffDays === 0 ? 'Today' : diffDays === 1 ? 'Yesterday' : tDate.toLocaleDateString();

                const amountClass = transaction.statusTransaksi == 1 ? 'text-success' : 'text-danger';
                const formattedAmount = currencyFormatter.format(transaction.amount);
                const cardHTML = `
          <div class="col-md-6">
            <div class="card transaction-card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h5 class="card-title mb-1">${transaction.statusTransaksi == 1 ? 'Pemasukan' : 'Pengeluaran'}</h5>
                  <p class="card-text mb-1"><small class="text-muted">${transaction.category}</small></p>
                  <p class="card-text ${amountClass}">${formattedAmount}</p>
                  <p class="card-text"><small class="text-muted">${dateLabel}</small></p>
                </div>
                <div>
                  <button class="btn btn-warning btn-sm mb-1" onclick="editTransaction(${transaction.id})">Edit</button>
                  <button class="btn btn-danger btn-sm" onclick="confirmDeleteTransaction(${transaction.id})">Delete</button>
                </div>
              </div>
            </div>
          </div>
        `;
                container.insertAdjacentHTML('beforeend', cardHTML);
            }
        }

        // Render pagination
        function renderPagination() {
            const container = document.getElementById('pagination');
            container.innerHTML = '';

            if (totalPages <= 1) return;

            const prevBtn = document.createElement('button');
            prevBtn.className = 'btn btn-secondary btn-sm me-2';
            prevBtn.textContent = 'Previous';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTransactions();
                    renderPagination();
                }
            };

            const nextBtn = document.createElement('button');
            nextBtn.className = 'btn btn-secondary btn-sm ms-2';
            nextBtn.textContent = 'Next';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTransactions();
                    renderPagination();
                }
            };

            const pageInfo = document.createElement('span');
            pageInfo.className = 'align-self-center';
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

            container.append(prevBtn, pageInfo, nextBtn);
        }

        // Edit transaksi: Muat data transaksi dan kategori, lalu tampilkan modal edit
        function editTransaction(id) {
            currentTransactionId = id;
            axios.get(`../api/transaction/get.php?session_token=${sessionToken}&id=${currentTransactionId}`)
                .then(response => {
                    if (response.data.status === 'success') {
                        const dataRespon = response.data.data;
                        // Set tanggal, jumlah, status
                        const tDate = new Date(dataRespon.date);
                        // Format date yyyy-mm-dd
                        document.getElementById('transactionDate').value = tDate.toISOString().split('T')[0];
                        document.getElementById('editAmount').value = dataRespon.amount;
                        document.getElementById('editStatus').value = dataRespon.statusTransaksi;

                        // Load kategori dan set nilai terpilih
                        axios.get('../api/category/get.php')
                            .then(response => {
                                if (response.data.status === 'success') {
                                    const categories = response.data.data;
                                    const categorySelect = document.getElementById('editCategory');
                                    categorySelect.innerHTML = '';
                                    categories.forEach(category => {
                                        const option = document.createElement('option');
                                        option.value = category.id;
                                        option.textContent = category.name;
                                        categorySelect.appendChild(option);
                                    });
                                    categorySelect.value = dataRespon.categoryid;
                                } else {
                                    showToast('Gagal mengambil kategori: ' + response.data.message, 'danger');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching categories:', error);
                                showToast('Error mengambil kategori', 'danger');
                            });

                        // Tampilkan modal edit
                        const editModal = new bootstrap.Modal(document.getElementById('editTransactionModal'));
                        editModal.show();
                    } else {
                        showToast('Gagal mengambil data transaksi: ' + response.data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error fetching transaction data:', error);
                    showToast('Error mengambil data transaksi', 'danger');
                });
        }

        // Submit form edit transaksi menggunakan FormData
        document.getElementById('editTransactionForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('session_token', sessionToken);
            formData.append('date', document.getElementById('transactionDate').value);
            formData.append('amount', document.getElementById('editAmount').value);
            formData.append('statustransaction', document.getElementById('editStatus').value);
            formData.append('idcategory', document.getElementById('editCategory').value);
            formData.append('transaction_id', currentTransactionId);

            axios.post('../api/transaction/update.php', formData)
                .then(response => {
                    if (response.data.status === 'success') {
                        showToast('Transaksi berhasil diperbarui', 'success');
                        const modalEl = document.getElementById('editTransactionModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();
                        loadTransactionHistory();
                    } else {
                        showToast('Gagal mengupdate transaksi: ' + response.data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error editing transaction:', error);
                    showToast('Error saat mengupdate transaksi', 'danger');
                });
        });

        // Konfirmasi Hapus transaksi: Tampilkan modal konfirmasi
        function confirmDeleteTransaction(id) {
            currentTransactionId = id;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteModal.show();
        }

        // Hapus transaksi (POST dengan FormData)
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            const formData = new FormData();
            formData.append('transaction_id', currentTransactionId);
            formData.append('session_token', sessionToken);
            axios.post('../api/transaction/delete.php', formData)
                .then(response => {
                    if (response.data.status === 'success') {
                        showToast('Transaksi berhasil dihapus', 'success');
                        const modalEl = document.getElementById('deleteConfirmationModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();
                        loadTransactionHistory();
                    } else {
                        showToast('Gagal menghapus transaksi: ' + response.data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error deleting transaction:', error);
                    showToast('Error saat menghapus transaksi', 'danger');
                });
        });

        // Inisialisasi datepicker & load data saat dokumen siap
        $(document).ready(function () {
            $('#transactionDate').datepicker({
                format: 'yyyy-mm-dd',
                endDate: 'today',
                autoclose: true
            });
            loadTransactionHistory();
        });
    </script>
</body>

</html>