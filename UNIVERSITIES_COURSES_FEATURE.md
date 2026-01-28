# Multiple Universities and Courses Feature

## Overview
Enhanced the CRM student management system to support multiple universities with multiple courses per university, replacing the single university/course fields.

## Database Changes

### New Table: `student_universities`
- `id` - Primary key
- `student_id` - Foreign key to students table
- `university_name` - Name of the university
- `course_name` - Name of the course
- `created_at`, `updated_at` - Timestamps

### Migration
- Created migration: `2026_01_28_062409_create_student_universities_table.php`
- Establishes relationship between students and their university/course combinations

## Model Changes

### StudentUniversity Model
- New model: `app/Models/StudentUniversity.php`
- Belongs to Student model
- Fillable fields: student_id, university_name, course_name

### Student Model Updates
- Added `universities()` relationship method
- Returns hasMany relationship to StudentUniversity model

## Controller Updates

### StudentController Changes
- **Store Method**: Added logic to save multiple university/course combinations
- **Update Method**: Added logic to update university/course combinations (deletes existing and recreates)
- Handles form data arrays: `universities[]` and `courses[index][]`

## View Updates

### Create Form (`resources/views/admin/students/create.blade.php`)
- Replaced single university/course fields with dynamic section
- Added "Universities & Courses" section with:
  - Add University button
  - Remove University button (hidden for first item)
  - Add Course button (+)
  - Remove Course button (-)
- JavaScript functionality for dynamic form management

### Edit Form (`resources/views/admin/students/edit.blade.php`)
- Similar dynamic section as create form
- Pre-populates existing university/course data
- Groups courses by university name for display

### Show/View Page (`resources/views/admin/students/show.blade.php`)
- Replaced single university/course display
- Shows universities as cards with course badges
- Groups courses by university name
- Clean, organized display

## JavaScript Features

### Dynamic Form Management
- **Add University**: Creates new university section with course field
- **Remove University**: Removes university section, updates labels
- **Add Course**: Adds course field to specific university
- **Remove Course**: Removes course field, ensures at least one remains
- **Auto-indexing**: Maintains proper array indexing for form submission

### User Experience
- Smooth transitions and hover effects
- Proper button visibility management
- Form validation (required fields)
- Clean, intuitive interface

## CSS Styling
- Added hover effects for university items
- Consistent button sizing and alignment
- Responsive design maintained
- Clean, professional appearance

## Form Data Structure

### Submission Format
```
universities[] = ["University 1", "University 2"]
courses[0][] = ["Course 1A", "Course 1B"]
courses[1][] = ["Course 2A"]
```

### Processing Logic
- Loops through universities array
- For each university, loops through corresponding courses array
- Creates StudentUniversity record for each university/course combination

## Features

### Create Student
- Start with one university/course pair
- Add unlimited universities
- Add unlimited courses per university
- Remove universities (except first)
- Remove courses (maintains at least one per university)

### Edit Student
- Loads existing university/course data
- Groups by university name
- Maintains same dynamic functionality as create
- Updates existing data (delete and recreate approach)

### View Student
- Clean display of all universities and courses
- Universities shown as cards
- Courses displayed as badges
- Grouped and organized presentation

## Benefits
1. **Flexibility**: Students can apply to multiple universities with different courses
2. **Organization**: Clear grouping of courses by university
3. **User-Friendly**: Intuitive add/remove functionality
4. **Scalable**: No limit on number of universities or courses
5. **Clean UI**: Professional, organized interface
6. **Data Integrity**: Proper relationships and validation

## Usage Instructions
1. **Adding Universities**: Click "Add University" button
2. **Adding Courses**: Click "+" button next to course field
3. **Removing Items**: Click "Remove" or "-" buttons
4. **Form Validation**: University and course names are required
5. **Editing**: Existing data loads automatically, can be modified
6. **Viewing**: All universities and courses displayed in organized format

This implementation provides a comprehensive solution for managing multiple university and course selections per student while maintaining a clean, user-friendly interface.