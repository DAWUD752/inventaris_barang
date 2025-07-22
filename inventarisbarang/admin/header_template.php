<?php
    session_start() ;
    if(!isset($_SESSION['uid'])){
        header('location:../login.php');
        exit(); // Penting untuk menghentikan eksekusi setelah redirect
    }

    include '../database.php' ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Inventaris Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        *{
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f1f0;
        }

        /* navbar */
        a {
            color: inherit;
            text-decoration: none;
        }

        .navbar {
            padding: 0.5rem 1rem;
            background-color: #67595e;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 99;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }

        .navbar h1 {
            margin-left: 15px;
            font-size: 20px;
            line-height: 19px;
        }

        /* sidebar */
        .sidebar {
            position: fixed;
            width: 250px;
            top: 0;
            bottom: 0;
            background-color: rgb(255, 255, 255);
            padding-top: 50px;
            transition: transform .3s ease-in-out;
            transform: translateX(-100%); /* Sembunyikan sidebar ke kiri */
            z-index: 98;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-show {
            transform: translateX(0); /* Tampilkan sidebar */
        }

        .sidebar-body {
            padding: 15px;
        }

        .sidebar-body h2 {
            margin-bottom: 8px;
        }

        .sidebar-body ul {
            list-style: none;
        }

        .sidebar-body ul li a {
            width: 100%;
            display: inline-block;
            padding: 7px 15px;
            box-sizing: border-box;
        }

        .sidebar-body ul li a:hover {
            background-color: #67595e;
            color: white;
        }

        .sidebar-body ul li:not(:last-child) {
            border-bottom: 1px solid #ccc;
        }

        /* content */
        .content {
            padding: 60px 0; /* Sesuaikan padding-top dengan tinggi navbar */
            margin-left: 0; /* Tidak ada margin kiri yang berubah */
            transition: none;
            width: 100%;
            box-sizing: border-box;
        }

        .container {
            max-width: 1200px; /* Lebarkan sedikit max-width container */
            margin-left: auto;
            margin-right: auto;
            padding: 0 30px; /* Tambah padding kiri kanan untuk memberi ruang dari tepi layar, namun tetap terlihat "center" */
            box-sizing: border-box;
        }
        
        /* Tambahan untuk responsif */
        @media (max-width: 1200px) { /* Sesuaikan breakpoint jika perlu */
            .container {
                max-width: 960px; /* Kembali ke ukuran lebih kecil untuk layar menengah */
            }
        }
        @media (max-width: 992px) {
            .container {
                width: 100%;
                padding: 0 15px; /* Kurangi padding untuk layar lebih kecil */
            }
        }


        /* admin beranda & card umum */
        .page-tittle {
            margin-bottom: 10px;
            margin-left: 0; /* Hapus margin-left 5px agar lebih ke kiri */
            color: #67595e; /* Warna judul */
        }

        /* Untuk Card pada halaman Beranda (index.php) */
        .card {
            background-color: white;
            padding: 20px; /* Tambah padding agar lebih lapang */
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Pertahankan shadow untuk card beranda */
            margin-top: 20px;
        }

        .card h2 {
            margin-bottom: 3px;
        }

        .card p {
            color: gray;
        }

        /* Table Styling (untuk halaman barang.php) */
        /* Hapus styling .card khusus untuk tabel di barang.php,
        kita akan styling tabelnya langsung */
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Beri jarak di atas tabel */
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Beri bayangan langsung ke tabel */
            border-radius: 10px;
            overflow: hidden; /* Penting untuk border-radius pada tabel */
        }

        .table thead th {
            background-color: #67595e;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #52474b;
        }

        .table tbody td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e0e0e0;
        }

        /* Buttons */
        .btn {
            padding: 5px 10px;
            display: inline-block;
            background-color: #67595e;
            color: white;
            border-radius: 3px;
            text-decoration: none;
            font-size: 0.9em;
            margin-right: 5px;
        }

        .btn-add {
            background-color: #4CAF50; /* Green */
            margin-bottom: 15px;
            display: inline-block; /* Pastikan ini adalah inline-block agar margin-right berfungsi */
        }

        .btn-edit {
            background-color: #2196F3; /* Blue */
        }

        .btn-delete {
            background-color: #f44336; /* Red */
        }
        
        .btn-detail {
            background-color: #ff9800; /* Orange */
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-submit {
            border: 1px solid #67595e;
            padding: 8px 20px;
            display: inline-block;
            background-color: #67595e;
            color: white;
            border-radius: 3px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-back {
            border: 1px solid #ccc;
            padding: 8px 20px;
            display: inline-block;
            border-radius: 3px;
            font-size: 1rem;
            cursor: pointer;
            background-color: #f2f2f2;
            text-decoration: none;
            color: #333;
        }

        /* Form Styling */
        .form-card {
            border: 1px solid #ccc;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .input-grup {
            margin-bottom: 15px;
        }

        .input-grup label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-control {
            width: calc(100% - 16px);
            box-sizing: border-box;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-control:focus {
            outline: none;
            border-color: #67595e;
            box-shadow: 0 0 5px rgba(103, 89, 94, 0.5);
        }

        select.input-control {
            height: 38px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" id="btnBars">
            <i class="fa fa-bars"></i>
        </a>
        <h1>Si Admin Inventaris Barang</h1>
    </div>

    <div class="sidebar sidebar-hide">
        <div class="sidebar-body">
            <h2>Navigasi</h2>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="barang.php">Inventaris Barang</a></li>
                <li><a href="../logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="content" id="mainContent">
        <div class="container">