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

    

</body>
</html>
