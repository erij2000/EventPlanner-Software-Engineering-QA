# Event Planner — Full-Stack Web Engineering & Quality Engineering

> A Laravel-based event management platform developed alongside a comprehensive **Software Quality Engineering** workflow covering automated testing, API validation, functional testing, security testing, traceability, and test reporting.

## Overview

**Event Planner** is a web application for managing events, users, categories, registrations, and administrative workflows.

The project goes beyond application development by integrating a structured **quality engineering lifecycle** covering test design, static analysis, code review, manual validation, automated testing, API integration testing, unit testing, Selenium end-to-end testing, traceability, and quality reporting.

The result is a complete engineering workflow spanning:

**Development → Testing → Automation → Validation → Traceability → Quality Reporting**

---

## Core Application

The platform provides:

* 🔐 User authentication and registration
* 👤 User profile management
* 🛡️ Role-based administrative access
* 📅 Event creation, modification, consultation, and deletion
* 🏷️ Category management
* 🎟️ Event registration
* 👥 Registration and participant management
* 🚫 Capacity and duplicate-registration validation
* 🔒 Protected routes and unauthorized-access handling
* 🗄️ Persistent relational data management

---

## Software Quality Engineering

A major part of the project focuses on validating the application across multiple testing levels.

### Static Analysis & Code Review

The project includes:

* Backend and frontend static analysis
* Code review checklists
* Identification and documentation of detected issues
* Correction tracking
* Code quality reports

### Functional Testing

Functional test cases cover:

* Authentication
* User registration
* Login and logout
* Event management
* Category management
* User profiles
* Event registration
* Administration workflows

### Security Testing

Security-oriented scenarios include:

* Unauthorized access attempts
* Protected route validation
* Role-based access control
* Authentication validation

### Non-Functional & System Testing

The QA workflow also includes:

* Non-functional test cases
* System-level test scenarios
* Capacity validation
* Application behavior verification
* Manual test execution and evidence collection

---

## Automated Testing

The project combines multiple testing technologies to validate the application at different levels.

### Unit Testing

Validation of application components and business logic using:

* PHPUnit
* Python-based test modules

### API & Integration Testing

REST/API behavior is validated through automated integration tests covering scenarios such as:

* Authentication
* Event registration
* API request/response behavior
* Integration workflows

An API collection is also included for structured API testing.

### End-to-End Testing

The application is tested through browser automation using:

* Selenium
* Python
* Pytest
* Page Object Model

Automated scenarios reproduce realistic user workflows such as authentication and event-management interactions.

---

## Quality Engineering Workflow

The project follows a layered validation strategy:

```text
                 Event Planner
                       │
          ┌────────────┴────────────┐
          │                         │
     Application                QA Process
          │                         │
   Laravel / PHP              Static Analysis
          │                    Code Review
          │                    Test Design
          │                         │
          │              ┌──────────┼──────────┐
          │              │          │          │
          │            Unit       API       E2E
          │            Tests   Integration Selenium
          │              │          │          │
          └──────────────┴──────────┴──────────┘
                       │
                 Test Execution
                       │
                 Traceability
                       │
                 Quality Reports
```

---

## Technology Stack

### Backend

* **PHP**
* **Laravel**
* **Eloquent ORM**
* **REST APIs**
* **MySQL**

### Frontend

* **Blade**
* **JavaScript**
* **Vite**
* **Tailwind CSS / frontend tooling**

### Testing & QA

* **PHPUnit**
* **Pytest**
* **Selenium**
* **API Integration Testing**
* **Static Analysis**
* **Manual Testing**
* **Functional Testing**
* **Non-Functional Testing**
* **System Testing**
* **Code Review**
* **Test Traceability**

### Development Tools

* Composer
* npm
* Git
* GitHub

---

## Architecture

The application follows Laravel's MVC-oriented architecture:

```text
                    Client
                      │
                      ▼
                  Web Routes
                      │
                      ▼
                 Controllers
                      │
             ┌────────┴────────┐
             ▼                 ▼
          Services          Validation
             │
             ▼
            Models
             │
             ▼
          Database
```

The testing ecosystem complements the application architecture:

```text
Laravel Application
        │
        ├── PHPUnit
        │
        ├── API Integration Tests
        │
        ├── Pytest
        │
        └── Selenium E2E Tests
                 │
                 ▼
          Test Evidence
                 │
                 ▼
        Traceability & Reports
```

---

## Test Coverage Areas

| Area           | Validation                               |
| -------------- | ---------------------------------------- |
| Authentication | Login, registration, logout              |
| Authorization  | Roles and protected routes               |
| Users          | Profile consultation and modification    |
| Events         | CRUD operations                          |
| Categories     | Administration and management            |
| Registrations  | Registration, capacity, duplicates       |
| APIs           | Authentication and registration flows    |
| Security       | Unauthorized access and route protection |
| UI             | Selenium end-to-end workflows            |
| Code Quality   | Static analysis and code review          |
| System         | Functional and non-functional scenarios  |
| Traceability   | Requirements → Tests → Results           |

---

## Quality Deliverables

The repository contains supporting QA artifacts including:

* Functional test specifications
* Non-functional test specifications
* System test specifications
* Manual execution reports
* Automated test reports
* Code review documentation
* Static analysis reports
* Defect/problem tracking
* Correction documentation
* API integration collections
* Selenium test scenarios
* Test traceability matrices
* Test evidence and screenshots
* Final testing report

This makes the project not only a web application, but also a **documented software quality engineering case study**.

---

## Repository Structure

```text
EventPlanner/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── tests/
│
├── EventPlanner_Test_Qualite/
│   ├── Tests_Statiques/
│   ├── Cas_de_Test/
│   ├── Tests_Automatises/
│   ├── Resultats/
│   ├── Tracabilite/
│   └── Rapport_Final/
│
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
└── README.md
```

---

## Engineering Perspective

This project demonstrates experience across several complementary areas of software engineering:

**Full-Stack Development**
→ Laravel, PHP, MVC, database-driven applications

**Backend & API Engineering**
→ REST APIs, authentication, business logic, integration testing

**Software Quality Engineering**
→ Test strategy, automated testing, static analysis, traceability

**Automation**
→ Python, Pytest, Selenium, API test automation

**Security**
→ Authentication, authorization, protected routes, access-control testing

**Engineering Methodology**
→ Code review, defect tracking, test evidence, structured reporting

These foundations are directly transferable to larger **AI, data, cloud, and distributed software systems**, where reliability, automation, API quality, security, and observability are essential.

---

## Project Status

**Completed academic software engineering and quality engineering project.**

The repository contains both the Laravel application and the associated testing/quality artifacts developed throughout the project lifecycle.

---

## Author

**Erij Kacem**

Computer Engineering Student
Software Engineering · Artificial Intelligence · Data & Cloud Systems

---

## License

This project was developed for academic and educational purposes.

The source code is shared for learning, research, and portfolio demonstration. Third-party libraries, datasets, documentation, and other external materials remain subject to their respective licenses.
