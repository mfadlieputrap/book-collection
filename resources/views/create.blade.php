
<div class="container">
    <h2>Insert Rating</h2>

    <form method="POST" action="{{ route('ratings.store') }}" >
    @csrf

    <div>
        <label>Book Author:</label>
        <select id="authorDropdown" class="form-select">
        <option value="">-- Select Author --</option>
        @foreach ($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
        @endforeach
        </select>
    </div>

    <div class="mt-2">
        <label>Book Name:</label>
        <select id="bookDropdown" name="book_id" class="form-select" required>
        <option value="">-- Select Book --</option>
        {{-- Diisi dinamis pakai JavaScript --}}
        </select>
    </div>

    <div class="mt-2">
        <label>Rating:</label>
        <input type="number" name="rating" min="1" max="10" required class="form-control">
    </div>

    <div class="mt-3">
        <a href="http://localhost:8000/books">
            <button type="submit" class="btn btn-primary" >Submit</button>
        </a>
    </div>
    </form>
    </div>

    <script>
    const authorDropdown = document.getElementById('authorDropdown');
    const bookDropdown = document.getElementById('bookDropdown');

    authorDropdown.addEventListener('change', function () {
    const authorId = this.value;

    // Clear current options
    bookDropdown.innerHTML = '<option value="">-- Select Book --</option>';

    if (authorId) {
        fetch(`/authors/${authorId}/books`)
        .then(res => res.json())
        .then(data => {
            data.books.forEach(book => {
            const option = document.createElement('option');
            option.value = book.id;
            option.text = book.title;
            bookDropdown.appendChild(option);
            });
        });
    }
    });
</script>
