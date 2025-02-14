<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - CuanBijak</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            background-color: #f8f9fa;
        }

        body {
            display: flex;
            flex-direction: column;
            padding-top: 60px;
            background: linear-gradient(135deg, rgb(127, 110, 110), rgb(154, 60, 60));
        }

        .register-container {
            max-width: 420px;
            width: 100%;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
        }

        .register-header {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: rgb(138, 78, 78);
            border: none;
            border-radius: 8px;
            padding: 12px;
        }

        .btn-primary:hover {
            background-color: rgb(116, 53, 53);
        }

        .forgot-password,
        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a,
        .register-link a {
            color: rgb(138, 78, 78);
            text-decoration: none;
        }

        .forgot-password a:hover,
        .register-link a:hover {
            text-decoration: underline;
        }

        .register-logo img {
            width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-5 d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 bg-white p-4 rounded shadow">
            <div class="text-center mb-3">
                <img src="../image/cuan.png" alt="CuanBijak Logo" width="150">
            </div>
            <h3 class="text-left mb-4">Daftar</h3>
            <form id="registerForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="button" class="btn btn-primary w-100" onclick="register()">Daftar</button>
            </form>
            <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function register() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const name = document.getElementById('name').value;

        const fData = new FormData();
        fData.append('username', username);
        fData.append('password', password);
        fData.append('name', name);

        if (password !== confirmPassword) {
            alert('Password not match with confirm password.')
            return;
        }

        axios.post('../api/register.php', fData)
            .then(response => {
                console.log(response);
                if (response.data.status == 'success') {
                    window.location.href = 'login.php'
                } else {
                    alert('Register failed. ' + response.data.message)
                }
            })
            .catch(error => {
                console.error('Error during login:', error)
            });
    }

    function checkSession() {
        const formData = new FormData();
        formData.append('session_token', localStorage.getItem('session_token'));

        axios.post('../api/session.php', formData)
            .then(response => {
                console.log(response);
                if (response.data.status === 'success') {
                    window.location.href = 'dashboard.php'
                }
            })
            .catch(error => {
                console.error('Error checking session:', error);
            });
    }

    checkSession();
</script>

</html>