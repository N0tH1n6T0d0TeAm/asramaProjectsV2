<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<style>
*{
    font-family: 'mulish',sans-serif;
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Register!
    </title>
    <!--     Fonts and icons     -->
    <link href="{{asset('ui-assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('ui-assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <script src="{{asset('js/app.js')}}"></script>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('ui-assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('ui-assets/css/soft-ui-dashboard.css')}}" rel="stylesheet" />
</head>

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
            
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Register</h3>
                                    <p class="mb-0">Silahkan Register Akun Anda</p>
                                </div>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                <div class="card-body">

                                        <label>Nama</label>
                                        <div class="mb-3">
                                             <x-input id="name" class="form-control" placeholder="Nama" type="text" name="name" :value="old('name')" required autofocus />
                                        </div>
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <x-input id="email" class="form-control" type="email" placeholder="Email" name="email" :value="old('email')" required />
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <x-input id="password" class="form-control"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" placeholder="Password" />
                                        </div>
                                        <label>Konfirmasi Password</label>
                                        <div class="mb-3">
                                          <x-input id="password_confirmation" class="form-control" placeholder="Konfirmasi Password"
                                            type="password"
                                            name="password_confirmation" required />
                                        </div>
                                        
                                        <div class="text-center">
                                           <x-button class="btn btn-primary w-100 mt-4 mb-0">
                                            {{ __('Register') }}
                                        </x-button>
                                        </div>
                                  
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                         Tidak Memiliki Akun?
                                        <a href="{{route('login')}}" class="text-info text-gradient font-weight-bold">Sign up</a>
                                    </p>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{asset('images/asrama.jpg')}}')"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
               
            </div>
      
        </section>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        © SMK Bagimu Negeriku (<script>
                            document.write(new Date().getFullYear())
                        </script>)
                    </p>
                </div>
            </div>
        </div>
    </footer>
   
</body>

</html>


