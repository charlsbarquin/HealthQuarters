# HealthQuarters

HealthQuarters is a patient-facing healthcare web application for clinic discovery, service browsing, home service booking, corporate healthcare inquiries, patient profile management, appointment tracking, and notification updates.

It is built as a PHP + MySQL/MariaDB project intended to run in a local XAMPP environment. The application currently follows a flat-route structure at the project root, while shared logic is extracted into reusable `includes/`, `services/`, `config/`, `partials/`, and `data/` folders.

## Suggested GitHub Repository Name

`healthquarters-patient-portal`

## Suggested GitHub Repository Description

Patient-facing healthcare portal for HealthQuarters built with PHP, MySQL, Bootstrap, and PHPMailer, featuring service discovery, home service booking, corporate inquiries, patient dashboards, notifications, and PDF appointment confirmations.

## About The System

HealthQuarters is designed to support the patient and public-facing side of a diagnostic and healthcare service platform. The current system focuses on:

- Public marketing and clinic information pages
- Patient registration and login
- Home service appointment booking
- Corporate service inquiry submission
- Patient dashboard and profile management
- Appointment tracking and recent activity
- In-app notification inbox
- Downloadable PDF booking confirmation
- Testimonial submission

The project has already been streamlined to remove the old admin module and now centers on the patient experience and public service flows.

## Core Features

### Public-facing features

- Landing page with service discovery and clinic highlights
- Unified public navigation and footer
- Service catalog with categorized healthcare offerings
- Branch and location pages
- About page with clinic background and organization content
- Dedicated information pages for home service and corporate service

### Patient features

- Account registration and login
- Forgot password flow with OTP/email support
- Patient dashboard
- Profile editing and profile completion tracking
- Notification inbox with unread counts and filters
- Appointment list, recent activity, and next-step guidance
- Home service booking form
- View appointment details
- Download appointment confirmation as PDF

### Organization and inquiry features

- Corporate service inquiry form
- Corporate package overview page
- Corporate inquiry tracking inside the patient account

## Current User Flow

1. A visitor lands on `lp.php`.
2. The user can browse services, locations, home service information, and corporate packages.
3. The user signs up or logs in.
4. The user can submit a home service appointment in `booking.php`.
5. The system stores the request, creates notifications, and allows the patient to download a confirmation PDF.
6. The patient can track appointments, profile details, notifications, and corporate inquiries through `homepage.php` and `profile.php`.

## Tech Stack

### Backend

- PHP 8.x
- PDO for database access
- Session-based authentication
- CSRF protection helpers
- Runtime schema checks for compatibility
- Custom server-side PDF generation for booking confirmations
- PHPMailer for email delivery

### Frontend

- HTML5
- CSS3
- JavaScript
- Bootstrap 5.3
- Responsive layouts using CSS Grid and Flexbox
- Shared public navigation and footer components

### Database

- MySQL / MariaDB
- SQL dump provided through `healthquarters.sql`

### Local environment

- XAMPP
- Apache
- MySQL / MariaDB
- Composer

## Main Modules

### 1. Public website module

Handles discovery and informational pages:

- `lp.php`
- `service.php`
- `locations.php`
- `about_us.php`
- `home_service_info.php`
- `corporate_info.php`

### 2. Authentication module

Handles patient access and session flows:

- `login.php`
- `signup.php`
- `forgot_password.php`
- `logout.php`
- `includes/login/request.php`
- `includes/signup/bootstrap.php`
- `includes/security.php`
- `includes/auth.php`

### 3. Patient portal module

Handles the logged-in patient experience:

- `homepage.php`
- `profile.php`
- `patient_appointment.php`
- `view_appointment.php`
- `includes/homepage/bootstrap.php`
- `includes/profile/bootstrap.php`
- `includes/view_appointment/bootstrap.php`
- `services/patient_portal_service.php`

### 4. Booking and appointment module

Handles home service appointment creation and appointment confirmation:

- `booking.php`
- `confirm_booking.php`
- `includes/booking/request.php`
- `includes/confirm_booking/bootstrap.php`
- `check_slots.php`
- `get_booked_times.php`
- `get_patient_info.php`
- `download_booking_confirmation.php`

### 5. Corporate inquiry module

