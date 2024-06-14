<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-light">
    <main class="container">
        <!-- START FORM -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="search-box">
                        <h2 class="text-center mb-4">Find Your Perfect Room</h2>
                        <form action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword"
                                    placeholder="Search for Kost...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="search-results">
                        <!-- Hasil Pencarian akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Nama Kost</th>
                        <th class="col-md-3">Deskripsi</th>
                        <th class="col-md-2">Lokasi</th>
                        <th class="col-md-2">Harga</th>
                        <th class="col-md-2">Gambar</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    .@foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['deskripsi'] }}</td>
                            <td>{{ $item['lokasi'] }}</td>
                            <td>{{ $item['harga'] }}</td>
                            <td>{{ $item['gambar'] }}</td>
                            <td>
                                <a href="" class="btn btn-warning btn-sm">Edit</a>
                                <a href="" class="btn btn-danger btn-sm">Del</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>
