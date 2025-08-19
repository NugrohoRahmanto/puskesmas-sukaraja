{{-- @foreach ($queues as $queue)
    <tr>
        <td>{{ $queue->no_antrian }}</td>
        <td>{{ $queue->patient->nama_lengkap }}</td>
        <td>
            @can('update', $queue)
                <a href="{{ route('queues.edit', $queue->id_antrian) }}" class="text-blue-500">Edit</a>
            @endcan
            @can('delete', $queue)
                <form action="{{ route('queues.destroy', $queue->id_antrian) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Hapus</button>
                </form>
            @endcan
        </td>
    </tr>
@endforeach --}}