Handles company and organizational healthcare inquiries:

- `corporateservice.php`
- `submit_corporate.php`
- `corporate_info.php`

### 6. Notification module

Handles patient notifications and inbox updates:

- `notifications_api.php`
- `get_notif_count.php`
- `services/notification_service.php`

### 7. Messaging and email module

Handles outgoing mail functionality:

- `mailer.php`
- `services/mail_service.php`
- `config/mail.php`

## Project Structure

```text
HealthQuarters/
|-- about_us.php
|-- booking.php
|-- check_slots.php
|-- confirm_booking.php
|-- corporate_info.php
|-- corporateservice.php
|-- db.php
|-- download_booking_confirmation.php
|-- forgot_password.php
|-- get_booked_times.php
|-- get_notif_count.php
|-- get_patient_info.php
|-- healthquarters.sql
|-- homepage.php
|-- home_service_info.php
|-- locations.php
|-- login.php
|-- logout.php
|-- lp.php
|-- mailer.php
|-- notifications_api.php
|-- patient_appointment.php
|-- profile.php
|-- README.md
|-- service.php
|-- signup.php
|-- submit_corporate.php
|-- submit_testimonial.php
|-- view_appointment.php
|-- composer.json
|-- config/
|   |-- app.php
|   |-- database.php
|   `-- mail.php
|-- data/
|   `-- about_us_content.php
|-- image/
|-- includes/
|   |-- auth.php
|   |-- bootstrap.php
|   |-- config.php
|   |-- helpers.php
|   |-- public_footer.php
|   |-- public_nav.php
|   |-- runtime_schema.php
|   |-- security.php
|   |-- booking/
|   |   `-- request.php
|   |-- confirm_booking/
|   |   `-- bootstrap.php
|   |-- homepage/
|   |   `-- bootstrap.php
|   |-- login/
|   |   `-- request.php
|   |-- profile/
|   |   `-- bootstrap.php
|   |-- signup/
|   |   `-- bootstrap.php
|   `-- view_appointment/
|       `-- bootstrap.php
|-- partials/
|   |-- auth_assets.php
|   |-- auth_logo.php
|   `-- bootstrap_bundle_532.php
|-- services/
|   |-- mail_service.php
|   |-- notification_service.php
|   `-- patient_portal_service.php
`-- vendor/
```

## Important Route Files

### Public routes

- `lp.php` - main landing page
- `service.php` - service catalog and categorized offerings
- `locations.php` - branch details and access information
- `about_us.php` - profile, mission, milestones, and contact content
- `home_service_info.php` - home service overview
- `corporate_info.php` - corporate healthcare overview

### Authentication routes

- `login.php`
- `signup.php`
- `forgot_password.php`
- `logout.php`

### Protected patient routes

- `homepage.php`
- `profile.php`
- `booking.php`
- `patient_appointment.php`
- `view_appointment.php`

### Supporting endpoints

- `notifications_api.php`
- `check_slots.php`
- `get_booked_times.php`
- `get_patient_info.php`
- `submit_corporate.php`
- `submit_testimonial.php`
- `download_booking_confirmation.php`

## Backend Architecture

The backend follows a lightweight PHP include-based architecture.

### Shared bootstrap layer

`includes/bootstrap.php` loads the shared config, helpers, security utilities, and public navigation helpers used across pages.

### Security layer

`includes/security.php` currently provides:

- session timeout handling
- session fingerprint validation
- authenticated session creation
- logout session cleanup
- CSRF token generation and verification

### Service layer

Business logic is grouped in `services/`, especially:

- `services/patient_portal_service.php`
- `services/notification_service.php`
- `services/mail_service.php`

### Request/action handlers

Request-specific flows are handled in route-level files and include subfolders such as:

- `includes/booking/request.php`
- `includes/login/request.php`
- `includes/confirm_booking/bootstrap.php`

### Data source

The system relies mainly on the SQL schema in `healthquarters.sql` and optional runtime schema alignment via `includes/runtime_schema.php`.

## Frontend Architecture

The frontend currently uses page-level PHP templates with inline style blocks and shared UI helpers.

### Shared UI pieces

- `includes/public_nav.php` for the shared public navigation and mobile menu
- `includes/public_footer.php` for the shared footer
- `partials/` for auth-specific reusable fragments

### Frontend patterns in use

- Bootstrap grid system
- CSS Grid and Flexbox for custom layout
- responsive hero sections and cards
- reusable CTA/button styling
- notification count polling with JavaScript
- page-specific scripts for UI interactions

## Database Overview

Based on the current SQL dump, the main database entities include:

- `users`
- `appointments`
- `home_service_appointments`
- `corporate_inquiries`
- `reschedule_requests`
- `user_notifications`
- `testimonials`
- `email_otps`

These tables support authentication, patient data, home service requests, corporate submissions, notifications, OTP verification, and feedback collection.

## Notification System

The notification feature is handled through:

- `notifications_api.php` for unread counts, fetching notifications, and marking them as read
- `services/notification_service.php` for notification metadata, persistence, and optional email delivery

This powers the inbox and unread badge behavior in `homepage.php`, `profile.php`, and selected public-facing logged-in navigation elements.

## PDF Confirmation System

`download_booking_confirmation.php` generates a downloadable PDF for patient bookings without a third-party PDF library. It uses custom low-level PDF text and drawing helpers to render:

- reference number
- appointment details
- patient information
- contact information
- address
- notes and preparation details

## Email System

Outgoing email functionality is powered by:

- `phpmailer/phpmailer`
- `services/mail_service.php`
- `config/mail.php`
- `mailer.php`

The app currently supports email-related flows such as notifications and password recovery support.

## Dependencies

From `composer.json`, the current Composer dependency is:

- `phpmailer/phpmailer:^7.0`

Other platform requirements:

- PHP with PDO MySQL support
- Apache
- MySQL or MariaDB
- Composer

## Installation and Local Setup

1. Place the project in `c:\xampp\htdocs\HealthQuarters`.
2. Start Apache and MySQL in XAMPP.
3. Create a database named `healthquarters`.
4. Import `healthquarters.sql`.
5. Run `composer install` in the project root.
6. Confirm database settings in `config/database.php`.
7. Review mail settings in `config/mail.php`.
8. Open `http://localhost/HealthQuarters/lp.php`.

