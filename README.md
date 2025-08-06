1 – Core CRM Features:
Contacts CRUD (Create, Read, Update, Delete) with proper database schema.
Standard Fields: Name, Email, Phone, Gender, Profile Image, Additional File.

Custom Fields Management:
Admins can dynamically add user-defined fields (e.g., Birthday, Address, Company Name).
Custom fields stored via flexible schema (e.g., JSON or separate table).

AJAX Integration:
Insert, update, and delete contacts without page refresh.
Show success/error feedback dynamically.

Filtering & Search:
AJAX-based search by Name, Email, and Gender.


--------------------------------------------------------------------------------------
2 - Contact Merge Feature:
Merge Two Contacts via UI with master contact selection.

Custom Merge Logic:
Retains master data.
Adds missing values from secondary contact (emails, phones, custom fields).
Merges conflicting values based on defined rules.

Data Integrity:
No data loss — secondary record is preserved (e.g., marked as merged/inactive).
UI highlights merged/overwritten fields.

Extensible Architecture:
Supports future custom fields or modules through scalable design.