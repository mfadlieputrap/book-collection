<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Book List</h1>

    <form method="GET" action="{{ route('books.view') }}">
        <div style="display: flex; gap: 10px; align-items: center;">
            <label for="per_page">List Shown:</label>
            <select name="per_page" id="per_page" onchange="this.form.submit()">
                @foreach ([10, 20, 30, 40, 50, 60, 70, 80, 90, 100] as $option)
                    <option value="{{ $option }}" {{ $limit == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="search" placeholder="Search by title..." value="{{ $search ?? '' }}">
            <button type="submit">Search</button>
        </div>
    </form>


    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Book Name</th>
                <th>Category</th>
                <th>Author</th>
                <th>Average Rating</th>
                <th>Voter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $index => $book)
                <tr>
                    <td>{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name ?? '-' }}</td>
                    <td>{{ $book->author->name ?? '-' }}</td>
                    <td>{{ number_format($book->ratings_avg_rating, 2) ?? '0.00' }}</td>
                    <td>{{ $book->voter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Top 10 Most Famous Author</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Author Name</th>
                <th>Voter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topTenAuthors as $index => $author)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->five_star_votes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {!! $books->links('pagination::simple-default') !!}
</body>
</html>
