@extends('layouts.master')
@section('content')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

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
   cursor: pointer;
   margin-left: 10em;
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
    width: 27%;
    margin: 2px;
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

.pilihan{
    position: relative;
    left: 15em;
    top: -2em;
    color: blue;
}

@media(max-width: 600px){
    .profil{
        position: relative;
        left: -10em;
    }
    .profil h2{
        position: relative;
        left: 8.7em;
        top: -5em;
        font-size: 17px;
    }
    .profil .pengaturan{
        position: relative;
        left: 4.5em;
        top: -1.3em;
    }
    .profil b{
        position: relative;
        left: -5em;
        top: -5em;
    }
    .profil .bio{
        position: relative;
        font-size: 14px;
        line-height: 1.2;   
        margin: 17px 0em;
        left: 12em;
    }

    .postingan{
        height: 7em;
        width: 30%;
    }
    .detail_post{
    width: 90%;
    position: relative;
    left: 0.5em;
    }   
    .deskripsi{
        position: relative;
        left: -18em;
        top: 12em;
    }
    .foto{
        position: relative;
        left: -7.7em;
        height: 80px;
    }
    .pilihan{
        position: relative;
        left: 2.5em;
        top: -2px;
    }
    
}


</style>

<div class="profil">
<img src="{{asset('img/mobil.jpg')}}" class="foto_profil" alt="lol">
<h2>{{$data->name}} @if($data->id == auth()->user()->id) <a href="/setting_profile/{{$data->id}}"><i class="fa fa-cog pengaturan"></i></a>@endif</h2>
<br>

<b>{{$hitung}}</b><b class="kiriman" style="font-weight: 400">Kiriman</b>
<p class="bio">{!! nl2br($data->active)!!}</p>
</div><br><br>
<div class="postingannya">
<hr style="border: 1px solid black">
@foreach($data2 as $i)
@php
$gambar = explode('|',$i->gambar)
@endphp

<a href="#lihat_post/{{$i->id_laporan}}"><img src="{{asset('postingan/' . $gambar[0])}}" alt="postingan" class="postingan"></a>

@endforeach
</div>

@foreach ( $data2 as $d)
    
@php
$gambar_detail = explode('|',$d->gambar);
@endphp

<div id="lihat_post/{{$d->id_laporan}}" class="overlay">
        <div class="info">
            <div class="lol">
        <h2>Post<a href="#" class="keluar">&times</a></h2>
        @if(auth()->user()->id == $d->pengguna->id)<a href="#edit/{{$d->id_laporan}}" ids="{{$d->id_laporan}}" class="pilihan edits">Edit Postingan</a>@endif
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
            <p class="isi_deskripsi" style="display: flex;">{{$d->deskripsi}}</p>
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
                        <img class="detail_foto foto" src="{{asset('postingan/' . $gams)}}" id="detail_foto">
                        @endforeach
                </div>
            </div>
        </div>

        <div id="edit/{{$d->id_laporan}}" class="overlay">
        <div class="info">
            <div class="lol">
                <div class="isinya">
        
        <h2>Edit Info <a href="#edit/{{$d->id_laporan}}" class="btn btn-danger clicks" hapuskan="{{$d->id_laporan}}"><i class="fa fa-trash"></i></a> <a href="#" class="keluar">&times</a></h2>
        <hr style="border: 1px solid black;margin-top: -3px;">
        
         <textarea name="isi_buku" id="{{$d->id_laporan}}" class="area" style="height: 20em; width: 100%; border: none;outline: none" placeholder="Tulis Caption Anda..."></textarea><br>

        <a href="#" class="updates" id_update="{{$d->id_laporan}}"><button class="btn btn-primary">Simpan</button></a>
            </div>
        </div>
            </div>
</div>
  @endforeach
     
</div>

                 

<script>


$('.clicks').on('click',function(){
    var ids = $(this).attr('hapuskan');
    window.location = '/kembali/'+ids;
})
   

    $('.edits').on('click',function(){
        var ids = $(this).attr('ids');
        
        $.ajax({
                type: "GET",
                url: "/edit_post/" + ids,
                success: function(response) {
                    console.log(response.tampil.deskripsi);
                    $('.area').val(response.tampil.deskripsi);
                }
            })
        });

        $('.updates').on('click',function(){
            var ids = $(this).attr('id_update');
            var inputs = $('#'+ids).val();
            
           window.location = '/update_posts/'+ids+'/'+inputs+'/';
        })
</script>
@endsection