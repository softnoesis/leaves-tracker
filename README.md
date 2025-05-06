# Leave Tracker (CodeIgniter 3)

Leave Tracker is a web-based leave management system built with **CodeIgniter 3 (CI3)**. It supports role-based access for Admins, HRs, and Members to manage leave requests, approvals, holidays, policies, and user profiles in an efficient and user-friendly way.



---

## 🚀 Features

### 👤 Member:
- **Dashboard** – View status of your:
  - Pending Leaves
  - Approved Leaves
  - Rejected Leaves
- **My Profile** – Update your profile details.
- **My Leaves** – See all your applied leaves.
- **Leave Calendar** – Visualize your leaves, birthdays, holidays, and other member leaves.
- **Request Leave** – Apply for new leaves.
- **Holidays** – View public holiday list.

### 🧑‍💼 HR:
- **Dashboard** – View and manage leave requests.
- **Approve/Reject** leave requests.
- **Add Holidays**
- **Define Leave Policies**
- **Create Leave Types**
- **Create Members**, assign **Roles** and **Designations**

### 🛡️ Admin:
- All HR functionalities, plus:
- **Create/Update Members**
- Approve/Reject any leave requests.
- Assign unique color codes for each member (helps distinguish in calendar).

---

## 🧰 Tech Stack

- **Backend**: PHP (CodeIgniter 3)
- **Database**: MySQL
- **Frontend**: HTML, CSS, Bootstrap, jQuery
- **Mailer**: SMTP Email Config

---

## 🛠️ Installation Instructions

### 1. Clone or Download

```bash
git clone https://github.com/yourusername/leave-tracker.git
```

### 2. Set Base URL 

- Edit the file: application/config/config.php
```bash
$config['base_url'] = 'http://localhost/leave-tracker/'; // or your domain URL
```
### 3. Database Setup

- Create a new MySQL database named: leaves
- Import the SQL file from the DB/ folder into your database.

### 4. Configure Database

- Edit the file: application/config/database.php
```bash
'hostname' => 'localhost',
'username' => 'your_username',
'password' => 'your_password',
'database' => 'leaves',
```

### 5. Configure Mail Settings

- Edit the file: application/config/custom.php
```bash
$config['email_from']         = 'your_email@example.com';
$config['email_password']     = 'your_email_password';
$config['email_host']         = 'your hosst name';
$config['port']               = '587'; // or 465
$config['email_smtp_secure']  = 'tls'; // or ssl
```
