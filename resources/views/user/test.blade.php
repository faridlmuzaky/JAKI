<table>
    @foreach ($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->username }}</td>
        <td>{{ $item->name }}</td>
        <td>
            <img src="{{ asset('images').'/'.$item->profile_photo_path }}" alt="" style="width:100px;" />
        </td>
    </tr>
    @endforeach
</table>
