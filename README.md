---

# CJMRI Web Journal

Cambodian Journal of Multidisciplinary Research and Innovation (CJMRI) is a modern web-based journal management system built with Laravel. This application allows researchers, editors, and readers to submit, manage, and access academic articles and publications efficiently.

---

## Features

* 📝 **Article Submission** – Allow authors to submit and manage research articles.
* 🧑‍⚖️ **Peer Review Management** – Support for reviewer assignment and review workflows.
* 📄 **PDF & File Upload** – Upload and manage PDF versions of articles.
* 🌐 **Multilingual Support** – Supports Khmer and English languages.
* 🔍 **Search & Filter** – Easily search and filter through published articles.
* 📢 **Announcements** – Display important news and updates for journal users.
* 🛠️ **Admin Panel** – Manage users, articles, categories, and settings.

---

## Technologies Used

* **Backend:** Laravel 11.x
* **Database:** MySQL 
* **Frontend:** Blade Templates
* **Authentication:** Laravel Breeze
* **File Storage:** Local (public), can be configured for S3
* **PDF Generation/Display:** DomPDF / embedded viewer

---

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/sreynich23/cjmi
   cd cjmi
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Set up environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure `.env`**

   * Set database credentials
   * Configure file storage (default: local)
   * Set mail configuration (for notifications)

5. **Run migrations**

   ```bash
   php artisan migrate
   ```

6. **Serve the application**

   ```bash
   php artisan serve
   ```

7. **(Optional) Seed demo data**

   ```bash
   php artisan db:seed
   ```

---

## File Upload Configuration

Ensure the storage link is created:

```bash
php artisan storage:link
```

Uploads are stored in:

```
public/storage/pdf_books
public/storage/images
```

---

## User Roles

| Role   | Permissions                                 |
| ------ | ------------------------------------------- |
| Admin  | Manage users, articles, settings            |
| Editor | Review submissions, approve/reject articles |
| Author | Submit and manage own articles              |
| Reader | View published content                      |

---

## Localization

This project supports **English** and **Khmer**. Language files are stored in:

```
resources/lang/en/
resources/lang/km/
```

---

## Deployment

Recommended to deploy with:

* **Web Server:** Nginx / Apache
* **PHP Version:** 8.1+
* **Queue:** Redis / Database queue for notifications
* **Scheduler:** Set up `php artisan schedule:run` via cron

---

## License

This project is open-source and licensed under the [MIT License](LICENSE).

---

## Contact

📧 **Email:** [cjmri@nubb.edu.kh](mailto:cjmri@nubb.edu.kh)
🌐 **Website:** [https://cjmri.nubb.edu.kh](https://cjmri.nubb.edu.kh)
📄 **Maintainer:** Long Sreynich

---

