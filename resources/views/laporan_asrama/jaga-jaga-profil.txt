@extends('layouts.master')
@section('content')

<style>
    .detail_foto {
            height: 200px;
            margin: 5px 0px 0px 125px;
            border-radius: 5%;
        }

.foto_profil{
   height: 170px;
   width: 178px;
   border-radius: 50%;
   margin-left: 10em;
   cursor: pointer;
}

.foto_profil:hover{
    opacity: 0.5;
}

h2{
    margin-left: 12em;
    margin-top: -4em;
    font-weight: 500;
}
b{
    margin-left: 27em;
}
p{
    margin-left: 27em;
    margin-top: 20px;
}
.kiriman{
    margin-left: 0.5em;
}
.postingan{
    height: 260px;
    width: 20%;
    margin: 10px;
}
.postingan:hover{
    opacity: 0.5;
    transition: 0.2ms ease-in-out;
}

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
    margin: 5% 30% auto;
    background: #fff;
    width: 40%;
    border-radius: 3px;
    padding: 84px 0;
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
.detail_post{
    width: 45%;
}
.konten_detail{
    position: relative;
    top: -13em;
}

.konten_detail .nama{
    position: relative;
    top: -4em;
    left: -5em;
}

.profil_detailnya{
    height: 40px;
    width: 40px;
    position: relative;
    left: 9em;
    top: -2em;
}
.judul_deskripsi{
    position: relative;
    left: 19.5em;
    top: -3em;
}
.isi_deskripsi{
    position: relative;
    right: 7.8em;
    top: -15em;
}
.deskripsi .judul_deskripsi{
    position: relative;
    top: -15em;
    left: 19em;
    width: 10em;
}

</style>

<div class="profil">
<img src="{{asset('img/mobil.jpg')}}" class="foto_profil" alt="lol">
<h2>{{$data[0]->pengguna->name}}</h2>
<b>{{$hitung}}</b><b class="kiriman" style="font-weight: 400">Kiriman</b>
<p>{{$data[0]->pengguna->active ?? 'Bio Tidak Ada'}}</p>
</div><br>

<div class="postingannya">
<hr style="border: 1px solid black">
@foreach($data as $i)
@php
$gambar = explode('|',$i->gambar)
@endphp

<a href="#lihat_post/{{$i->id_laporan}}"><img src="{{asset('postingan/' . $gambar[0])}}" alt="postingan" class="postingan"></a>
@endforeach
</div>

@foreach ( $data as $d)
    
@php
$gambar_detail = explode('|',$d->gambar);
@endphp

<div id="lihat_post/{{$d->id_laporan}}" class="overlay">
        <div class="info">
            <div class="lol">
        <h2>Post<a href="#" class="keluar">&times</a></h2>
        <hr style="border: 1px solid black;margin-top: -3px;">
        
        <div class="gambar">
        <a href="#gambar_lainnya/{{$d->id_laporan}}"><img src="{{asset('postingan/' . $gambar_detail[0])}}" alt="postingan" class="postingan detail_post"></a>
        </div>
        
        <div class="konten_detail" style="width: 0em;">
        <img src="https://i.pinimg.com/736x/d1/6f/f2/d16ff211ffeeda14889ec04698c13c2d.jpg" alt="postingan" class="foto_profil profil_detailnya"> <b class="nama">{{$d->pengguna->name}}</b>
    </div>

    <div class="deskripsi">
    <details>
            <summary class="judul_deskripsi">Deskripsi</summary>
            <p class="isi_deskripsi">{{$d->deskripsi}}</p>
        </details>
    </div>
            </div>
        </div>
    </div>
    
<div id="gambar_lainnya/{{$d->id_laporan}}" class="overlay" style="overflow-y:scroll">
            <div class="info">
                <div class="lol">
                    
                    <h2>Detail Post Laporan<a href="#" class="keluar">&times</a></h2>
                    @foreach($gambar_detail as $gams)
                        <img class="detail_foto" src="{{asset('postingan/' . $gams)}}" id="detail_foto">
                        @endforeach
                </div>
            </div>
        </div>

  @endforeach
     

 
@endsection