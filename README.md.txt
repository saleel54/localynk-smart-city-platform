# 🚀 Localynk — Smart City Service Platform

> Hackathon Winning Project 🏆
> Connecting citizens with nearby verified service professionals in real-time.

---

## 🌍 Overview

**Localynk** is a smart hyperlocal service platform that helps users instantly find and contact nearby verified professionals like electricians, plumbers, and technicians — powered by real-time GPS filtering and availability tracking.

Built to solve:

* ❌ Difficulty finding trusted local workers
* ❌ No visibility into worker availability
* ❌ Emergency service delays
* ❌ Lack of structured service discovery in small cities

---

## ✨ Key Features

### 👤 User Side

* 🔍 Service-based discovery
* 📍 GPS-based nearby filtering (Haversine formula)
* 🚨 Emergency Mode
* 📞 One-click call logging
* 🟢 Live availability badges (Available / Busy / Not Available)

### 🧑‍🔧 Worker Panel

* 📲 OTP-based login (No password system)
* 🔄 Update availability status
* 🚨 Emergency availability toggle
* 📊 Call count analytics
* 📍 GPS refresh location
* 🖼 Profile picture upload

### 🛠 Admin Dashboard

* 📈 Real-time analytics
* 📊 Worker approval system
* 📞 Call tracking (Normal & Emergency)
* 🏆 Most contacted worker insights
* 🔎 Smart search + pagination
* 📦 Service demand analytics

---

## 🧠 Tech Stack

| Layer           | Technology                    |
| --------------- | ----------------------------- |
| Frontend        | HTML5, CSS3, Bootstrap 5      |
| Backend         | PHP (Core PHP, no frameworks) |
| Database        | MySQL                         |
| Authentication  | OTP-based login               |
| Location        | HTML5 Geolocation API         |
| Hosting         | InfinityFree (MySQL Hosted)   |
| Version Control | Git + GitHub                  |

---

## 🏗 Architecture

* Structured folder architecture
* Clean separation of:

  * Admin
  * Worker
  * Public user interface
* Secure database handling
* Role-based session management
* Call logging system

---

## 🚀 How To Run Locally

1. Install XAMPP
2. Clone repository:

   ```bash
   git clone https://github.com/YOUR_USERNAME/localynk-smart-city-platform.git
   ```
3. Import database into phpMyAdmin
4. Configure:

   ```
   config/db.php
   ```
5. Start Apache & MySQL
6. Open:

   ```
   http://localhost/smarttaluk
   ```

---

## 🔐 Environment Setup

Make sure to configure your own database credentials in:

```
config/db.php
```

---

## 📊 Future Roadmap

* 💳 Integrated payments
* 📱 PWA support
* 🧠 AI-based smart worker ranking
* 📍 Live tracking map view
* ⭐ Ratings & reviews system
* 📈 Revenue dashboard for workers
* ☁ Cloud hosting & scaling

---

## 🏆 Hackathon Achievement

This project was built during a competitive hackathon where:

* Judges loved the UI/UX
* Appreciated the real-world usability
* Praised the structured architecture
* Selected it as a winning solution

---

## 👨‍💻 Built With Passion By

**Saleel T**

> “Building systems that solve real-world problems at scale.”

