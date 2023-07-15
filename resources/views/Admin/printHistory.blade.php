<table>
    <thead>
        <tr>
            <th>ID</th>&nbsp;
            <th>Product</th>
            <th>User</th>
            <th>Status</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Lokasi</th>
            <th>Notes</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($history as $key => $value)
            <tr>

                <td>{{ $value->id }}</td>
                <td>{{ $value->Product->name }}</td>
                <td>{{ $value->User->name }}</td>
                <td>{{ $value->status }}</td>
                <td>{{ $value->jumlah }}</td>
                <td>{{ $value->kondisi }}</td>
                <td>{{ $value->lokasi }}</td>
                <td>{{ $value->notes }}</td>
                <td>{{ $value->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
