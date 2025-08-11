# AT-Hackathon-Invoicer

A simple invoicing and payment tool for Small & Medium Enterprises (SMEs) in Africa, built for the Africa's Talking Open Hackathon.

## The Problem

SMEs struggle with manual invoicing, tracking payments, and managing cash flow. This tool automates the entire process, helping businesses get paid faster.

## Core Features

- **Client Management:** Add and manage business clients.
- **Invoice Creation:** Easily create detailed invoices with line items.
- **SMS Notifications:** Send invoices and payment links directly to clients via **Africa's Talking SMS API**.
- **Mobile Payments:** Clients can pay instantly using **Africa's Talking Payments API (STK Push)**.
- **Automated Status Updates:** Payment webhooks automatically update invoice statuses from "Sent" to "Paid".
- **USSD Balance Check:** Clients without internet can check their outstanding balance using a USSD code.
- **Automated Reminders:** A scheduled task automatically sends SMS reminders for overdue invoices.

## Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Blade & Tailwind CSS
- **Database:** MySQL / SQLite
- **Key APIs:** Africa's Talking (SMS, Payments, USSD)

## How to Set Up

1. Clone the repository: `git clone ...`
2. Install dependencies: `composer install && npm install`
3. Create your `.env` file from `.env.example` and add your database and Africa's Talking credentials.
4. Generate an app key: `php artisan key:generate`
5. Run migrations and seed the database: `php artisan migrate:fresh --seed`
6. Start the server: `php artisan serve`

---
