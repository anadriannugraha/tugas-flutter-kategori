import 'package:flutter/material.dart';
import '../../services/api_kategori.dart';
import '../../models/kategori.dart';
import 'add_kategori.dart';
import 'edit_kategori.dart';

class ListKategoriScreen extends StatefulWidget {
  const ListKategoriScreen({super.key});

  @override
  State<ListKategoriScreen> createState() => _ListKategoriScreenState();
}

class _ListKategoriScreenState extends State<ListKategoriScreen> {
  final ApiKategori _apiKategori = ApiKategori();

  // FUNGSI FETCH KATEGORI
  Future<List<Kategori>> _fetchData() {
    return _apiKategori.getKategori();
  }

  // FUNGSI HAPUS KATEGORI
  Future<void> _hapusData(String id) async {
    bool sukses = await _apiKategori.deleteKategori(id);
    if (sukses) {
      setState(() {});
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Kategori berhasil dihapus!')),
        );
      }
    } else {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Gagal menghapus kategori')),
        );
      }
    }
  }

  // DIALOG KONFIRMASI HAPUS
  void _tampilkanDialogHapus(String id, String nama) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          backgroundColor: const Color(0xFFFDFBF7),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
            side: const BorderSide(color: Color(0xFF2B2B2B), width: 3),
          ),
          title: const Text(
            'Hapus Kategori?',
            style: TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF2B2B2B)),
          ),
          content: Text('Yakin ingin menghapus "$nama"?'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Batal', style: TextStyle(color: Colors.grey, fontWeight: FontWeight.bold)),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.red,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                  side: const BorderSide(color: Color(0xFF2B2B2B), width: 2),
                ),
              ),
              onPressed: () {
                Navigator.pop(context);
                _hapusData(id);
              },
              child: const Text('Hapus', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFEFE8D8),
      appBar: AppBar(
        backgroundColor: const Color(0xFFFDFBF7),
        elevation: 0,
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(3.0),
          child: Container(
            color: const Color(0xFF2B2B2B),
            height: 3.0,
          ),
        ),
        title: const Text(
          'Kategori',
          style: TextStyle(
            color: Color(0xFF2B2B2B),
            fontWeight: FontWeight.bold,
            fontSize: 24,
          ),
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: FutureBuilder<List<Kategori>>(
            future: _fetchData(),
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Center(child: CircularProgressIndicator(color: Color(0xFF2B2B2B)));
              } else if (snapshot.hasError) {
                return Center(
                  child: Text(
                    'Terjadi kesalahan: ${snapshot.error}',
                    style: const TextStyle(color: Colors.red, fontWeight: FontWeight.bold),
                    textAlign: TextAlign.center,
                  ),
                );
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return const Center(child: Text('Data kategori kosong', style: TextStyle(fontWeight: FontWeight.bold)));
              }

              final listKategori = snapshot.data!.reversed.toList();

              return ListView.builder(
                itemCount: listKategori.length,
                itemBuilder: (context, index) {
                  final item = listKategori[index];

                  return Container(
                    margin: const EdgeInsets.only(bottom: 16),
                    padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
                    decoration: BoxDecoration(
                      color: const Color(0xFFF8F4E6),
                      border: Border.all(color: const Color(0xFF2B2B2B), width: 3),
                      borderRadius: BorderRadius.circular(16),
                      boxShadow: const [
                        BoxShadow(
                          color: Color(0xFF2B2B2B),
                          offset: Offset(4, 4),
                        ),
                      ],
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(
                          item.namaKategori,
                          style: const TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: Color(0xFF2B2B2B),
                          ),
                        ),
                        Row(
                          children: [
                            IconButton(
                              icon: const Icon(Icons.edit, color: Color(0xFF2B2B2B)),
                              onPressed: () async {
                                final result = await Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => EditKategoriScreen(
                                      id: item.id,
                                      namaKategoriLama: item.namaKategori,
                                    ),
                                  ),
                                );
                                if (result == true) {
                                  setState(() {});
                                }
                              },
                            ),
                            IconButton(
                              icon: const Icon(Icons.delete, color: Colors.red),
                              onPressed: () => _tampilkanDialogHapus(item.id, item.namaKategori),
                            ),
                          ],
                        ),
                      ],
                    ),
                  );
                },
              );
            },
          ),
        ),
      ),
      floatingActionButton: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(50),
          boxShadow: const [
            BoxShadow(
              color: Color(0xFF2B2B2B),
              offset: Offset(4, 4),
            ),
          ],
        ),
        child: FloatingActionButton(
          onPressed: () async {
            final result = await Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const AddKategoriScreen()),
            );
            if (result == true) {
              setState(() {});
            }
          },
          backgroundColor: const Color(0xFFFDFBF7),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(50),
            side: const BorderSide(color: Color(0xFF2B2B2B), width: 3),
          ),
          child: const Icon(Icons.add, color: Color(0xFF2B2B2B), size: 28),
        ),
      ),
    );
  }
}

