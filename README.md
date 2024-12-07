# Tasty Recipes - Recipe Sharing Platform

## Project Overview

Tasty Recipes is a web-based content management system designed for sharing, creating, and managing recipes. The platform emphasizes a robust implementation of role-based permissions and MySQL integration, ensuring a seamless and secure user experience. Built using PHP, MySQL, and Bootstrap, the project adheres to best practices in data, logic, and presentation layer development.

The system offers distinct areas for public users, registered members, and admins:
- **Public Area**: Viewable by all users, showcasing recipes and their details.
- **Members Area**: Restricted to logged-in users, allowing them to manage their own recipes and save favorites.
- **Admin Area**: Provides admins with tools to manage users, oversee recipes, and ensure smooth operation of the platform.

This project is an extension of the Midterm submission, incorporating concepts learned in the second half of the semester.

---

## Key Features

### Core Functionality
1. **Recipe Management**:
   - Create, view, edit, and delete recipes.
   - Recipes include a title, ingredients, instructions, cooking time, category, and optional image uploads.
   - Each recipe is fully accessible through organized URLs (e.g., `/recipe/index`, `/recipe/detail`, `/recipe/edit`).

2. **User Authentication**:
   - Secure user registration, login, and logout.
   - Passwords stored securely using hashing.
   - Role-based access determines user privileges (Guest, User, Admin).

3. **Personalized Cookbooks**:
   - Registered users can save and manage their favorite recipes.
   - Private cookbooks allow users to curate their favorite content for quick access.

4. **Role-Based Permissions**:
   - **Public Users**:
     - Can view the recipe index and detailed recipe pages.
   - **Registered Users**:
     - Can access personal recipes and cookbooks.
     - Can create and edit their own recipes.
   - **Admins**:
     - Full access to user and recipe management.
     - Admin tools include a "Manage Users" interface for assigning roles and moderating the platform.

### Technical Features
1. **Data Layer**:
   - Recipes and user data stored in a MySQL database with normalized schemas.
   - Use of prepared statements to protect against SQL injection.
2. **Logic Layer**:
   - Modular PHP structure separating data, business logic, and presentation layers.
   - Role-based checks enforce access permissions for all features.
3. **Presentation Layer**:
   - Bootstrap framework ensures responsive, mobile-friendly design.
   - Unified visual theme applied consistently across public, member, and admin areas.

## Collaborators
- **Brandon Anthony**
- **Nick Miller**
- **Jeffrey Perdue**

## Midterm Demo Videos

### Jeffrey Perdue
[![Watch the video](https://img.youtube.com/vi/Abe9ILIsSmk/0.jpg)](https://www.youtube.com/watch?v=Abe9ILIsSmk)

### Brandon Anthony  
[![Watch the video](https://img.youtube.com/vi/2BaMdjEnyT0/0.jpg)](https://www.youtube.com/watch?v=2BaMdjEnyT0)

### Nick Miller
[![Watch the video](https://img.youtube.com/vi/A5zFI1siTXo/0.jpg)](https://www.youtube.com/watch?v=A5zFI1siTXo)

### User Credentials
- **Email**: caporusso@user.com  
- **Password**: 123456  

### Admin Credentials
- **Email**: caporusso@admin.com  
- **Password**: makesgoodcheese 