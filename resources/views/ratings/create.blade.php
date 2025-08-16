@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="page-title">Input Rating</h2>
    </div>
    
    <div class="card-body">
        <form action="{{ route('ratings.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Book Author:</label>
                <select name="author_id" id="author_id" class="form-select" required>
                    <option value="">Select Author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Book Name:</label>
                <select name="book_id" id="book_id" class="form-select" required disabled>
                    <option value="">Select Book</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Rating:</label>
                <select name="rating" class="form-select" required>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-md">SUBMIT</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#author_id').change(function() {
            const authorId = $(this).val();
            
            if (authorId) {
                $('#book_id').prop('disabled', false);
                
                $.ajax({
                    url: `/authors/${authorId}/books`,
                    method: 'GET',
                    success: function(data) {
                        $('#book_id').empty();
                        $('#book_id').append('<option value="">Select Book</option>');
                        
                        $.each(data, function(index, book) {
                            $('#book_id').append(`<option value="${book.id}">${book.title}</option>`);
                        });
                    }
                });
            } else {
                $('#book_id').prop('disabled', true);
                $('#book_id').empty();
                $('#book_id').append('<option value="">Select Book</option>');
            }
        });
    });
</script>
@endsection