<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Refresh token laravel -->
        <meta http-equiv="refresh" content="1800">

        <title>Login | E-Diagnostics</title>
        
        <!-- style -->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/custom.css" rel="stylesheet" />

        <!-- Core -->
        <link href="/vendor/fontawesome/css/all.min.css" rel="stylesheet">
        <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="/vendor/jQuery/jquery-3.6.0.min.js"></script>

        <!-- Toastr -->
        <script src="/vendor/toastr/toastr.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/vendor/toastr/toastr.min.css">
    </head>
    <body class="bg-success">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-dark text-white">
                                        <div class="d-flex justify-content-center my-4">
                                            <div class="col-auto">
                                                <img src="/assets/img/uir.png" id="logo">
                                            </div>
                                            <div class="ms-1 col-auto">
                                                <h3 class="text-center font-weight-light">
                                                    <i>E-Diagnostics</i>
                                                </h3>
                                                <h5 class="text-center font-weight-light">
                                                    Pemrograman dan Algoritma
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card card-body bg-danger d-none text-white mb-3" id="expired">
                                            Sistem keluar secara otomatis karena tidak ada aktivitas selama 25 menit.
                                        </div>
                                        <!-- Admin/Dosen Login -->
                                        <form method="POST" action="/login" id="inputEmail">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" type="email" placeholder="nama@contoh.com" name="email" required />
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="form-floating flex-grow-1">
                                                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" required />
                                                    <label for="password">Password</label>
                                                </div>
                                                <a href="#" class="input-group-text" id="cp_type">
                                                    <span class="fas fa-eye-slash"></span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Lupa Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>

                                        <!-- Mahasiswa Login -->
                                        <form method="POST" action="/mahasiswa/login" id="inputNPM" style="display: none;">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="npm" type="text" placeholder="173500000" name="npm" />
                                                <label for="npm">NPM</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="form-floating flex-grow-1">
                                                    <input class="form-control" id="password" type="password" placeholder="Password" name="password" required />
                                                    <label for="password">Password</label>
                                                </div>
                                                <a href="#" class="input-group-text" id="cp_type">
                                                    <span class="fas fa-eye-slash"></span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Lupa Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center bg-dark text-white py-3">
                                        <div class="small" id="login_mhs">
                                            <span>Bukan Admin?</span>
                                            <a href="#">
                                                Login sebagai Mahasiswa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                if(window.location.hash == '#login_gagal')
                    toastr.error('User/Password tidak ditemukan');
                if(window.location.hash == '#expired')
                    $('#expired').removeClass('d-none');

                $('#cp_type').click(function(){
                    var $pass = $('input[name="password"]');
                    if($pass.attr('type') == 'password'){
                        $pass.attr('type', 'text');
                        $('#cp_type .fas').removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                    else{
                        $pass.attr('type', 'password');
                        $('#cp_type .fas').removeClass('fa-eye').addClass('fa-eye-slash');
                    }
                });

                $('#login_mhs').click(function(){
                    var $this = $(this);
                    $('#inputEmail').toggle();
                    $('#inputNPM').toggle();

                    if($('#inputEmail').css('display') == 'none'){
                        $this.find('span').html($this.find('span').html().replace('Admin?', 'Mahasiwa?'));
                        $this.find('a').html($this.find('a').html().replace('Mahasiswa', 'Admin'));
                    }
                    else {
                        $this.find('span').html($this.find('span').html().replace('Mahasiwa?', 'Admin?'));
                        $this.find('a').html($this.find('a').html().replace('Admin', 'Mahasiswa'));
                    }
                });
            });
        </script>
    </body>
</html>
