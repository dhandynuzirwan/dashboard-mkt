@extends('layouts.app')
@section('content')

<div class="container">
    <h3>Pending Download Approval</h3>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Alasan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
            <tr>
                <td>{{ $r->user->name }}</td>
                <td>{{ $r->reason }}</td>
                <td>{{ $r->created_at }}</td>
                <td>
                    <form action="{{ route('download.approve', $r->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>

                    <form action="{{ route('download.reject', $r->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection