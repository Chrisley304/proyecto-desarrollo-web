-- We create the database and the tables for the SIAFI website
CREATE DATABASE siafi_website;
USE siafi_website;
-- SIAFI blogs table
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    cover_image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    author_name VARCHAR(100) NOT NULL,
    author_photo VARCHAR(255) NOT NULL
);
-- SIAFI Projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);
-- SIAFI Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);
-- SIAFI Contact form entries table
CREATE TABLE contact_form_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);