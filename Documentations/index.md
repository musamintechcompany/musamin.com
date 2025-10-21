# Musamin Project Documentation

**Author:** Augustine Osaretin Miracle Born and raised in Benin City Edo State Nigeria.
**Date of which documetation started:** August 20th 2025

---

I have long startd this project for months now, though this is not the only project i have created. I have done many others and it worked and some others failed. For this project i have done otherss which i used for testing but i deleted some of the project file because it was taking some space. This is not the first musamin project i am creating, this is basically the 3rd version, the very first version and second one wasn't published to the public because of some features that wasn't added then, but this was published because it went well.

## 📖 Introduction

Musamin is a web-based platform designed to allow users
to **buy, rent, and sell websites, apps, and other digital products**.  
It also includes features like a **referral system**, **coin-based currency**,
and **user account management**.

The goal of Musamin is to create a marketplace where developers
and entrepreneurs can connect, trade, and monetize their digital assets.

---

## ✨ Features

-   Marketplace for websites, apps, and templates
-   Renting and buying system
-   User referral system (coin-based rewards)
-   Coin wallet system (100 coins = $1)
-   Email verification & authentication
-   User dashboard with profile management
-   Dark/Light theme support
-   Settings page with logo, favicon, and appearance customization

---

## 🛠️ Technology Stack

-   **Backend:** Laravel 12
-   **Authentication/UI:** Jetstream with Livewire
-   **Admin Panel:** Filament 3
-   **Styling:** Tailwind CSS
-   **Bundler:** Vite
-   **Database:** MySQL

---

## 🚀 Future Plans

-   Public API for third-party integrations
-   Developer submission system for code/templates
-   Advanced notification system
-   Subscription and premium listings
-   Mobile-friendly PWA version

---

So far so good, i have updated my login page and register page and they use tailwind, they have their own css files and js files which is located at css/auth/ and js/auth/

I installed ramsey uuid in my project, with this command (composer require ramsey/uuid)

I installed vinkla/hashids in my project with this command (composer require vinkla/hashids), and after i talled it, i ran this command for publishing it config file (php artisan vendor:publish --provider="Vinkla\Hashids\HashidsServiceProvider")

I installed laravel reverb. I went to the laravel documentation page and then went to the broadcast part and user the broadcast command which i then choose reverb in my terminal while i ran the command. after that i also choose 'yes' for the node dependencies to be installed to and for vite to compile the files, and it was installed successfully.

✅ End of Documentation
