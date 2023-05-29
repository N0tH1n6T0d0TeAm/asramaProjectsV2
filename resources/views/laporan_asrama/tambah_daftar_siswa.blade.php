@extends('layouts.master')
@section('content')
@php error_reporting(0) @endphp
<style>
 table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }



  table caption {
    font-size: 1.3em;
  }

  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }


  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  table td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  table td:last-child {
    border-bottom: 0;
  }
}
</style>
<a href="{{route('admin.konfigurasiumum')}}">Tambah Angkatan/Jurusan</a> <br><br>
<form action="/tambah_profil_siswa" method="POST" enctype="multipart/form-data">
@csrf
<table class="table">
   <thead>
   <tr>
    <th>Foto Profil</th>
    <th>NIS</th>
    <th>NISN</th>
    <th>Nama Siswa</th>
    <th>Tempat Lahir</th>
    <th>Jurusan</th>
    <th>Angkatan</th>
    <th>Agama</th>
    <th>No Absen</th>
    <th>Tanggal Lahir</th>
   </tr>
</thead>
<tbody>
   <tr>
    <td data-label="Foto Profil"><input type="file" accept="image/*" name="foto_profil[]" class="form-control"></td>
    <td data-label="nis"><input type="number" name="nis[]" placeholder="NIS" class="form-control nis"></td>
    <td data-label="nisn"><input type="number" name="nisn[]" placeholder="NISN" class="form-control nisn"></td>
    <td data-label="nama siswa"><input type="text" name="nama_siswa[]" placeholder="Nama Siswa" class="form-control nama_siswa"></td>
    <td data-label="tempat lahir"><input type="text" name="tempat_lahir[]" placeholder="Tempat Lahir" class="form-control tempat_lahir"></td>
    <td data-label="jurusan"><select name="jurusan[]" class="form-control jurusan" id="">
                <option value="">Jurusan</option>
                @foreach($jurusan as $j)
                <option value="{{$j->id_jurusan}}">{{$j->jurusan}}</option>
                @endforeach
            </select></td>
            <td data-label="angkatan"><select name="angkatan[]" class="form-control angkatan" id="">
                <option value="">Angkatan</option>
                @foreach($angkatan as $a)
                <option value="{{$a->id_angkatan}}">{{$a->id_angkatan}}</option>
                @endforeach
            </select></td>

            <td data-label="agama">
            <select name="agama[]" class="form-control agama" id="">
                <option value="">Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Buddha">Buddha</option>
                <option value="Hindu">Hindu</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </td>
        <td data-label="no absen"><input type="number" name="no_absen[]" placeholder="No Absen" class="form-control no_absen"></td>
        <td data-label="tanggal lahir"><input type="date" name="tanggal_lahir[]" class="form-control tanggal_lahir"></td>
        <td><a href="#" class="btn btn-success tambah"><i class="fa fa-plus"></i></a></td>
   </tr>
</table>

<button class="btn btn-success simpan">Simpan</button>
</tbody>

</form>
<script>
  
  $('.tambah').on('click',function(){
    var td = `
    <tr>
    <td data-label="Foto Profil"><input type="file" name="foto_profil[]" class="form-control"></td>
    <td data-label="nis"><input type="number" name="nis[]" placeholder="NIS" class="form-control nis"></td>
    <td data-label="nisn"><input type="number" name="nisn[]" placeholder="NISN" class="form-control nisn"></td>
    <td data-label="nama_siswa"><input type="text" name="nama_siswa[]" placeholder="Nama Siswa" class="form-control nama_siswa"></td>
    <td data-label="tempat_lahir"><input type="text" name="tempat_lahir[]" placeholder="Nama Siswa" class="form-control tempat_lahir"></td>
    <td data-label="jurusan"><select name="jurusan[]" class="form-control jurusan" id="">
                <option value="">Jurusan</option>
                @foreach($jurusan as $j)
                <option value="{{$j->id_jurusan}}">{{$j->jurusan}}</option>
                @endforeach
            </select></td>
            <td data-label="angkatan"><select name="angkatan[]" class="form-control angkatan" id="">
                <option value="">Angkatan</option>
                @foreach($angkatan as $a)
                <option value="{{$a->id_angkatan}}">{{$a->id_angkatan}}</option>
                @endforeach
            </select></td>
            <td data-label="agama">
            <select name="agama[]" class="form-control agama" id="">
                <option value="">Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Buddha">Buddha</option>
                <option value="Hindu">Hindu</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </td>
        <td data-label="no absen"><input type="number" name="no_absen[]" placeholder="No Absen" class="form-control no_absen"></td>
        <td data-label="tanggal lahir"><input type="date" name="tanggal_lahir[]" class="form-control tanggal_lahir"></td>
        <td><a href="#" class="btn btn-danger kurang"><i class="fa fa-minus"></i></a></td>
   </tr>
    `;

    $('tbody').append(td);
  })

  $('tbody').delegate('.kurang','click',function(){
    $(this).parent().parent().remove();
  })

</script>

@endsection