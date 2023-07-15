<table>
    <thead>
        <tr>
            <th>ID</th>&nbsp;
            <th>Barang</th>
            <th>Merk</th>
            <th>Stok Awal</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Updated By</th>
            <th>Tanggal Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $key => $value)
            <tr>

                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->merk }}</td>
                <td>{{ $value->stok_awal }}</td>
                <td>{{ $value->stok }}</td>
                <td>{{ $value->Lokasi->name }}</td>
                <td>{{ $value->User->name }}</td>
                <td>{{ $value->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
