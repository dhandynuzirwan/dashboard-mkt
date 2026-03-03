@extends('layouts.app')
@section('content')

<div class="container">
    <h3>My Download Requests</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
            <tr>
                <td>{{ $r->created_at }}</td>
                <td>{{ $r->reason }}</td>
                <td>
                    @if($r->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($r->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    @if($r->status == 'approved')
                        <a href="{{ route('download.file', $r->id) }}"
                           class="btn btn-primary btn-sm">
                           Download
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection