# Malavika M M — Full Stack Developer Portfolio & Resume Website

A professional, responsive personal developer resume and portfolio website engineered with a clean full-stack architecture: **Laravel (PHP) backend**, **Vue.js 3 frontend**, **Vite asset pipeline**, and **MySQL database**.

---

## 🌟 Key Features

- **Professional Aesthetic**: Sleek developer theme, subtle glow accents, dark glassmorphism, responsive across desktop, tablet, and mobile devices.
- **RESTful API Backend**: Decoupled Laravel 11 API endpoints with validation, database transactions, and proper HTTP status codes.
- **Dynamic Vue.js 3 SPA**: Fast client-side routing with Vue Router, reactive state, categorized skills filtering, live project search, and modal inspection views.
- **Database-Driven Content**: Profile, technical skills, projects, work experience, university education, certifications, and social links are fully manageable via the Admin CMS without editing code.
- **Secure Admin Dashboard**: Token-authenticated control center supporting CRUD operations, file uploads (profile avatars & PDF resumes), and an inbox to read and manage recruiter messages.
- **Real-Time Contact Form**: Dual-layer frontend + backend validation, persistent MySQL message storage, and instant visual toast feedback.
- **Downloadable Resume**: Direct resume PDF serving and downloading, alongside a print-ready fullscreen resume route.
- **SEO & Social Metadata**: Pre-configured Open Graph tags, Twitter card metadata, semantic HTML5, and responsive layouts.

---

## 📂 Project Architecture

```
resume/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AdminController.php     # Admin CRUD & file upload handlers
│   │   │       ├── AuthController.php      # Admin authentication & token generation
│   │   │       └── PublicController.php    # Public REST endpoints & resume download
│   │   └── Middleware/
│   │       └── AdminAuthMiddleware.php     # Bearer token & session auth guard
│   └── Models/
│       ├── Certification.php
│       ├── ContactMessage.php
│       ├── Education.php
│       ├── Experience.php
│       ├── Profile.php
│       ├── Project.php
│       ├── ProjectImage.php
│       ├── Skill.php
│       ├── SocialLink.php
│       └── User.php
├── bootstrap/
│   └── app.php                             # Route registration & middleware configuration
├── config/
│   ├── database.php
│   └── filesystems.php
├── database/
│   ├── migrations/                         # 11 normalized database migrations
│   └── seeders/
│       └── DatabaseSeeder.php              # Idempotent database seeder with real resume data
├── public/
│   ├── build/                              # Vite production compiled assets
│   ├── images/
│   │   ├── avatar.jpg                      # Developer profile avatar
│   │   └── projects/*.svg                  # 10 custom project visual covers
│   └── storage/
│       ├── avatars/
│       ├── projects/
│       └── resumes/                        # Publicly served resume PDFs
├── resources/
│   ├── css/
│   │   └── app.css                         # Tailwind CSS & custom glassmorphism styles
│   ├── js/
│   │   ├── App.vue                         # Root Vue component
│   │   ├── app.js                          # Vue initialization & router attachment
│   │   ├── components/
│   │   │   ├── About.vue
│   │   │   ├── Certifications.vue
│   │   │   ├── Contact.vue
│   │   │   ├── Education.vue
│   │   │   ├── Experience.vue
│   │   │   ├── Footer.vue
│   │   │   ├── Hero.vue
│   │   │   ├── Navbar.vue
│   │   │   ├── ProjectCard.vue
│   │   │   ├── ProjectModal.vue
│   │   │   ├── Projects.vue
│   │   │   ├── ResumeSection.vue
│   │   │   └── Skills.vue
│   │   ├── router/
│   │   │   └── index.js                    # Vue Router with navigation guards
│   │   ├── services/
│   │   │   └── api.js                      # Axios instance with interceptors
│   │   └── views/
│   │       ├── HomeView.vue                # Main portfolio page
│   │       ├── LoginView.vue               # Admin authentication page
│   │       ├── ProjectDetailView.vue       # Standalone project deep dive
│   │       ├── ResumeView.vue              # Print-ready resume page
│   │       └── admin/                      # Complete Admin CMS views
│   └── views/
│       └── app.blade.php                   # Single Page Application Blade layout
├── routes/
│   ├── api.php                             # 50 API endpoints
│   └── web.php                             # SPA fallback route
├── tailwind.config.js
└── vite.config.js
```

---

## 🛠️ Prerequisites

- **PHP**: `^8.2` (with `pdo_mysql`, `pdo_sqlite`, `openssl`, `mbstring`, `fileinfo` extensions enabled)
- **Node.js**: `^18.0` or `^20.0` or `^22.0`
- **npm**: `^9.0` or `^10.0`
- **Database**: MySQL `^8.0` (or MariaDB `^10.4`, or SQLite `^3.0`)

---

## 🚀 Local Development Setup

### 1. Configure Environment (`.env`)

Copy `.env.example` to `.env` if not already present:

```bash
cp .env.example .env
```

Ensure your `APP_KEY` is generated:

```bash
php artisan key:generate
```

### 2. Configure Database Connection

#### For MySQL (Default):

In your `.env` file, configure your MySQL credentials:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_db
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in MySQL:

```sql
CREATE DATABASE portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### For SQLite (Alternative / Testing):

```ini
DB_CONNECTION=sqlite
```

Ensure `database/database.sqlite` exists:

```bash
touch database/database.sqlite
```

### 3. Run Database Migrations & Seeders

The seeders are **100% idempotent** using `updateOrCreate`, so running them multiple times will never create duplicate records:

```bash
# Run database migrations
php artisan migrate

# Seed with Malavika's resume data & admin account
php artisan db:seed
```

### 4. Build Frontend Assets

```bash
# For local hot-reload development
npm run dev

