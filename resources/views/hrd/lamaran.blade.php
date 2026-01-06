@extends('layouts.hrd')

@section('title', 'Data Lamaran')

@section('content')
<div class="container py-4">

<h4>Data Lamaran Pelamar</h4>

<table class="table table-bordered mt-3">
<thead>
<tr>
    <th>Nama Pelamar</th>
    <th>Lowongan</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
@foreach($applications as $a)
<tr>
    <td>{{ $a->user->name }}</td>
    <td>{{ $a->lowongan->nama_lowongan }}</td>
    <td>
        <form method="POST" action="/hrd/lamaran/{{ $a->id }}">
            @csrf
            @method('PUT')

            <select name="status"
                class="form-select"
                onchange="this.form.submit()">

                @foreach(['diproses','screening','interview','diterima','ditolak'] as $s)
                    <option value="{{ $s }}" @selected($a->status == $s)>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach

            </select>
        </form>
    </td>
</tr>
@endforeach
</tbody>

</table>

</div>
@endsection
