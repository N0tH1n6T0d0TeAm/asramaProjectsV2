@extends('layouts.master')
@section('title',$data->nama_siswa)
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<style>
    .overlay h2{
    font-size: 20px;
    margin-left: 5px;
}
.overlay{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.8);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 2148;
}
.overlay:target{
    visibility: visible;
    opacity: 1;
    transition: 0.3s ease-in-out;
}
.overlay .info input{
    margin: 5px 10px auto;
    width: 90%;
}
.overlay .info select{
    margin: 5px 10px auto;
    width: 90%;
}
.overlay .info label{
    margin-left: 5px;
}
.info .lol{
    position: fixed;
    margin: 5% 30% auto;
    background: #fff;
    width: 40%;
    border-radius: 3px;
    padding: 10px 0;
}
.lol button{
    float: right;
    margin: 10px;
}
a.keluar{
    float: right;
    color: black;
    text-decoration: none;
}
</style>

<a href="{{ route('profilsiswa', $data->nis) }}" style="float: left">Detail Lengkap Siswa</a>
<a href="#tambah_judul" style="float: right">Tambah Judul</a><br><br>

<form action="/rentang_tanggal/{{$data->nis}}" method="GET">
<table>
<tr>
    <th><label>Dari</label></th>
    <th><label>Sampai</label></th>
</tr>
<tr>
    <td><input type="date" name="dari" value="{{\Carbon\carbon::now()->todateString()}}" class="form-control"></td>
    <td><input type="date" name="sampai" value="{{\Carbon\carbon::now()->addday(2)->todatestring()}}" class="form-control"></td>
</tr>
</table><br>
<button class="btn btn-success">Cari</button>
</form>
<br>

@foreach($data2 as $d)

    @if(auth()->user()->id == $d->id_pengguna && $d->level_kategori == "Tidak Ada Kategori")
    <div class="card">
  <div class="card-header">
    {{tgl_indo($d->tanggal)}} @if(auth()->user()->id == $d->id_pengguna)<a href="#" style="float: right;" id_info="{{$d->id_perkembangan}}" class="btn btn-danger hapus"><i class="fa fa-trash"></i></a>@else @endif
  </div>
  <div class="card-body">
    <h5 class="card-title">{{$d->judul_buku}}</h5>
    <p class="card-text">Penulis: <b>@if(auth()->user()->id == $d->id_pengguna)<b>Anda</b> @else {{$d->pengguna->name}}@endif</b></p>
    <p>Kategori: <b>{{$d->level_kategori ?? ""}}</b></p>
    <a href="/catatan_perkembangan/{{$d->id_perkembangan}}" class="btn btn-primary">Pergi Sekarang</a>
  </div>
</div><br>
@elseif($d->level_kategori == "Umum")
<div class="card">
  <div class="card-header">
    {{tgl_indo($d->tanggal)}} @if(auth()->user()->id == $d->id_pengguna)<a href="#" style="float: right;" id_info="{{$d->id_perkembangan}}" class="btn btn-danger hapus"><i class="fa fa-trash"></i></a>@else @endif
  </div>
  <div class="card-body">
    <h5 class="card-title">{{$d->judul_buku}}</h5>
    <p class="card-text">Penulis: <b>@if(auth()->user()->id == $d->id_pengguna)<b>Anda</b> @else {{$d->pengguna->name}}@endif</b></p>
    <p>Kategori: <b>{{$d->level_kategori ?? ""}}</b></p>
    <a href="/catatan_perkembangan/{{$d->id_perkembangan}}" class="btn btn-primary">Pergi Sekarang</a>
  </div>
</div><br>

@elseif($d->level_kategori == "Confidensial" && $d->confidensial->id_perkembangan == $d->id_perkembangan && auth()->user()->name == $d->confidensial->nama_pamong || auth()->user()->id == $d->id_pengguna)
<div class="card">  
  <div class="card-header">
    {{tgl_indo($d->tanggal)}} @if(auth()->user()->id == $d->id_pengguna)<a href="#" style="float: right;" id_info="{{$d->id_perkembangan}}" class="btn btn-danger hapus"><i class="fa fa-trash"></i></a>@else @endif
  </div>
  <div class="card-body">
    <h5 class="card-title">{{$d->judul_buku}}</h5>
    <p class="card-text">Penulis: <b>@if(auth()->user()->id == $d->id_pengguna)<b>Anda</b> @else {{$d->pengguna->name}}@endif</b></p>
    <p>Kategori: @if(auth()->user()->id == $d->id_pengguna)<b>Confidensial</b> @else <b>Confidensial [Untuk Anda Dari Penulis]</b>@endif </p>
    <a href="/catatan_perkembangan/{{$d->id_perkembangan}}" class="btn btn-primary">Pergi Sekarang</a>
  </div>
</div><br>
@endif
@endforeach

<div id="tambah_judul" class="overlay">
    <div class="info">
        <div class="lol">
    <form action="/tambah_perkembangan" method="POST">
    @csrf
    <h2>Tambah Judul <a href="#" class="keluar">&times</a></h2>
    <hr style="border: 1px solid black;margin-top: -3px;">

    <input type="hidden" name="id_pengguna" id="id" value="{{auth()->user()->id}}" />

    <input type="hidden" name="nis_siswa" id="id" value="{{$data->nis}}" />

    <input type="hidden" name="tanggal" value="{{\Carbon\Carbon::now()->toDateString()}}">

    <label>Judul</label><br>
    <input class="form-control" type="text" name="judul" placeholder="Judul" required />

    <button class="btn btn-primary">Tambah</button>
    </form>
        </div>
    </div>
</div>

<script>
    $('.hapus').on('click',function(){
        var ids = $(this).attr('id_info');
        
        swal({
            icon: "warning",
            buttons: true,
            title: "Apakah Anda Ingin Hapus Data Ini?",
            text: "Data Ini Tidak Akan Dapat Dikembalikan Lagi!",
            dangerMode: true,
        }).then((kalauTerhapus) => {
            if(kalauTerhapus){
                window.location = "/hapus_info/"+ids,
                swal('Data Berhasil Di Hapus',{icon: "success"})
            }else{
                swal('Data Anda Aman',{icon: "info"})
            }
        })
    })
</script>
@endsection 