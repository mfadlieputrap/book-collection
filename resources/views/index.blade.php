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
                    <td>{{ ($currentPage - 1) * $limit + $loop->iteration }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category_name ?? '-' }}</td>
                    <td>{{ $book->author_name ?? '-' }}</td>
                    <td>{{ number_format($book->rating_avg ?? 0, 2) }}</td>
                    <td>{{ $book->voter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <div style="display: flex; justify-content: center; gap: 10px;">
            @if ($currentPage > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}">← Prev</a>
            @endif

            <span>Page {{ $currentPage }} of {{ $totalPages }}</span>

            @if ($currentPage < $totalPages)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Next →</a>
            @endif
        </div>
    </div>
    

</body>
</html>