# Or build optimized production bundles
npm run build
```

### 5. Start the Laravel Backend Server

```bash
php artisan serve
```

Visit the website in your browser at: **`http://localhost:8000`**

---

## 🔐 Admin Dashboard Access

- **Admin URL**: `http://localhost:8000/login` (or click the "Admin Portal" link in the footer)
- **Default Email**: `malavikamm177@gmail.com`
- **Default Password**: `admin12345`

### Admin Capabilities:
1. **Profile & About**: Edit bio, career objective, strengths, phone, location, and upload a new profile photo.
2. **Resume Upload**: Upload updated resume PDFs directly; immediately reflected on the public download button.
3. **Projects Management**: Add new projects, upload screenshots, assign categories, manage tech tags, and mark featured items.
4. **Skills Management**: Update proficiency percentages, change categories, and update skill levels.
5. **Timeline & Experience**: Manage roles, companies, achievements, and dates.
6. **Education & Certifications**: Update degrees, universities, credentials, and verification links.
7. **Social Profiles**: Add or toggle GitHub, LinkedIn, or personal links.
8. **Contact Inbox**: View recruiter submissions, mark inquiries as read, or reply directly via email.

---

## 📡 API Endpoint Reference

### Public API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/initial-data` | Aggregated portfolio payload for snappy SPA boot |
| `GET` | `/api/profile` | Developer profile details, bio, and stats |
| `GET` | `/api/skills` | List of skills categorized with proficiencies |
| `GET` | `/api/education` | Academic degrees, colleges, and scores |
| `GET` | `/api/experience` | Career history and internship timeline |
| `GET` | `/api/projects` | Project cards (supports `?category=` and `?search=`) |
| `GET` | `/api/projects/{id}` | Single project detail by ID or slug |
| `GET` | `/api/certifications` | Technical certifications and credentials |
| `GET` | `/api/social-links` | Active social profiles |
| `POST` | `/api/contact` | Validated contact form submission |
| `GET` | `/api/resume/download` | Public downloadable resume PDF |
| `POST` | `/api/auth/login` | Admin authentication returning Bearer token |

### Admin Endpoints (Requires `Authorization: Bearer <token>`)

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/admin/overview` | Dashboard counts and recent messages |
| `GET` / `PUT` | `/api/admin/profile` | Get or update profile details |
| `POST` | `/api/admin/resume/upload` | Upload replacement resume PDF |
| `POST` | `/api/admin/avatar/upload` | Upload replacement avatar image |
| `GET` / `POST` | `/api/admin/projects` | List or create projects |
| `PUT` / `DELETE`| `/api/admin/projects/{id}` | Update or delete project |
| `POST` | `/api/admin/projects/{id}/image`| Upload screenshot for project |
| `GET` / `POST` | `/api/admin/skills` | List or add skill |
| `PUT` / `DELETE`| `/api/admin/skills/{id}` | Update proficiency or delete skill |
| `GET` / `POST` | `/api/admin/experience` | Manage experience timeline |
| `GET` / `POST` | `/api/admin/education` | Manage education history |
| `GET` / `POST` | `/api/admin/certifications`| Manage certifications |
| `GET` / `POST` | `/api/admin/social-links` | Manage social links |
| `GET` | `/api/admin/messages` | View contact messages inbox |
| `PATCH` | `/api/admin/messages/{id}/read` | Mark message as read |
| `DELETE` | `/api/admin/messages/{id}` | Delete contact message |

---

## 🌐 Production Deployment Guide

### Option 1: VPS / Cloud Server (Ubuntu, Nginx, PHP-FPM, MySQL)

1. **Clone repository onto the server:**
   ```bash
   git clone https://github.com/19Malavika/resume-portfolio.git /var/www/resume
   cd /var/www/resume
   ```

2. **Install Composer & Node dependencies:**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   nano .env
   # Set APP_ENV=production, APP_DEBUG=false, APP_URL=https://yourdomain.com
   # Set DB_CONNECTION=mysql with your production database credentials
   php artisan key:generate
   ```

4. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Set Directory Permissions:**
   ```bash
   sudo chown -R www-data:www-data /var/www/resume/storage /var/www/resume/bootstrap/cache
   sudo chmod -R 775 /var/www/resume/storage /var/www/resume/bootstrap/cache
   ```

6. **Sample Nginx Configuration (`/etc/nginx/sites-available/resume`):**
   ```nginx
   server {
       listen 80;
       listen [::]:80;
       server_name yourdomain.com www.yourdomain.com;
       root /var/www/resume/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;
       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

7. **Issue Free SSL with Let's Encrypt:**
   ```bash
   sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

---

## 🔗 Connecting to a Custom Domain

1. In your domain registrar (Namecheap, GoDaddy, Cloudflare, etc.):
   - Add an **A Record**:
     - Host: `@`
     - Value: `<Your-Server-Public-IP-Address>`
     - TTL: `Automatic` or `300`
   - Add a **CNAME Record**:
     - Host: `www`
     - Value: `yourdomain.com`
2. Update `.env` on your production server:
   ```ini
   APP_URL=https://yourdomain.com
   ```
3. Run config cache on production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🧪 Testing

Run PHP unit & integration tests:

```bash
php artisan test
```

---

## 👩‍💻 Author & Contact

**Malavika M M**
- Full Stack Developer (Flutter • Laravel • PHP)
- Thrissur, Kerala, India
- Email: [malavikamm177@gmail.com](mailto:malavikamm177@gmail.com)
- Phone: [+91 7736192047](tel:7736192047)
- GitHub: [https://github.com/19Malavika](https://github.com/19Malavika)
- LinkedIn: [https://www.linkedin.com/in/malavika-m-m-b722142a0/](https://www.linkedin.com/in/malavika-m-m-b722142a0/)

