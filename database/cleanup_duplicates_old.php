<?php
/**
 * Cleanup Duplicate Categories Script
 * 
 * Mencari kategori duplikat di tabel `kategori` berdasarkan `nama_kategori`,
 * memperbarui referensi di tabel `produk` ke ID terendah (asli),
 * lalu menghapus baris duplikat.
 */

header('Content-Type: application/json; charset=utf-8');

// InfinityFree Configuration (sama dengan migrate.php)
$host     = 'sql303.infinityfree.com';
$dbname   = 'if0_41961050_mydb';
$username = 'if0_41961050';
$password = 'adrian154';

$result = [
    'status'           => 'success',
    'pesan'            => '',
    'duplikat_ditemukan' => 0,
    'produk_diupdate'  => 0,
    'kategori_dihapus' => 0,
    'detail'           => []
];

try {
    $db = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // ---------------------------------------------------------------
    // 1. Cari kategori duplikat (nama_kategori yang muncul > 1 kali)
    // ---------------------------------------------------------------
    $stmtDuplicates = $db->query("
        SELECT nama_kategori, MIN(id) AS keep_id, COUNT(*) AS jumlah
        FROM kategori
        GROUP BY nama_kategori
        HAVING COUNT(*) > 1
    ");
    $duplicateGroups = $stmtDuplicates->fetchAll(PDO::FETCH_ASSOC);

    if (empty($duplicateGroups)) {
        $result['pesan'] = 'Tidak ada kategori duplikat ditemukan. Database sudah bersih.';
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result['duplikat_ditemukan'] = count($duplicateGroups);

    // ---------------------------------------------------------------
    // 2. Proses setiap grup duplikat dalam satu transaksi
    // ---------------------------------------------------------------
    $db->beginTransaction();

    $totalProdukUpdated  = 0;
    $totalKategoriDeleted = 0;

    foreach ($duplicateGroups as $group) {
        $namaKategori = $group['nama_kategori'];
        $keepId       = (int) $group['keep_id'];
        $jumlah       = (int) $group['jumlah'];

        // Ambil semua ID duplikat (kecuali yang dipertahankan)
        $stmtIds = $db->prepare("
            SELECT id FROM kategori
            WHERE nama_kategori = :nama AND id != :keep_id
            ORDER BY id ASC
        ");
        $stmtIds->execute([':nama' => $namaKategori, ':keep_id' => $keepId]);
        $duplicateIds = $stmtIds->fetchAll(PDO::FETCH_COLUMN);

        if (empty($duplicateIds)) {
            continue;
        }

        // Buat placeholder untuk IN clause
        $placeholders = implode(',', array_fill(0, count($duplicateIds), '?'));

        // 3. Update produk yang mereferensi ID duplikat → arahkan ke keepId
        $stmtUpdateProduk = $db->prepare("
            UPDATE produk SET kategori_id = ?
            WHERE kategori_id IN ({$placeholders})
        ");
        $params = array_merge([$keepId], $duplicateIds);
        $stmtUpdateProduk->execute($params);
        $produkUpdated = $stmtUpdateProduk->rowCount();

        // 4. Hapus baris kategori duplikat
        $stmtDeleteKategori = $db->prepare("
            DELETE FROM kategori WHERE id IN ({$placeholders})
        ");
        $stmtDeleteKategori->execute($duplicateIds);
        $kategoriDeleted = $stmtDeleteKategori->rowCount();

        $totalProdukUpdated  += $produkUpdated;
        $totalKategoriDeleted += $kategoriDeleted;

        $result['detail'][] = [
            'nama_kategori'    => $namaKategori,
            'id_dipertahankan' => $keepId,
            'id_dihapus'       => array_map('intval', $duplicateIds),
            'produk_dipindah'  => $produkUpdated,
            'duplikat_dihapus' => $kategoriDeleted
        ];
    }

    $db->commit();

    $result['produk_diupdate']  = $totalProdukUpdated;
    $result['kategori_dihapus'] = $totalKategoriDeleted;
    $result['pesan'] = "Pembersihan selesai: {$totalKategoriDeleted} kategori duplikat dihapus, "
                     . "{$totalProdukUpdated} produk diperbarui referensinya.";

} catch (PDOException $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    $result['status'] = 'error';
    $result['pesan']  = 'Database error: ' . $e->getMessage();
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
