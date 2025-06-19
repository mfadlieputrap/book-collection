# 📚 Laravel Book Ratings Project

This is a Laravel 10 test project to manage a collection of books, authors, and their ratings. Users can view book lists, filter and search, rate books, and check top authors based on ratings.

## ✅ Requirements

* PHP >= 8.1
* Composer
* MySQL or MariaDB
* Laravel 10
* Node.js & npm (for asset compilation, optional)

---

## ⚙️ Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/mfadlieputrap/book-collection.git
   cd book-collection
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Set Up Environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   Edit the `.env` file and set the database credentials:

   ```env
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

5. **Run Migrations & Seeders**

   ```bash
   php artisan migrate --seed
   ```

6. **Run the Development Server**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000/books` for book list page  
   Visit `http://localhost:8000/rating` for input rating page  
   Visit `http://localhost:8000/top-10-famous-author` for see top 10 most famous author

---

## 📄 Features

* View paginated list of books with their authors and categories
* Search books by title or author
* Rate books from 1 to 10
* Display top 10 authors based on 5+ star ratings

---

## 📁 Project Structure

* `app/Models` — Eloquent models for Books, Authors, Ratings
* `app/Http/Controllers` — Logic for listing, filtering, rating, etc
* `resources/views` — Blade views for frontend display
* `routes/web.php` — Web routes for user interaction

---

## 🔍 Debugging Tips

* Use Laravel Debugbar or `DB::enableQueryLog()` to trace queries
* Run `php artisan route:list` to verify routes
* Use browser devtools + Laravel logs to troubleshoot frontend/backend issues

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first.

---

## 📜 License

This project is open-source and available under the [MIT License](LICENSE).

---

*Developed for Timedoor Backend Programming Test.*
