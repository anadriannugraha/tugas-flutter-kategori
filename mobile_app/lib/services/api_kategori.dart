import 'package:http/http.dart' as http;
import 'dart:convert';
import 'api_config.dart';
import '../models/kategori.dart';

class ApiKategori {
  // 1. GET LIST KATEGORI
  Future<List<Kategori>> getKategori() async {
    final url = Uri.parse('${ApiConfig.baseUrl}/kategori');
    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = json.decode(response.body);
        final List<dynamic> data = responseData['data'] ?? [];
        return data.map((item) => Kategori.fromJson(item)).toList();
      } else {
        throw 'Gagal mengambil data kategori (Status: ${response.statusCode})';
      }
    } catch (e) {
      if (e.toString().contains('ClientException') ||
          e.toString().contains('Failed to fetch')) {
        throw 'Tidak ada koneksi internet!';
      }
      throw 'Terjadi kesalahan Kategori: $e';
    }
  }

  // 2. ADD / POST KATEGORI
  Future<bool> postKategori(String namaKategori) async {
    final url = Uri.parse('${ApiConfig.baseUrl}/kategori');
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'nama_kategori': namaKategori}),
      );
      return response.statusCode == 200 || response.statusCode == 201;
    } catch (e) {
      throw 'Gagal menambah kategori karena masalah koneksi jaringan.';
    }
  }

  // 3. EDIT / PUT KATEGORI
  Future<bool> putKategori(String id, String namaKategori) async {
    final url = Uri.parse('${ApiConfig.baseUrl}/kategori/$id');
    try {
      final response = await http.put(
        url,
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'nama_kategori': namaKategori}),
      );
      return response.statusCode == 200;
    } catch (e) {
      throw 'Gagal mengubah kategori karena masalah koneksi jaringan.';
    }
  }

  // 4. DELETE KATEGORI
  Future<bool> deleteKategori(String id) async {
    final url = Uri.parse('${ApiConfig.baseUrl}/kategori/$id');
    try {
      final response = await http.delete(url);
      return response.statusCode == 200;
    } catch (e) {
      throw 'Gagal menghapus kategori karena masalah koneksi jaringan.';
    }
  }
}
