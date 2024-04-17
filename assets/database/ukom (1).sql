-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Apr 2024 pada 19.09
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `album`
--

INSERT INTO `album` (`Id_Album`, `Nama_Album`, `Deskripsi`, `Tgl_Dibuat`, `Id_User`) VALUES
(10, 'Album Brand Grunge', 'Lagu dengan aliran grunge biasanya memiliki arti yang mendalam karena berisi tentang pengabaian, isu sosial, trauma psikologis, keinginan untuk kebebasan (liberalisme), hingga feminisme. ', '2024-04-17', 1),
(12, 'Album Band Rock', 'Musik rok[2] atau musik cadas[butuh rujukan] (Inggris: Rock music) adalah genre yang luas dari musik populer yang berasal dari rock and roll di Amerika Serikat pada akhir 1940-an dan awal 1950-an, berkembang menjadi berbagai gaya yang berbeda pada perteng', '2024-04-17', 1),
(13, 'Pemandangan', 'Foto Foto dengan pemandangan yang indah', '2024-04-17', 5),
(14, 'Pemandangan Indah banget', 'Hehehhee', '2024-04-17', 3);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `foto`
--

INSERT INTO `foto` (`Id_Foto`, `Judul_Foto`, `Deskripsi`, `Tgl_Unggah`, `Lokasi_File`, `Id_Album`, `Id_User`) VALUES
(3, 'Nirvana', 'Nirvana adalah nama sebuah grup band dari Kota Aberdeen, Washington, Amerika Serikat, kemudian akhirnya mereka mendapatkan kesuksesan di Kota Seattle, Amerika Serikat, yang terkenal dengan aliran musik grunge, atau yang dikenal juga dengan Seattle Sound.', '2024-04-17', '702972007-nirvana.jpg', 10, 1),
(5, 'PearlJam', 'Pearl Jam (dibentuk pada 1990 di Seattle, Washington, Amerika Serikat) adalah salah satu kelompok musik rock yang paling berhasil pada tahun 1990-an. Mereka adalah salah satu pelopor musik grunge, dan dianggap salah satu dari empat besar bersama dengan Alice in Chains, Nirvana, dan Soundgarden.', '2024-04-17', '1459208485-PearlJam.jpg', 10, 1),
(6, 'Alice In Chains', 'Alice In Chains adalah kelompok musik rock berpengaruh yang dibentuk pada akhir tahun 1980-an di Seattle, Washington. Bersama dengan Nirvana, Pearl Jam, dan Soundgarden, Alice In Chains adalah salah satu band paling berhasil dari era grunge.', '2024-04-17', 'AliceInChains.jpg', 10, 1),
(8, 'Soundgarden', 'Soundgarden adalah kelompok musik rock Amerika yang dibentuk di Seattle, Washington pada tahun 1984 oleh penyanyi dan pemain gitar Chris Cornell, pemain gitar Kim Thayil, dan pemain bas Hiro Yamamoto. Matt Cameron menjadi pemain drum tetap Soundgarden pada tahun 1986, dan pemain bas Ben Shepherd menjadi pengganti tetap Hiro Yamamoto pada tahun 1990.', '2024-04-17', 'Soundgarden.jpg', 10, 1),
(9, 'Stone Temple Pilots', 'Stone Temple Pilots atau yang biasa disingkat dengan nama STP adalah salah satu dari sekian banyak band rock legendaris Amerika. Band ini sebenarnya berasal dari San Diego, California. STP didirikan tahun 1986 dan sempat mengalami masa vakum selama 5 tahun dari tahun 2003 hingga tahun 2008.', '2024-04-17', 'StoneTemplePilots.jpg', 10, 1),
(10, 'The Beatles', 'The Beatles adalah kelompok pemusik Inggris beraliran rock, dibentuk di Liverpool pada tahun 1960, sering kali dianggap sebagai pemusik tersukses secara komersial dan paling banyak mendapat pujian dalam musik populer.', '2024-04-17', 'TheBeatles.jpg', 12, 1),
(11, 'The Rolling Stones', 'The Rolling Stones adalah sebuah sebuah band rock Inggris yang dibentuk di London pada tahun 1962.[1] Aktif selama lebih dari tujuh dekade, mereka adalah salah satu band paling populer dan bertahan lama di era rock.', '2024-04-17', 'TheRollingStones.jpg', 12, 1),
(12, 'Gun\'SnRoses', 'Guns N\' Roses (GNR) adalah kelompok Band musik hard rock dari Amerika Serikat yang berdiri pada tahun 1984 dan diresmikan pada Maret 1985.', '2024-04-17', 'GunsNRoses.jpg', 12, 1),
(13, 'PinkFloyd', 'Pink Floyd adalah band psychedelic rock dan Progressive rock pada tahun 1964 asal Inggris yang terkenal karena komposisi lagu-lagunya yang bergaya bombastis, lirik lagunya yang berbau filosofis, sampul-sampul albumnya yang indah dan konser-konsernya yang megah. Pink Floyd adalah salah satu kelompok musik rock yang paling sukses secara komersial, pada saat ini berada di peringkat ketujuh dalam jumlah album terjual di seluruh dunia. Mereka dibentuk pada 1965 dan terakhir merekam album studio pada tahun 2014.', '2024-04-17', 'PinkFloyd.jpg', 12, 1),
(14, 'Pemandangan Malam', 'Pemandangan pada malam hari..', '2024-04-17', 'aron-visuals-LSFuPFE9vKE-unsplash.jpg', 13, 5),
(15, 'Pemandangan Gunung', 'Pemandanagan Gunung yang indah ...', '2024-04-17', 'patrick-schrodter-X2c-eOO4Evo-unsplash.jpg', 13, 5),
(16, 'Pemandangan Jendela', 'Pemandangan indah dari balik jendela', '2024-04-17', 'jacob-morch-TMNyU2MFTGw-unsplash.jpg', 13, 5),
(17, 'Pemandangan Goa', 'Pemandangan Dari goa yang sangat sangat indah', '2024-04-17', 'luca-bravo-1RqXSxGfb0M-unsplash.jpg', 13, 5),
(18, 'Bol Ayam', 'Nandut', '2024-04-17', 'bokep-endut.jpeg', 14, 3);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`Id_Komen`, `Id_Foto`, `Id_User`, `Isi_Komen`, `Tgl_Komen`) VALUES
(18, 3, 1, 'tes', '2024-04-17'),
(19, 10, 1, 'Keren', '2024-04-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `like`
--

CREATE TABLE `like` (
  `Id_Like` int(11) NOT NULL,
  `Id_Foto` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL,
  `Tgl_Like` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`Id_User`, `Username`, `Password`, `Email`, `Nama_User`, `Alamat`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'rizkibinyola25@gmail.com', 'Rizki Binyola', 'Jalanin aja dulu'),
(2, 'rizki', 'caf1a3dfb505ffed0d024130f58c5cfa', 'rizkiramadanbinyola@gmail.com', 'Rizki', '-'),
(3, 'iki', '81dc9bdb52d04dc20036dbd8313ed055', 'iki@gmail.com', 'Iki aja ', 'ahak'),
(4, 'tes', '28b662d883b6d76fd96e4ddc5e9ba780', 'tes@gmail.com', 'tes', 'tes'),
(5, 'mothy', '202cb962ac59075b964b07152d234b70', 'ultinolan@gmail.com', 'Thimoty Ronald', 'jalan nolan1');

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
  MODIFY `Id_Album` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `foto`
--
ALTER TABLE `foto`
  MODIFY `Id_Foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `Id_Komen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `like`
--
ALTER TABLE `like`
  MODIFY `Id_Like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
