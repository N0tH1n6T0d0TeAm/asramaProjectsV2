@extends('layouts.master')
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
    margin: 5% 30% auto;
    background: #fff;
    width: 40%;
    border-radius: 3px;
    padding: 70px 0;
}
.overlay .info button{
    float: right;
    margin: 10px;
}
a.keluar{
    float: right;
    color: black;
    text-decoration: none;
}
.overlay .info .textarea{
    width: 90%;
    margin: 0 10px;
}

@media(max-width: 376px){
    tbody{
        font-size: 10px;
    }
}

@media(max-width: 420px){
    tbody{
        font-size: 10px;
    }
}
@media(max-width: 282px){
    table{
        position: relative;
        left: -1em;
    }
    tbody{
        font-size: 7px;
    }
}

</style>

<div class="card">
  <div class="card-header">
    <form action="/beri_catatan" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="ids" value="{{$data->id_perkembangan}}">
   <input type="text" value="{{$data->judul_buku}}" name="judul_buku" style="width: 50%" placeholder="Judul Catatan" class="form-control"> 
   <select class="form-control" name="level_kategori" id="halaman" style="width: 20%; float:right; margin-top: -40px;">
    <option value="">Kategori</option>
    <option value="Umum" {{$data->level_kategori == 'Umum' ? 'selected' : ''}}>Umum</option>
    <option value="#confidensial" {{$data->level_kategori == 'Confidensial' ? 'selected' : ''}}>Confidensial</option>
   </select>
   <br>
   <a href="/catatan_perkembangan/{{$data->id_perkembangan}}" class="btn btn-info">Kembali</a>
   {{-- <a href="#tambah_kategori" class="btn btn-success">Tambah Kategori</a>
   <a href="#edit_kategori" class="btn btn-warning">Edit Kategori</a> --}}
  </div>
  <div class="card-body">
   <textarea name="isi_buku" class="form-control" style="height: 50em" placeholder="Catatan Anda...">{{$data->isi_buku}}</textarea><br>
   <center>
   <button class="btn btn-success">Simpan</button>
   </center>
</form>
  </div>
</div>

<script>
     $(document).ready(function(){
    $('#halaman').on('change', function(){
      var url = $(this).val();
      if(url && url != "Umum"){
        window.location = url;
      }
      return false;
    });
  });
</script>

 <div id="confidensial" class="overlay" style="overflow-y: scroll;">
    <div class="info">
        <div class="lol">
            <div class="isinya" style="margin-top: -3em;">
    <form action="/tambah_confidensial" method="POST">
    @csrf
    <input type="hidden" name="id_perkembangan" value="{{$data->id_perkembangan}}">
    <h2>Confidensial <a href="#" class="keluar">&times</a></h2>

    <hr style="border: 1px solid black;margin-top: -3px;">
     <table>
        <thead>
        <tr>
            <td><label>Nama Pamong</label></td>
        </tr>
    </thead>
    
    <tbody class="isi">
        <tr>
            <td><input type="text" style="width: 100%" name="nama_pamong[]" class="form-control" list="pamong" autocomplete="off" placeholder="Nama Pamong" required></td>
            <td><a href="#confidensial" style="margin: 15px;" class="btn btn-success tambahs"><i class="fas fa-plus"></i></a></td>
        </tr>
    </tbody>
    </table>
    <button class="btn btn-primary">Tambah</button>
    </form>
            </div>
        </div>
    </div>
</div>


<datalist id="pamong">
    @foreach($data3 as $d)
        <option value="{{ $d->user->name }}">
    @endforeach
</datalist>

<script>
    $('.tambahs').on('click',function(){
        var isi = `<tr>
            <td><input type="text" style="width: 100%" name="nama_pamong[]" class="form-control" placeholder="Nama Pamong" list="pamong" autocomplete="off" required></td>
            <td><a href="#confidensial" style="margin: 15px;" class="btn btn-danger hapus"><i class="fas fa-minus"></i></a></td>
        </tr>`;
        $('.isi').append(isi);
    })

    $('.isi').delegate('.hapus','click',function(){
        $(this).parent().parent().remove();
    })
</script>

{{-- <div id="edit_kategori" class="overlay">
    <div class="info">
        <div class="lol">
    
    <h2>Edit Kategori <a href="/edit_catatan/{{$data->id_perkembangan}}" class="keluar">&times</a></h2>

    <hr style="border: 1px solid black;margin-top: -3px;">
    <label>Edit Kategori</label><br>
    <div class="alert alert-success d-none">Update Data Berhasil!</div>
    @foreach($data2 as $d)
     <input class="form-control up_kats inputs" style="width: 50%;" ids="{{ $d->id_kategori }}"  type="text" id="{{ $d->id_kategori }}" name="kategori" value="{{ $d->nama_kategori }}" placeholder="Kategori" required />
     <button class="btn btn-success update" id_kats="{{ $d->id_kategori }}"><i class="fa fa-check"></i></button> 
     <a href="#" class="btn btn-danger hapus_kat" id_h="{{ $d->id_kategori }}"><i class="fas fa-trash"></i></a><br>
    @endforeach
        </div>
    </div>
</div>

<script>
$('.update').click(function(){
    var ids = $(this).attr('id_kats');
    var lol2 = $('#'+ids).val();
    $.ajax({
        url : '/update_kategori/'+ids+'/'+lol2+'/',
        method: 'get',
        success: function(result){
            $('.alert-success').removeClass('d-none');
            setTimeout(function(){
                $('.alert-success').addClass('d-none');
            },3000);
        }
    })
})

$(document).on('click','.hapus_kat',function(e){
    e.preventDefault();
    var id_hapus = $(this).attr('id_h');
    swal({
        title: "Apakah Anda Ingin Menghapus Kategori Ini?",
        text: "Jika Anda Menghapus Data Ini Maka Data Ini Akan Hilang Selamanya!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((kategori_hapus) => {
        if(kategori_hapus){
            $.ajax({
                url: "/hapus_kategori/" +id_hapus,
                type: "DELETE",
                data:{
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                    swal("Data Berhasil Dihapus",{icon: "success"});
                    window.location.reload();
                }
            })
        }else{
            swal("Data Anda Aman!",{icon: "info"});
        }
    })
})
</script> --}}
@endsection