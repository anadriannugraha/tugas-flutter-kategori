import 'package:flutter/material.dart';
import '../../services/api_kategori.dart';

class AddKategoriScreen extends StatefulWidget {
  const AddKategoriScreen({super.key});

  @override
  State<AddKategoriScreen> createState() => _AddKategoriScreenState();
}

class _AddKategoriScreenState extends State<AddKategoriScreen> {
  final TextEditingController _namaController = TextEditingController();
  final ApiKategori _apiKategori = ApiKategori();
  bool _isLoading = false;

  void _simpan() async {
    if (_namaController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Nama kategori tidak boleh kosong')),
      );
      return;
    }

    setState(() {
      _isLoading = true;
    });

    bool sukses = await _apiKategori.postKategori(_namaController.text);

    setState(() {
      _isLoading = false;
    });

    if (sukses) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Kategori berhasil ditambah!')),
        );
        Navigator.pop(context, true); // Kembali dengan membawa nilai true
      }
    } else {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Gagal menambah kategori')),
        );
      }
    }
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
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Color(0xFF2B2B2B)),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text(
          'Tambah Kategori',
          style: TextStyle(
            color: Color(0xFF2B2B2B),
            fontWeight: FontWeight.bold,
          ),
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              const Text(
                'Nama Kategori Baru:',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF2B2B2B),
                ),
              ),
              const SizedBox(height: 8),
              TextField(
                controller: _namaController,
                decoration: InputDecoration(
                  hintText: 'Misal: Teknologi',
                  filled: true,
                  fillColor: Colors.white,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                    borderSide: const BorderSide(color: Color(0xFF2B2B2B), width: 2),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                    borderSide: const BorderSide(color: Color(0xFF2B2B2B), width: 2),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                    borderSide: const BorderSide(color: Color(0xFF2B2B2B), width: 3),
                  ),
                ),
              ),
              const SizedBox(height: 24),
              ElevatedButton(
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFFFDFBF7),
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                    side: const BorderSide(color: Color(0xFF2B2B2B), width: 2),
                  ),
                ),
                onPressed: _isLoading ? null : _simpan,
                child: _isLoading 
                    ? const SizedBox(height: 20, width: 20, child: CircularProgressIndicator(color: Color(0xFF2B2B2B), strokeWidth: 2))
                    : const Text(
                        'SIMPAN KATEGORI',
                        style: TextStyle(
                          color: Color(0xFF2B2B2B),
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
