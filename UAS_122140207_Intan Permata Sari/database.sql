CREATE DATABASE db_mahasiswa;
USE db_mahasiswa;

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_nim VARCHAR(20) NOT NULL,
    mahasiswa_nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Pria', 'Wanita') NOT NULL,
    mahasiswa_prodi VARCHAR(50) NOT NULL,
    minat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

