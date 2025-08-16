@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="page-title">Books List</h2>
    </div>

    <div class="card-body">
        <div class="filter-container mb-4">
            <form action="{{ route('books.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Show:</label>
                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                        @foreach([10, 20, 30, 50, 100] as $value)
                            <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Search:</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by book name or author..." value="{{ $search }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Book Name</th>
                        <th>Category Name</th>
                        <th>Author Name</th>
                        <th>Average Rating</th>
                        <th>Voter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->author->name }}</td>
                        <td>
                            {{ number_format($book->average_rating, 2) }}
                        </td>
                        <td>{{ number_format($book->voter) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No books found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection