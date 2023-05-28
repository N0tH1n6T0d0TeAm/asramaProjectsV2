@extends('layouts.master')
@section('content')

@php
    $no = 1;
@endphp
<table class="table">
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>Ganti Posisi</td>
    </tr>
    
    @foreach($data5 as $d)
    @if($d->role_id == 6)
    <tr>
        <td>{{$no++}}</td>
        <td>{{$d->user->name}}</td>
        <td><a href="#" model_id="{{$d->model_id}}" class="btn btn-success ganti"><i class="fas fa-arrow-up"></i></a></td>
    </tr>
    @else
    <tr>
        <td>{{$no++}}</td>
        <td>{{$d->user->name}}</td>
        <td><a href="#" model_id="{{$d->model_id}}" class="btn btn-danger turunkan"><i class="fas fa-arrow-down"></i></a></td>
    </tr>
    @endif
    @endforeach
</table>

<script>
    $('.ganti').on('click',function(){
        var ids = $(this).attr('model_id');
        
        swal({
            title: "Apakah Anda Yakin?",
            text: "Salah Satu Pamong Ini Diangkat Menjadi Kepala Asrama?",
            icon: "warning",
            buttons: true,
        }).then((diganti) => {
            if(diganti){
                swal('Berhasil Diangkat Menjadi Kepala Asrama',{icon: "success"});
                window.location = "/ubah_posisi/"+ids;
            }else{
                swal('Data Disimpan!');
            }
        })
    })

    $('.turunkan').on('click',function(){
        var ids = $(this).attr('model_id');
        
        swal({
            title: "Apakah Anda Yakin?",
            text: "Apakah Anda Ingin Menurunkan Posisi Penngguna Ini?",
            icon: "warning",
            buttons: true,
        }).then((diganti) => {
            if(diganti){
                swal('Berhasil Diturunkan',{icon: "success"});
                window.location = "/turunkan/"+ids;
            }else{
                swal('Data Disimpan!');
            }
        })
    })
</script>
@endsection