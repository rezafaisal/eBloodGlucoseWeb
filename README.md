# Web Application for Child Blood Glucose Monitoring

This web application is designed to support the monitoring of children’s blood glucose levels by two main types of users: **parents** and **healthcare professionals** such as **doctors** and **nurses**. The system provides a centralized platform for viewing, managing, and monitoring blood glucose data collected from wearable and mobile technologies.

The main purpose of this web application is to make blood glucose monitoring more accessible, structured, and continuous. By integrating data from a smartwatch, a mobile application, and a web-based dashboard, the system allows blood glucose information to be observed remotely through a browser-based interface.

## Target Users

The web application serves two primary user groups:

### Parents
Parents can use the system to monitor **only their own child’s blood glucose data**. This access limitation is important to ensure privacy and data security. Through the web dashboard, parents can review glucose status, view historical measurement records, and follow their child’s glucose trends over time.

### Healthcare Professionals
Healthcare professionals, including **doctors** and **nurses**, can use the system to monitor the blood glucose data of **children or individuals who are registered as their patients**. This feature allows medical staff to review patient conditions remotely, observe blood glucose trends, and support clinical follow-up or consultation activities based on recorded data.

## Data Flow and System Workflow

The workflow of the application can be described as follows:

<p align="center">
  <img src="https://raw.githubusercontent.com/rezafaisal/eBloodGlucoseMobile/main/images/mobile_app.png" alt="Mobile Application Workflow" width="750">
</p>
<p align="center">
  <img src="https://raw.githubusercontent.com/rezafaisal/eBloodGlucoseWeb/main/images/web-dashboard-diagram.png" alt="Web Application Workflow" width="750">
</p>

The data displayed in the web application originate from a **smartwatch equipped with a blood glucose sensor** worn by the child. The overall workflow of the system can be described as follows:

1. The child wears a **smartwatch with a blood glucose sensor** that captures glucose-related measurements.
2. The measurement data are first collected by the **mobile application**.
3. The mobile application then sends the data **periodically** to the **database server** through the **backend API** of this web application.
4. The backend API receives, processes, and stores the measurement data in the server database.
5. The web application retrieves the stored data and presents them through dashboard and detail pages for parents and healthcare professionals.

This architecture enables continuous monitoring because the mobile application acts as an intermediary between the smartwatch and the server. As a result, blood glucose information can be updated regularly and made available through the web interface for authorized users.

## Main Features

The web application provides several core features to support monitoring, user access control, and system administration:

- **Login**  
  Allows authorized users to securely access the system using their credentials.

- **Logout**  
  Enables users to safely end their session after using the application.

- **View Profile**  
  Allows users to view their personal account information.

- **Update Profile**  
  Enables users to edit and update their profile information.

- **View Dashboard**  
  Provides a summary view of blood glucose monitoring data in a visual and easy-to-understand format.

- **View Detail – Glucose Status**  
  Displays detailed information about the current or latest blood glucose status of a monitored child or patient.

- **View Detail – Data History**  
  Shows the historical blood glucose records so users can review previous measurements and identify trends over time.

- **Consultation**  
  Supports communication or consultation activities related to the monitored blood glucose data.

- **User Management – CRUD**  
  Allows administrators to create, read, update, and delete user accounts.

- **Role Management – CRUD**  
  Allows administrators to manage roles and permissions within the system.

- **Menu Management – CRUD**  
  Allows administrators to manage application menus and navigation settings.

## Access Control Concept

The system applies role-based access control to ensure that each user only sees data relevant to their responsibilities.

- **Parents** are limited to viewing the blood glucose data of **their own child**.
- **Healthcare professionals** can view the blood glucose data of **their assigned patients**.
- **Administrators** can manage users, roles, and menus to support system operation and maintenance.

This access control mechanism is essential for maintaining patient privacy, protecting sensitive health data, and ensuring that the system is used according to user responsibilities.

## Technology Stack

This web application is built using the following technologies:

- **PHP** for the backend  
  The backend handles business logic, API services, authentication, authorization, and communication with the database.

- **Vue** for the frontend  
  The frontend provides an interactive and responsive user interface for accessing dashboards, profile pages, history pages, and other monitoring features.

This combination of PHP and Vue allows the system to deliver a clear separation between backend processing and frontend presentation, making the application easier to maintain and extend in future development.

## Benefits of the Web Application

This web-based monitoring system offers several important benefits:

- Enables parents to monitor their child’s blood glucose data remotely
- Allows healthcare professionals to oversee multiple patients in one platform
- Supports continuous monitoring through periodic data synchronization from the mobile application
- Provides structured access to glucose status and historical records
- Improves data availability through centralized server storage
- Supports better communication and follow-up through consultation features
- Ensures secure and organized access through user, role, and menu management

## Summary

In summary, this web application is a browser-based monitoring platform for children’s blood glucose data that is used by parents and healthcare professionals. The data originate from a smartwatch with a blood glucose sensor worn by the child, are collected by the mobile application, and are then transmitted periodically to the database server through the backend API of the web system. After being stored on the server, the data are presented on web pages in the form of dashboards, glucose status details, and historical records.

Parents can monitor only their own child’s blood glucose data, while doctors and nurses can monitor the data of their registered patients. Built with **PHP** for the backend and **Vue** for the frontend, the application provides a practical and scalable solution for remote blood glucose monitoring and healthcare support.