## Recommended Development Environment

- XAMPP on Windows
- PHP 8.2 or compatible PHP 8.x build
- MariaDB 10.4+ or MySQL equivalent
- phpMyAdmin for local database import and inspection
- VS Code or Cursor for development

## Configuration Files

### `config/database.php`

Stores database connection settings for:

- host
- username
- password
- database name
- charset

### `config/mail.php`

Stores mail transport profiles used by different email flows.

## Security Notes

The codebase already includes session protection and CSRF utilities, but this repository should still be treated carefully in development and before public deployment.

Recommended improvements before production deployment:

- move mail credentials into environment variables
- rotate any exposed mail passwords
- move sensitive config outside version control
- strengthen server-side validation across all forms
- review rate limiting for login, OTP, and notification endpoints
- review authorization checks on all protected routes

## Authors / Maintainers

The current repository does not define a formal author list in code metadata.

You can update this section with your actual names, for example:

- `Your Name` - Project Lead / Full-stack Developer
- `Teammate Name` - Frontend Developer / UI Designer
- `Teammate Name` - Backend Developer / Database Developer
- `Adviser / Instructor Name` - Project Adviser

If you want, this section can be rewritten later in thesis, capstone, or portfolio format.

## Current Scope Notes

- The project currently uses root-level PHP entry files instead of an MVC router.
- Shared logic has been partially modularized into `includes/` and `services/`.
- The old admin subsystem has been removed from the active application flow.
- The system is now centered on patient-facing and public-facing functionality.

## Suggested Future Improvements

- extract repeated page styles into shared CSS files
- move secrets to environment variables
- introduce a cleaner routing structure or MVC pattern
- add automated tests for critical booking and authentication flows
- improve API consistency for AJAX endpoints
- normalize database field naming across modules
- add deployment documentation for staging and production

## Summary

HealthQuarters is a patient-centered diagnostic and healthcare portal built with PHP, MySQL, Bootstrap, JavaScript, and PHPMailer. It combines public service discovery, patient booking, profile management, corporate inquiry handling, notifications, and PDF appointment confirmation in a single XAMPP-friendly codebase.
