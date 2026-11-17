<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Certification;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database idempotently.
     */
    public function run(): void
    {
        // 1. Admin User (Idempotent updateOrCreate)
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'malavikamm177@gmail.com')],
            [
                'name' => 'Malavika M M',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin12345')),
                'api_token' => Str::random(60),
                'email_verified_at' => now(),
            ]
        );

        // 2. Profile Details
        Profile::updateOrCreate(
            ['email' => 'malavikamm177@gmail.com'],
            [
                'name' => 'Malavika M M',
                'title' => 'Full Stack Developer',
                'tagline' => 'Specializing in Flutter Mobile & Laravel/PHP Full-Stack Development',
                'short_intro' => 'Full Stack Developer specializing in Flutter for mobile frontend development and Laravel/PHP for robust backend systems. Hands-on experience building scalable, responsive, and database-driven applications with clean architecture and reactive state management.',
                'career_objective' => 'Passionate and results-driven software engineer aiming to build scalable, high-performance web and mobile solutions. Dedicated to applying clean architecture, reactive state management (Riverpod), and robust backend engineering with Laravel and RESTful APIs to solve real-world problems.',
                'bio' => 'I am a Full Stack Developer with strong foundations in Flutter, Dart, Laravel, PHP, React, and MySQL. With experience architecting enterprise resource management systems, fintech UI applications, and reactive mobile applications, I bridge the gap between polished user experiences and solid backend architectures. Strong advocate of Clean Architecture, feature-based modularity, and database-driven workflows.',
                'phone' => '+91 7736192047',
                'location' => 'Thrissur, Kerala, India',
                'avatar_url' => '/images/avatar.jpg',
                'resume_path' => '/storage/resumes/Malavika_MM_Resume.pdf',
                'strengths' => [
                    'Clean Architecture & Riverpod 3.x State Management',
                    'Full-Stack API Design & Laravel MVC Architecture',
                    'Role-Based Access Control & Database Relationships',
                    'Custom Widget & Canvas Rendering with CustomPainter',
                    'Cross-Platform Responsive Mobile & Web UI/UX',
                    'Transactional Database Integrity & Conflict Prevention'
                ],
                'interests' => [
                    'Mobile Architecture (Flutter & Riverpod)',
                    'Backend API Engineering (Laravel & PHP)',
                    'Modern Frontend (Vue.js & React)',
                    'Cloud & Realtime Databases (Firebase & MySQL)',
                    'Open Source Software & Developer Tooling'
                ],
                'stats' => [
                    ['label' => 'Projects Completed', 'value' => '10+'],
                    ['label' => 'Core Stacks', 'value' => 'Flutter & Laravel'],
                    ['label' => 'Clean Code Discipline', 'value' => '100%'],
                    ['label' => 'Location', 'value' => 'Kerala, India']
                ]
            ]
        );

        // 3. Social Links
        $socials = [
            [
                'platform' => 'GitHub',
                'label' => 'github.com/19Malavika',
                'url' => 'https://github.com/19Malavika',
                'icon' => 'github',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'platform' => 'LinkedIn',
                'label' => 'linkedin.com/in/malavika-m-m',
                'url' => 'https://www.linkedin.com/in/malavika-m-m-b722142a0/',
                'icon' => 'linkedin',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'platform' => 'Email',
                'label' => 'malavikamm177@gmail.com',
                'url' => 'mailto:malavikamm177@gmail.com',
                'icon' => 'mail',
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'platform' => 'Phone',
                'label' => '+91 7736192047',
                'url' => 'tel:7736192047',
                'icon' => 'phone',
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($socials as $social) {
            SocialLink::updateOrCreate(
                ['platform' => $social['platform']],
                $social
            );
        }

        // 4. Skills categorized
        $skills = [
            // Programming
            ['name' => 'Dart', 'category' => 'Programming', 'proficiency' => 92, 'level_label' => 'Advanced', 'icon' => 'dart', 'display_order' => 1],
            ['name' => 'PHP', 'category' => 'Programming', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'php', 'display_order' => 2],
            ['name' => 'JavaScript', 'category' => 'Programming', 'proficiency' => 85, 'level_label' => 'Proficient', 'icon' => 'javascript', 'display_order' => 3],
            ['name' => 'Python', 'category' => 'Programming', 'proficiency' => 80, 'level_label' => 'Intermediate', 'icon' => 'python', 'display_order' => 4],
            ['name' => 'HTML5 & CSS3', 'category' => 'Programming', 'proficiency' => 90, 'level_label' => 'Advanced', 'icon' => 'html5', 'display_order' => 5],

            // Mobile Development
            ['name' => 'Flutter', 'category' => 'Mobile', 'proficiency' => 94, 'level_label' => 'Advanced', 'icon' => 'flutter', 'display_order' => 1],
            ['name' => 'Riverpod 3.x', 'category' => 'Mobile', 'proficiency' => 90, 'level_label' => 'Advanced', 'icon' => 'code', 'display_order' => 2],
            ['name' => 'Material 3 UI', 'category' => 'Mobile', 'proficiency' => 92, 'level_label' => 'Advanced', 'icon' => 'layout', 'display_order' => 3],
            ['name' => 'CustomPainter & Canvas', 'category' => 'Mobile', 'proficiency' => 85, 'level_label' => 'Proficient', 'icon' => 'pen-tool', 'display_order' => 4],
            ['name' => 'Cross-Platform UI/UX', 'category' => 'Mobile', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'smartphone', 'display_order' => 5],

            // Backend
            ['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 90, 'level_label' => 'Advanced', 'icon' => 'server', 'display_order' => 1],
            ['name' => 'RESTful APIs', 'category' => 'Backend', 'proficiency' => 92, 'level_label' => 'Advanced', 'icon' => 'api', 'display_order' => 2],
            ['name' => 'MVC Architecture', 'category' => 'Backend', 'proficiency' => 90, 'level_label' => 'Advanced', 'icon' => 'layers', 'display_order' => 3],
            ['name' => 'Eloquent ORM', 'category' => 'Backend', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'database', 'display_order' => 4],
            ['name' => 'Auth & RBAC', 'category' => 'Backend', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'shield', 'display_order' => 5],

            // Frontend
            ['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 86, 'level_label' => 'Proficient', 'icon' => 'vue', 'display_order' => 1],
            ['name' => 'React.js', 'category' => 'Frontend', 'proficiency' => 85, 'level_label' => 'Proficient', 'icon' => 'react', 'display_order' => 2],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'wind', 'display_order' => 3],
            ['name' => 'Bootstrap', 'category' => 'Frontend', 'proficiency' => 85, 'level_label' => 'Proficient', 'icon' => 'grid', 'display_order' => 4],

            // Databases
            ['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'database', 'display_order' => 1],
            ['name' => 'SQLite', 'category' => 'Database', 'proficiency' => 85, 'level_label' => 'Proficient', 'icon' => 'hard-drive', 'display_order' => 2],
            ['name' => 'Firebase / Firestore', 'category' => 'Database', 'proficiency' => 82, 'level_label' => 'Proficient', 'icon' => 'flame', 'display_order' => 3],

            // Tools & Architecture
            ['name' => 'Git & GitHub', 'category' => 'Tools', 'proficiency' => 90, 'level_label' => 'Advanced', 'icon' => 'git-branch', 'display_order' => 1],
            ['name' => 'Clean Architecture', 'category' => 'Tools', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'box', 'display_order' => 2],
            ['name' => 'VS Code', 'category' => 'Tools', 'proficiency' => 92, 'level_label' => 'Advanced', 'icon' => 'terminal', 'display_order' => 3],
            ['name' => 'Figma UI/UX', 'category' => 'Tools', 'proficiency' => 80, 'level_label' => 'Intermediate', 'icon' => 'figma', 'display_order' => 4],
            ['name' => 'Axios & REST Integration', 'category' => 'Tools', 'proficiency' => 88, 'level_label' => 'Proficient', 'icon' => 'send', 'display_order' => 5],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name'], 'category' => $skill['category']],
                $skill
            );
        }

        // 5. Education
        Education::updateOrCreate(
            ['degree' => 'B.Tech in Computer Science and Engineering', 'institution' => 'Government Engineering College, Wayanad'],
            [
                'university' => 'APJ Abdul Kalam Technological University (KTU)',
                'location' => 'Kerala, India',
                'duration' => '2020 - 2024',
                'cgpa' => '8.2 CGPA',
                'description' => 'Comprehensive coursework in Software Engineering, Data Structures & Algorithms, Database Management Systems, Computer Networks, and Object-Oriented System Design. Actively engaged in leading mobile and full-stack software development projects.',
                'highlights' => [
                    'Graduated in Computer Science and Engineering under APJ Abdul Kalam Technological University (KTU).',
                    'Spearheaded the GoWayanad Emergency Ride Booking final group project (Flutter + Firebase).',
                    'Strong academic and practical focus on clean software architecture and database design.',
                ],
                'display_order' => 1,
            ]
        );

        // 6. Experience / Internships & Practical Work
        $experiences = [
            [
                'company' => 'Full Stack & Mobile Development Projects',
                'position' => 'Full Stack Software Developer',
                'location' => 'Thrissur, Kerala, India',
                'start_date' => '2023',
                'end_date' => 'Present',
                'is_current' => true,
                'description' => 'Architecting and implementing full-stack web platforms and cross-platform mobile apps. Developing secure Laravel REST APIs with role-based access control, Eloquent relationships, and transaction safety. Building reactive Flutter apps with Riverpod 3.x and Clean Architecture.',
                'technologies' => ['Flutter', 'Dart', 'Laravel', 'PHP', 'MySQL', 'Riverpod', 'RESTful APIs', 'Git'],
                'achievements' => [
                    'Built enterprise-grade Smart Resource Booking system featuring transaction logic and multi-tier RBAC.',
                    'Engineered cross-platform mobile applications with custom canvas rendering and clean feature-based architecture.',
                    'Implemented automated leave management workflows with approval routing and balance deduction logic.',
                ],
                'display_order' => 1,
            ],
            [
                'company' => 'Government Engineering College, Wayanad',
                'position' => 'Software Engineering Lead & Developer (Academic Projects)',
                'location' => 'Wayanad, Kerala, India',
                'start_date' => '2022',
                'end_date' => '2024',
                'is_current' => false,
                'description' => 'Designed database schemas, Data Flow Diagrams (DFDs), and architectural specifications for software projects. Implemented OTP authentication, real-time geolocation tracking, and cloud data persistence.',
                'technologies' => ['Flutter', 'Firebase', 'PHP', 'MySQL', 'System Architecture', 'Git'],
                'achievements' => [
                    'Authored end-to-end system architecture specifications and database diagrams.',
                    'Collaborated with multi-disciplinary teams in agile sprint cycles.',
                ],
                'display_order' => 2,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['company' => $exp['company'], 'position' => $exp['position']],
                $exp
            );
        }

        // 7. Projects (10 Comprehensive Real Resume Projects)
        $projects = [
            [
                'title' => 'Smart Resource Booking & Allocation System',
                'slug' => 'smart-resource-booking-system',
                'category' => 'Full Stack',
                'short_description' => 'Enterprise-style resource booking system for managing meeting rooms, vehicles, projectors, and shared corporate assets with conflict prevention.',
                'full_description' => 'An end-to-end organizational resource management platform engineered with Laravel and MySQL. Provides automated conflict detection, resource availability schedules, booking lifecycle workflows, and automated maintenance downtime tracking. Built with strict role-based access control allowing distinct capabilities for Employees, Resource Managers, and System Administrators.',
                'problem_statement' => 'Organizations frequently experience scheduling overlaps, double bookings, and lack of visibility into shared hardware and facility availability, leading to operational friction.',
                'features' => [
                    'Multi-tier Role-Based Access Control (Employees, Resource Managers, Administrators)',
                    'Transactional booking logic preventing double bookings and schedule conflicts',
                    'Resource availability tracking, approval workflows, and status tracking',
                    'Maintenance scheduling and downtime management',
                    'Dynamic pagination, query filtering, and Eloquent relationship optimization',
                ],
                'technologies' => ['Laravel', 'PHP', 'Blade', 'Eloquent ORM', 'MySQL', 'JavaScript', 'CSS3'],
                'highlights' => ['Role-Based Access Control', 'Transaction Integrity', 'Conflict Prevention Logic'],
                'image_url' => '/images/projects/smart-resource-booking.svg',
                'github_url' => 'https://github.com/19Malavika/smart_resource_booking',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'title' => 'Employee Leave Management System',
                'slug' => 'employee-leave-management-system',
                'category' => 'Full Stack',
                'short_description' => 'Web-based leave application and approval workflow system featuring multi-level managerial authorization and leave balance accounting.',
                'full_description' => 'A robust Laravel enterprise web application for streamlined leave requests, approvals, balance deductions, and audit trails. Features isolated roles for Employees and Managers with customizable leave types (casual, medical, paid). Built with Laravel MVC, custom middleware, form requests, and secure database relationships.',
                'problem_statement' => 'Manual paper or spreadsheet-based leave tracking is error-prone, lacks visibility for department managers, and complicates balance calculations.',
                'features' => [
                    'Employee leave application with date validation and document attachment',
                    'Manager approval/rejection workflows with explanatory notes',
                    'Real-time automated leave balance deduction and accumulation tracking',
                    'Comprehensive leave history logs and downloadable summary',
                    'Robust validation, CSRF protection, and custom middleware authorization',
                ],
                'technologies' => ['Laravel', 'PHP', 'Blade', 'Eloquent ORM', 'MySQL', 'JavaScript'],
                'highlights' => ['Approval Routing', 'Leave Balance Accounting', 'Custom Middleware'],
                'image_url' => '/images/projects/leave-management.svg',
                'github_url' => 'https://github.com/19Malavika/employee-leave-management-system.git',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'title' => 'Riverpod Flutter Shopping App',
                'slug' => 'riverpod-flutter-shopping-app',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Cross-platform reactive e-commerce application built with Flutter, Material 3, and Riverpod 3.x following Clean Architecture principles.',
                'full_description' => 'A performant mobile shopping experience built on Flutter and Dart, utilizing the newest Riverpod 3.x state management providers. Features a dynamic catalog rendered via GridView.builder, reactive cart state, price range filtering, and clean separation between data models, state providers, and UI screens.',
                'problem_statement' => 'State synchronization across complex e-commerce screens often causes unnecessary widget rebuilds, UI sluggishness, and brittle codebase architectures.',
                'features' => [
                    'Reactive state management using Riverpod StateNotifier and derived providers',
                    'Dynamic product catalog with optimized lazy rendering using GridView.builder',
                    'Real-time product filtering by price, category, and availability',
                    'Reactive cart management with instant badge updates and item quantity mutations',
                    'Strict Clean Architecture separation: Data, Domain, and Presentation layers',
                ],
                'technologies' => ['Flutter', 'Dart', 'Riverpod 3.x', 'Material 3', 'Clean Architecture'],
                'highlights' => ['Riverpod 3.x State Management', 'Clean Architecture', 'Material 3 Design'],
                'image_url' => '/images/projects/riverpod-shopping.svg',
                'github_url' => 'https://github.com/19Malavika/riverpod-flutter.git',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 3,
            ],
            [
                'title' => 'FlexTenure – BNPL & EMI Financing Application',
                'slug' => 'flextenure-bnpl-emi-financing',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Fintech mobile UI application for Buy Now Pay Later (BNPL) and flexible EMI financing supporting Buyer and Merchant user roles.',
                'full_description' => 'A modern financial technology interface designed for frictionless micro-credit access and installment repayments. Engineered with multi-role UI architectures distinguishing between consumer buyers and merchant dashboards. Includes credit limit scorecards, active loan installment timelines, EMI calculators, payment scheduling, and notification centers.',
                'problem_statement' => 'Financial apps often overwhelm users with complex interest schedules, confusing repayment terms, and clunky merchant verification.',
                'features' => [
                    'Dedicated persona interfaces for Buyers and Merchants',
                    'Credit score dashboard displaying available limit and utilization gauge',
                    'Interactive EMI installment schedule calculator with amortization breakdown',
                    'Loan repayment tracking with upcoming due date notifications',
                    'Reusable component library following modern fintech UI/UX guidelines',
                ],
                'technologies' => ['Flutter', 'Dart', 'Material UI', 'State Management', 'Figma'],
                'highlights' => ['Fintech UI/UX', 'Dual-Role Interfaces', 'EMI Calculations'],
                'image_url' => '/images/projects/flextenure.svg',
                'github_url' => 'https://github.com/19Malavika/flextenure-app-simple-UI.git',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 4,
            ],
            [
                'title' => 'GoWayanad – Emergency Ride Booking Application',
                'slug' => 'gowayanad-emergency-ride-booking',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Android-based emergency transport and ride booking app with OTP verification, live GPS tracking, and dynamic fare calculation.',
                'full_description' => 'Developed for remote and hilly regions of Wayanad, Kerala, this application connects citizens needing urgent transport with verified local drivers. Backed by Firebase realtime cloud infrastructure, it features phone OTP authentication, driver dispatched alerts, live geolocation coordinates, and transparent fare estimation.',
                'problem_statement' => 'In hilly and semi-rural regions, emergency medical or urgent transport is difficult to summon quickly without standardized dispatch mechanisms.',
                'features' => [
                    'Two-sided ecosystem supporting Passenger and Driver interfaces',
                    'Secure Firebase phone number OTP authentication',
                    'Live GPS coordinates tracking and route display',
                    'Automated distance and terrain-based dynamic fare calculation',
                    'Complete system documentation with DFD Level 0/1/2 diagrams and schema definitions',
                ],
                'technologies' => ['Flutter', 'Dart', 'Firebase Realtime Database', 'Firebase Auth', 'GPS Geolocation'],
                'highlights' => ['Realtime Geolocation', 'Firebase Integration', 'Emergency Dispatch'],
                'image_url' => '/images/projects/gowayanad.svg',
                'github_url' => 'https://github.com/Athmana/MiniProject-group-19.git',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 5,
            ],
            [
                'title' => 'Netflix Clone Application',
                'slug' => 'netflix-clone-app',
                'category' => 'Frontend',
                'short_description' => 'Responsive web streaming front-end integrating TMDB API with dynamic hero banners, trending carousels, and video trailer popups.',
                'full_description' => 'A dynamic video-on-demand web client built using React, Axios, and CSS3. Connects to The Movie Database (TMDB) REST API to dynamically fetch top rated movies, trending releases, action, comedy, and documentaries. Features infinite horizontal sliders, YouTube trailer integrations, and smooth hover animations.',
                'problem_statement' => 'Building responsive media streaming interfaces requires efficient asynchronous API orchestration and layout handling across device screen sizes.',
                'features' => [
                    'Dynamic API data fetching using Axios and TMDB REST endpoints',
                    'Hero section with dynamic background image rotation and description truncation',
                    'Horizontal scrollable movie rows categorized by genres',
                    'Interactive hover states and responsive media queries',
                ],
                'technologies' => ['React.js', 'JavaScript (ES6+)', 'Axios', 'TMDB REST API', 'CSS3 Flexbox/Grid'],
                'highlights' => ['REST API Integration', 'Responsive Media Rows', 'Async State Handling'],
                'image_url' => '/images/projects/netflix-clone.svg',
                'github_url' => 'https://github.com/19Malavika/NETFLIX.git',
                'live_url' => null,
                'is_featured' => true,
                'display_order' => 6,
            ],
            [
                'title' => 'Mastery Map – Interactive Skill Galaxy',
                'slug' => 'mastery-map-interactive-galaxy',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Interactive visual skill progression galaxy built with Flutter CustomPainter, custom mathematical coordinate rendering, and gesture controls.',
                'full_description' => 'An innovative visual learning journey application using low-level Flutter 2D Canvas and CustomPainter. Renders interconnected skill nodes in a celestial galaxy topology with zooming, panning, interactive node inspections, and animated node completion states.',
                'problem_statement' => 'Conventional checklist or tabular skill roadmaps are uninspiring and do not visually represent prerequisite dependencies between concepts.',
                'features' => [
                    'Direct 2D hardware-accelerated canvas rendering via Flutter CustomPainter',
                    'Smooth gestures handling (pan, pinch-to-zoom, node hit-testing)',
                    'Dynamic dependency lines calculating shortest vector paths between skills',
                    'Feature-based modular architecture for seamless code extensibility',
                ],
                'technologies' => ['Flutter', 'Dart', 'CustomPainter', 'Canvas API', 'Feature-Based Architecture'],
                'highlights' => ['Custom Canvas Rendering', 'Gesture Hit-Testing', 'Feature-Based Modularity'],
                'image_url' => '/images/projects/mastery-map.svg',
                'github_url' => 'https://github.com/19Malavika/mastery-map.git',
                'live_url' => null,
                'is_featured' => false,
                'display_order' => 7,
            ],
            [
                'title' => 'Flextenure Modern Dark Login UI',
                'slug' => 'flextenure-dark-login-ui',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Sleek, responsive dark-themed mobile authentication interface featuring glassmorphic effects, gradient buttons, and input validation.',
                'full_description' => 'A pixel-perfect, modern mobile authentication experience crafted for fintech applications. Implements dark-mode aesthetics, custom text field decorations, animated transitions between sign-in and sign-up states, social authentication hooks, and password visibility toggles.',
                'problem_statement' => 'First impressions matter greatly for fintech apps; poor login UX directly drives user onboarding drop-off.',
                'features' => [
                    'Custom styled text form fields with inline validation and icons',
                    'Smooth animated toggle between sign-in, registration, and password recovery',
                    'Modern dark aesthetic with cyan/purple gradient accents',
                    'Social login button components (Google, Apple, biometric prompts)',
                ],
                'technologies' => ['Flutter', 'Dart', 'UI/UX Design', 'Custom Widgets'],
                'highlights' => ['Dark Mode Aesthetics', 'Input Validation', 'Micro-Interactions'],
                'image_url' => '/images/projects/flutter-login.svg',
                'github_url' => 'https://github.com/19Malavika/Flextenure-login-UI.git',
                'live_url' => null,
                'is_featured' => false,
                'display_order' => 8,
            ],
            [
                'title' => 'Digital Invoice Generator',
                'slug' => 'digital-invoice-generator',
                'category' => 'Frontend',
                'short_description' => 'Interactive business invoice generation web tool featuring dynamic line items, tax computations, discount calculations, and printable exports.',
                'full_description' => 'A productivity web application built in React allowing freelancers and small businesses to generate professional invoices rapidly. Supports customizable line items, subtotal math, GST/VAT percentage logic, currency selection, and clean print/PDF export styling.',
                'problem_statement' => 'Creating invoices with manual spreadsheets frequently leads to calculation discrepancies and unprofessional formatting.',
                'features' => [
                    'Dynamic line-item additions, deletions, and real-time total recalculations',
                    'Configurable tax rates, shipping, discounts, and payment notes',
                    'Clean invoice preview with print-optimized CSS layout',
                    'Client and vendor business profile state persistence',
                ],
                'technologies' => ['React.js', 'JavaScript', 'CSS3', 'Print Stylesheet'],
                'highlights' => ['Dynamic Calculations', 'Print Stylesheet', 'Modular Components'],
                'image_url' => '/images/projects/invoice-generator.svg',
                'github_url' => 'https://github.com/19Malavika/invoice.git',
                'live_url' => null,
                'is_featured' => false,
                'display_order' => 9,
            ],
            [
                'title' => 'Draggable Scrollable Sheet Demo',
                'slug' => 'draggable-scrollable-sheet-demo',
                'category' => 'Mobile (Flutter)',
                'short_description' => 'Interactive Flutter mobile application demonstrating physics-based draggable bottom sheet mechanics and nested scroll physics.',
                'full_description' => 'A specialized Flutter architectural demo showcasing DraggableScrollableSheet implementation with multiple snap points, nested list view scrolling, backdrop blurring, and smooth gestures handling akin to Apple Maps and Google Maps sheet interactions.',
                'problem_statement' => 'Implementing smooth draggable bottom sheets with nested scroll physics without gesture conflicts is a common mobile challenge.',
                'features' => [
                    'Multiple snap positions (collapsed 15%, half-expanded 50%, full 90%)',
                    'Nested scroll controller coordination without gesture conflict',
                    'Backdrop filter blur with opacity interpolation',
                ],
                'technologies' => ['Flutter', 'Dart', 'Gestures & Animations', 'Custom Widgets'],
                'highlights' => ['Gestures Physics', 'Nested Scroll Coordination', 'Snap Points'],
                'image_url' => '/images/projects/draggable-sheet.svg',
                'github_url' => 'https://github.com/19Malavika/Draggable-scrollable-sheet.git',
                'live_url' => null,
                'is_featured' => false,
                'display_order' => 10,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(
                ['slug' => $proj['slug']],
                $proj
            );
        }

        // 8. Certifications
        $certifications = [
            [
                'title' => 'Flutter & Dart - The Complete Guide (Clean Architecture & Riverpod)',
                'issuer' => 'Mobile Engineering Certification',
                'issue_date' => '2024',
                'credential_id' => 'FL-RIV-2024-984',
                'credential_url' => 'https://github.com/19Malavika',
                'description' => 'Mastery in cross-platform mobile app development, state management with Riverpod, custom animations, and backend API integration.',
                'display_order' => 1,
            ],
            [
                'title' => 'Full Stack Web Development with Laravel & PHP',
                'issuer' => 'Web Development Standards',
                'issue_date' => '2024',
                'credential_id' => 'LAR-PHP-2024-412',
                'credential_url' => 'https://github.com/19Malavika',
                'description' => 'In-depth specialization in REST API design, MVC architecture, Eloquent ORM, authentication & RBAC, migrations, and database transactions.',
                'display_order' => 2,
            ],
            [
                'title' => 'Modern React & JavaScript ES6+ Frontend Engineering',
                'issuer' => 'Frontend Specialization Course',
                'issue_date' => '2023',
                'credential_id' => 'REACT-JS-2023-771',
                'credential_url' => 'https://github.com/19Malavika',
                'description' => 'Component lifecycle, asynchronous state handling with Axios, responsive design, and SPA workflows.',
                'display_order' => 3,
            ]
        ];

        foreach ($certifications as $cert) {
            Certification::updateOrCreate(
                ['title' => $cert['title'], 'issuer' => $cert['issuer']],
                $cert
            );
        }
    }
}
