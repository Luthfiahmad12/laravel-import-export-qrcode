<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Excel & QRcode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">masukkan file <small class="text-danger">*berupa
                                    file
                                    excel</small></label>
                            <input class="form-control" type="file" name="file" id="formFile" required>
                        </div>
                        <button type="submit" class="btn btn-primary"> Import</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                @if (session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                @elseif(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (!empty($data))
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">nama</th>
                                <th scope="col">prodi</th>
                                <th scope="col">angkatan</th>
                                <th scope="col">qrcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->prodi }}</td>
                                    <td>{{ $item->angkatan }}</td>
                                    <td><img src="{{ Storage::url($item->qrcode) }}" width="50px" alt=""></td>
                                    <td> <a href="{{ route('getQRCODE', $item->id) }}" class="btn btn-danger">Generate
                                            QRCODE</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('export') }}" class="btn btn-warning">EXPORT EXCEL</a>
                    <a href="{{ route('exportPDF') }}" class="btn btn-warning" target="__blank">EXPORT PDF</a>
                    <a href="{{ route('getALLQRCODE') }}" class="btn btn-warning">Generate All
                        QRCODE</a>
                    <a href="{{ route('deleteAllQRCODE') }}" class="btn btn-danger">DELETE All
                        QRCODE</a>
                @endif
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
