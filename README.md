# Task Management API (Laravel)

A simple Task Manager API built using Laravel, following the senior developer practical test requirements.  
This project covers task CRUD operations, filtering, sorting, business rules, custom builder pattern, form requests, and automated tests.

---

## 📌 Tech Stack

- **PHP**: 8.2+
- **Laravel**: 12.0
- **Database**: MySQL / MariaDB
- **Testing**: PHPUnit
- **Frontend**: (To be added — Vue / React / Livewire / Blade+JS)

---

## 📁 Project Structure Highlights

- `TaskRequest` → Single combined request class for both POST & PUT validations.
- `TaskBuilder` → Handles all filtering and sorting logic cleanly.
- `TaskResource` → Defines consistent API output.
- `TaskController` → Thin controller using model methods.
- `DateService` → Utility for adding working days (weekend-skipper).
- `tests/Feature` → Feature tests for invalid task input.
- `tests/Unit` → Unit test for weekend skipper function.

---

## 🚀 Setup Instructions

### 1️⃣ Clone the project
```bash
git clone <your-repo-url>
cd task-management

2️⃣ Install dependencies
composer install

3️⃣ Environment setup
cp .env.example .env
Update your .env with database credentials:

Generate app key:
php artisan key:generate

4️⃣ Migrate database
php artisan migrate

▶ API Usage
/api/tasks

📌 1. Get All Tasks (Filters + Sorting)

GET /api/tasks
Query params:

status=TODO | IN_PROGRESS | DONE
priority=LOW | MEDIUM | HIGH
search=keyword
sort_by=due_date | created_at
sort_dir=asc | desc
limit=10 | 25 | all


📌 2. Create Task
POST /api/tasks
{
  "title": "Demo task",
  "description": "Some text",
  "status": "TODO",
  "priority": "HIGH",
  "due_date": "2025-12-07"
}

📌 3. Update Task
PUT /api/tasks/{id}
Includes business rule validation for allowed status transitions.

📌 4. Get Single Task
GET /api/tasks/{id}

📌 5. Delete Task
DELETE /api/tasks/{id}
Uses soft deletes.

🧠 Business Rules Implemented
Title min length: 3 characters
Due date cannot be in the past
If priority = HIGH, due date must be within 7 days
Status transitions:
TODO → IN_PROGRESS → DONE
DONE → ❌ cannot move to any other status
Default status = TODO for POST

🧪 Running Tests
Run all tests:
php artisan test

You will see:
PASS Tests\Unit\DateServiceTest
PASS Tests\Feature\TaskTest

🛠 Custom Builder (Filters & Sorting)

The project uses a TaskBuilder to handle:
status filter
priority filter
search filter
sorting (created_at / due_date)
pagination wrapper
This makes the controller extremely clean.

🧰 Weekend Skipping Utility
File: app/Services/DateService.php
Adds working days while skipping Saturday/Sunday.

Tests\Unit\DateServiceTest

💡 Improvements If Time Permitted

Add soft-delete recovery endpoint
Add sorting by priority
Add tag support for tasks
Add authentication
Add role-based access (Admin vs User)

📄 License

Open-source for interview use.


---

# 🎉 Your README.md is complete.

It includes everything required by the assignment:

✔ Versions  
✔ Setup steps  
✔ API usage  
✔ Tests  
✔ Explanation of features  
✔ Business rules  
✔ Future improvements  
