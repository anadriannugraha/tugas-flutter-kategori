// API Base URL (sesuaikan dengan port server PHP Anda)
const API_URL = 'http://localhost:8000';

// Format Rupiah
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

// Load Data Produk
async function loadProduk(searchQuery = '') {
    const tbody = document.querySelector('#produkTable tbody');
    try {
        const queryParam = searchQuery ? `?search=${encodeURIComponent(searchQuery)}` : '';
        const response = await fetch(`${API_URL}/produk${queryParam}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const res = await response.json();
        const data = res.data || res;

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data barang.</td></tr>`;
            return;
        }

        data.forEach((item, index) => {
            const tr = document.createElement('tr');
            const stokColor = item.stok <= 0 ? 'var(--danger)' : (item.stok <= 5 ? '#f59e0b' : 'var(--success)');
            
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td style="font-family: monospace; color: var(--primary);">${item.kode_barang || '-'}</td>
                <td style="font-weight: 500;">${item.nama_produk}</td>
                <td><span style="background: rgba(99,102,241,0.2); color: var(--primary); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">${item.nama_kategori || 'Kategori ' + item.kategori_id}</span></td>
                <td>${formatRupiah(item.harga)}</td>
                <td style="font-weight: bold; color: ${stokColor};">${item.stok}</td>
                <td style="color: var(--text-muted); font-size: 0.9rem;">${item.deskripsi || '-'}</td>
                <td style="text-align: right;">
                    <div class="actions" style="justify-content: flex-end;">
                        <button class="btn-icon edit" onclick="editProduk(${item.id})" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn-icon delete" onclick="deleteProduk(${item.id})" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error("Error fetching produk:", error);
        tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--danger); padding: 20px;"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat data dari server. Pastikan server PHP berjalan (php -S localhost:8000).</td></tr>`;
    }
}

// Modal Handling
const modal = document.getElementById('productModal');
const productForm = document.getElementById('productForm');
let isEditMode = false;

function openModal(mode, id = null) {
    isEditMode = (mode === 'edit');
    document.getElementById('modalTitle').innerText = isEditMode ? 'Edit Barang' : 'Tambah Barang Baru';
    
    if (mode === 'add') {
        productForm.reset();
        document.getElementById('productId').value = '';
        document.getElementById('kategori_id').value = '1';
    }
    
    modal.classList.add('active');
}

function closeModal() {
    modal.classList.remove('active');
}

// Tambah / Update Produk
productForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const id = document.getElementById('productId').value;
    const btnSave = document.getElementById('saveBtn');
    
    const payload = {
        kode_barang: document.getElementById('kode_barang').value,
        nama_produk: document.getElementById('nama_produk').value,
        harga: document.getElementById('harga').value,
        stok: document.getElementById('stok').value,
        kategori_id: document.getElementById('kategori_id').value,
        deskripsi: document.getElementById('deskripsi').value
    };

    const method = isEditMode ? 'PUT' : 'POST';
    const url = isEditMode ? `${API_URL}/produk/${id}` : `${API_URL}/produk`;

    btnSave.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
    btnSave.disabled = true;

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) throw new Error('Gagal menyimpan data');
        
        closeModal();
        loadProduk();

    } catch (error) {
        alert(error.message);
    } finally {
        btnSave.innerHTML = 'Simpan';
        btnSave.disabled = false;
    }
});

// GET 1 Data untuk Edit
async function editProduk(id) {
    try {
        const response = await fetch(`${API_URL}/produk/${id}`);
        if (!response.ok) throw new Error('Gagal mengambil data barang');
        
        const res = await response.json();
        const data = res.data || res;
        
        document.getElementById('productId').value = data.id;
        document.getElementById('kode_barang').value = data.kode_barang || '';
        document.getElementById('nama_produk').value = data.nama_produk;
        document.getElementById('harga').value = data.harga;
        document.getElementById('stok').value = data.stok || 0;
        document.getElementById('kategori_id').value = data.kategori_id;
        document.getElementById('deskripsi').value = data.deskripsi;
        
        openModal('edit', id);
    } catch (error) {
        alert(error.message);
    }
}

// Hapus Produk
async function deleteProduk(id) {
    if (confirm("Apakah Anda yakin ingin menghapus barang ini?")) {
        try {
            const response = await fetch(`${API_URL}/produk/${id}`, {
                method: 'DELETE'
            });

            if (!response.ok) throw new Error('Gagal menghapus data');
            
            loadProduk();
        } catch (error) {
            alert(error.message);
        }
    }
}

// Inisialisasi saat halaman load
document.addEventListener('DOMContentLoaded', () => {
    loadProduk();
    
    // Setup Search feature
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadProduk(e.target.value);
            }, 300);
        });
    }
});
