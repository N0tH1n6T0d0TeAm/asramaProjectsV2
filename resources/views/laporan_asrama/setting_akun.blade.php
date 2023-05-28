@extends('layouts.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <table style="width: 100%">
        <tr>
            <th><label for="email">Email</label></th>
        </tr>
        <tr>
            <td><input type="text" id="email" value="{{ $data->email }}" placeholder="Email" class="form-control"></td>
            <td><button style="margin: 0 5px auto" idnya="{{ $data->id }}" class="btn btn-primary update"><i
                        class="fa fa-check"></i></button></td>
        </tr>
    </table>


    <hr style="border: 1px solid black">

    <table style="width: 100%">
        <tr>
            <th><label for="password">Password</label></th>
        </tr>
        <tr>
            <td><input type="password" id="password" placeholder="Password" class="form-control password"></td>
            <td><i style="margin: 0 5px auto; cursor: pointer" class="fa fa-eye pw"></i></td>
        </tr>
        <tr>
            <th><label for="password2">Konfirmasi Password</label></th>
        </tr>
        <tr>
            <td><input type="password" id="password2" placeholder="Konfirmasi Password" class="form-control password2"></td>
            <td><i style="margin: 0 5px auto; cursor: pointer" class="fa fa-eye pw2"></i></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td><a class="btn btn-primary" href="/setting_profile/{{ auth()->user()->id }}">Kembali</a>
                <button id="tombol" class="btn btn-success update_password" id_pass="{{ auth()->user()->id }}"
                    disabled>Simpan</button>
            </td>
        </tr>
    </table>

    <div class="alert alert-success d-none">Update Password Berhasil! Harap Untuk Mengingat Password Yang Telah Anda Ubah! </div>

    <script type="text/javascript">
        const input1 = document.getElementById('password');
        const input2 = document.getElementById('password2');
        const tombol = document.getElementById('tombol');

        input1.addEventListener('input', checkInputs);
        input2.addEventListener('input', checkInputs);

        function checkInputs() {
            if (input1.value !== '' && input1.value === input2.value) {
                tombol.disabled = false;
            } else {
                tombol.disabled = true;
            }
        }

        $('.pw').on('click', function() {
            $(this).toggleClass('fa-eye-slash');

            var x = document.getElementById('password');
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        });

        $('.pw2').click(function() {
            $(this).toggleClass('fa-eye-slash');

            var x = document.getElementById('password2');
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })

        $('.update').click(function() {
            var ids = $(this).attr('idnya');
            var lol2 = $('#email').val();

            $.ajax({
                url: '/update_email/' + ids + '/' + lol2 + '/',
                method: 'get',
                success: function(result) {
                    swal('Email Berhasil Diubah', {
                        icon: "success"
                    });
                }
            })
        })


        $('.update_password').click(function() {
            var id_pass = $(this).attr('id_pass');
            var pass = $('#password').val();

            $.ajax({
                method: 'get',
                url: '/update_password/' + id_pass + '/' + pass + '/',
                success: function(result) {
                    $('.alert-success').removeClass('d-none');
                    setTimeout(function() {
                        $('.alert-success').addClass('d-none');
                    }, 5000);
                }
            })
        })
    </script>
@endsection
