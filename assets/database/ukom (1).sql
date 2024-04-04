-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Apr 2024 pada 17.43
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukom`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `album`
--

CREATE TABLE `album` (
  `Id_Album` int(11) NOT NULL,
  `Nama_Album` varchar(255) NOT NULL,
  `Deskripsi` varchar(255) NOT NULL,
  `Tgl_Dibuat` date NOT NULL,
  `Id_User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `album`
--

INSERT INTO `album` (`Id_Album`, `Nama_Album`, `Deskripsi`, `Tgl_Dibuat`, `Id_User`) VALUES
(1, 'Album Bokep Jepang', 'Album Bokep Jepang HOT BRUTAL SADISS MANTAPP DAH POKOKNYA !', '2024-04-03', 1),
(2, 'Album Bokep Cina', 'MATA SIPIT MEMEK PUN SIPIT HEHE :)\r\n', '2024-04-03', 1),
(3, 'Bokep Amoyy', 'Bokep Malay Sejuk Senak Enak\r\n', '2024-04-03', 1),
(4, 'Koleksi Gundam', 'GundamKU\r\n', '2024-04-03', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto`
--

CREATE TABLE `foto` (
  `Id_Foto` int(11) NOT NULL,
  `Judul_Foto` varchar(255) NOT NULL,
  `Deskripsi` text NOT NULL,
  `Tgl_Unggah` date NOT NULL,
  `Lokasi_File` varchar(255) NOT NULL,
  `Id_Album` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `foto`
--

INSERT INTO `foto` (`Id_Foto`, `Judul_Foto`, `Deskripsi`, `Tgl_Unggah`, `Lokasi_File`, `Id_Album`, `Id_User`) VALUES
(1, 'Sugiono', 'Kakek Kakek', '2024-04-03', 'hehehe.jpg', 1, 1),
(2, 'Cindo', 'Cindo Sipit Mantap', '2024-04-03', 'cindo.jpg', 2, 1),
(3, 'Amoy', 'Amoy Gemoy', '2024-04-03', 'amoyyy.jpg', 3, 1),
(4, 'Gundam TL', 'GUNDAM KEREN', '2024-04-03', 'gundam-tl.jpg', 4, 2),
(5, 'Gundam rx', 'Gundam keren banget', '2024-04-03', 'gundam-rx.jpg', 4, 2),
(6, 'Gundam kntl', 'GUNDAMMMMM!', '2024-04-03', 'gundam-kn.jpg', 4, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `Id_Komen` int(11) NOT NULL,
  `Id_Foto` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL,
  `Isi_Komen` text NOT NULL,
  `Tgl_Komen` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `like`
--

CREATE TABLE `like` (
  `Id_Like` int(11) NOT NULL,
  `Id_Foto` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL,
  `Tgl_Like` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `like`
--

INSERT INTO `like` (`Id_Like`, `Id_Foto`, `Id_User`, `Tgl_Like`) VALUES
(1, 3, 1, '2024-04-03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `Id_User` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Nama_User` varchar(255) NOT NULL,
  `Alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`Id_User`, `Username`, `Password`, `Email`, `Nama_User`, `Alamat`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'rizkibinyola25@gmail.com', 'Rizki Binyola', 'Jalanin aja dulu'),
(2, 'rizki', 'caf1a3dfb505ffed0d024130f58c5cfa', 'rizkiramadanbinyola@gmail.com', 'Rizki', '-');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`Id_Album`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indeks untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`Id_Foto`),
  ADD KEY `Id_User` (`Id_User`),
  ADD KEY `Id_Album` (`Id_Album`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`Id_Komen`),
  ADD KEY `Id_Foto` (`Id_Foto`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indeks untuk tabel `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`Id_Like`),
  ADD KEY `Id_Foto` (`Id_Foto`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `album`
--
ALTER TABLE `album`
  MODIFY `Id_Album` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `foto`
--
ALTER TABLE `foto`
  MODIFY `Id_Foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `Id_Komen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `like`
--
ALTER TABLE `like`
  MODIFY `Id_Like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`);

--
-- Ketidakleluasaan untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`),
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`Id_Album`) REFERENCES `album` (`Id_Album`);

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`Id_Foto`) REFERENCES `foto` (`Id_Foto`),
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`);

--
-- Ketidakleluasaan untuk tabel `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`Id_Foto`) REFERENCES `foto` (`Id_Foto`),
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
