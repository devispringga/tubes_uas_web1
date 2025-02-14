<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CuanBijak</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transition: transform var(--transition-time) ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, var(--hover-color), var(--primary-color));
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: all var(--transition-time) ease;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            transform: scale(1.02);
        }

        .nav-link {
            transition: color var(--transition-time) ease;
        }

        .nav-link:hover {
            color: var(--hover-color) !important;
        }

        .transaction-item {
            transition: background-color var(--transition-time) ease;
        }

        .transaction-item:hover {
            background-color: rgba(150, 8, 8, 0.1);
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

        @media (max-width: 768px) {
            .card {
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
            <div class="text-center mb-4">
                <img src="../image/cuan.png" alt="Logo" width="150">
                <h2>RINGKASAN KEUANGAN</h2>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100 p-3 text-center">
                        <h5><i class="fas fa-wallet"></i> Saldo</h5>
                        <p class="display-6" id="saldoAmount">Loading...</p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card h-100 p-3">
                        <h5><i class="fas fa-chart-line"></i> Grafik</h5>
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card p-3">
                        <h5><i class="fas fa-history"></i> Riwayat Transaksi</h5>
                        <div id="transactionHistory"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        class DashboardManager {
            constructor() {
                this.sessionToken = localStorage.getItem('session_token');
                this.formData = new FormData()
                this.transactionChart = null;
                this.init();
            }

            async init() {
                await this.formData.append('session_token', this.sessionToken);
                await this.checkSession();
                await this.fetchData();
            }

            async fetchData() {
                this.showLoading(true);
                try {
                    const response = await axios.get(`../api/transaction/get.php?session_token=${this.sessionToken}`);
                    if (response.data.status === 'success') {
                        const transactions = response.data.data;
                        this.updateBalance(transactions);
                        this.updateChart(transactions);
                        this.updateHistory(transactions);
                    }
                } catch (error) {
                    this.showError('Error fetching data:', error);
                } finally {
                    this.showLoading(false);
                }
            }

            updateBalance(transactions) {
                const total = transactions.reduce((acc, transaction) => {
                    return transaction.statusTransaksi === 1 ?
                        acc + transaction.amount :
                        acc - transaction.amount;
                }, 0);

                this.animateBalance(total);
                document.getElementById('saldoAmount').style.color = total < 0 ? 'red' : 'green';
            }

            animateBalance(finalBalance) {
                const element = document.getElementById('saldoAmount');
                let current = 0;
                const increment = Math.ceil(finalBalance / 100);

                const update = () => {
                    current += increment;
                    element.textContent = `Rp ${Math.min(current, finalBalance).toLocaleString()}`;
                    if (current < finalBalance) requestAnimationFrame(update);
                };

                requestAnimationFrame(update);
            }

            updateHistory(transactions) {
                const historyContainer = document.getElementById('transactionHistory');
                historyContainer.innerHTML = transactions.slice(0, 5).map(transaction => `
                    <div class="d-flex justify-content-between align-items-center mb-3 transaction-item">
                        <div>
                            <strong>${transaction.statusTransaksi === 1 ?
                        '<i class="fas fa-arrow-down text-success"></i> Pemasukan' :
                        '<i class="fas fa-arrow-up text-danger"></i> Pengeluaran'}</strong>
                            - ${transaction.category}
                            <div class="text-muted">${this.formatDate(transaction.date)}</div>
                        </div>
                        <div class="${transaction.statusTransaksi === 1 ? 'text-success' : 'text-danger'}">
                            Rp ${transaction.amount.toLocaleString()}
                        </div>
                    </div>
                `).join('');
            }

            formatDate(dateString) {
                const date = new Date(dateString);
                const options = {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                return date.toLocaleDateString('id-ID', options);
            }

            updateChart(transactions) {
                const ctx = document.getElementById('transactionChart').getContext('2d');
                const {
                    labels,
                    income,
                    expense
                } = this.processChartData(transactions);

                if (this.transactionChart) this.transactionChart.destroy();

                this.transactionChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [
                            this.createDataset('Pemasukan', income, '#28a745'),
                            this.createDataset('Pengeluaran', expense, '#dc3545')
                        ]
                    },
                    options: this.chartOptions()
                });
            }

            processChartData(transactions) {
                const data = transactions.reduce((acc, transaction) => {
                    const date = new Date(transaction.date).toLocaleDateString();
                    if (!acc.labels.includes(date)) acc.labels.push(date);
                    const index = acc.labels.indexOf(date);

                    if (transaction.statusTransaksi === 1) {
                        acc.income[index] = (acc.income[index] || 0) + transaction.amount;
                    } else {
                        acc.expense[index] = (acc.expense[index] || 0) + transaction.amount;
                    }

                    return acc;
                }, {
                    labels: [],
                    income: [],
                    expense: []
                });

                return data;
            }

            createDataset(label, data, color) {
                return {
                    label,
                    data,
                    borderColor: color,
                    fill: false,
                    tension: 0.1
                };
            }

            chartOptions() {
                return {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                };
            }

            async checkSession() {
                try {
                    const response = await axios.post('../api/session.php', this.formData);
                    if (response.data.status !== 'success') window.location.href = 'login.php';
                } catch (error) {
                    window.location.href = 'login.php';
                }
            }

            showLoading(show) {
                document.querySelector('.loading-overlay').style.display = show ? 'flex' : 'none';
            }

            showError(message, error) {
                console.error(error);
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                alert.innerHTML = `
                    ${message}: ${error.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
            }
        }

        // Initialize application
        document.addEventListener('DOMContentLoaded', () => {
            window.dashboardApp = new DashboardManager();
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