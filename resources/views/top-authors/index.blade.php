@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="page-title">Top 10 Most Famous Authors</h2>
        <p class="text-muted mb-0">Showing authors with the most ratings above 5</p>
    </div>
    
    <div class="card-body">
        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Author Name</th>
                        <th>Voter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ number_format($author->voter) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection