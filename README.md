# 🏥 HealthCenter: Patient Registration System

<!-- ![License](https://img.shields.io/github/license/sasmitadn/health-center?style=flat-square&color=blue) -->
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-4.x-F2C100?style=flat-square&logo=livewire)
![Status](https://img.shields.io/badge/Status-Active-success?style=flat-square)

> **Simplicity is the ultimate sophistication.**
> A lightweight, open-source patient registration system designed for primary healthcare facilities (Puskesmas/Clinics).

## 📖 About The Project

This project focuses on the most critical bottleneck in healthcare services: **Patient Intake**. 

Instead of a bloated hospital management system, this is a dedicated module for efficient data entry and queue generation. It is built to be fast, reliable, and easily deployable.

**Key Objective:** Replace manual paper-based registration with a structured digital database.

## ✨ Key Features

* **Streamlined Patient Management:** Fast CRUD operations for patient data (ID/NIK, Insurance, Basic Info).
* **Medical Record Initialization:** Create and track basic medical history folders per patient.
* **Smart Queuing:** Automatic queue number generation based on the selected polyclinic.
* **Responsive Admin Panel:** Built with FilamentPHP for a premium mobile and desktop experience.

## 🛠️ Tech Stack

* **Framework:** [Laravel 11](https://laravel.com)
* **Admin Panel:** [FilamentPHP](https://filamentphp.com)
* **Database:** MySQL
* **Styling:** Tailwind CSS

## 🚀 Getting Started

Follow these steps to set up the project locally:

### Prerequisites
* PHP 8.2+
* Composer
* Node.js & NPM

### Installation

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/sasmitadn/health-center.git](https://github.com/sasmitadn/health-center.git)
    cd health-center
    ```

2.  **Install dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Setup**
    Update your `.env` file with your DB credentials, then run:
    ```bash
    php artisan migrate --seed
    ```
    *(The seeder will create a default admin user and dummy patient data)*

5.  **Run the server**
    ```bash
    php artisan serve
    ```

## 🗺️ Roadmap

This is currently an **MVP (Minimum Viable Product)**. Future updates may include:
- [ ] Doctor Dashboard
- [ ] Pharmacy/Prescription Module
- [ ] BPJS (National Insurance) Bridging
- [ ] Visit Reports & Analytics

## 🤝 Contribution

Contributions are what make the open-source community such an amazing place. Any contributions you make are **greatly appreciated**.

1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<div align="center">
  <p>Crafted with ☕ and clean code by <b><a href="https://sasmitadn.com">Sasmitadn</a></b></p>
  <p>
    <a href="https://github.com/sasmitadn">GitHub</a> • 
    <a href="https://sasmitadn.com">Website</a>
  </p>
</div>
