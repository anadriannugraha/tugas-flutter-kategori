class Kategori {
  final String id;
  final String namaKategori;

  Kategori({
    required this.id,
    required this.namaKategori,
  });

  factory Kategori.fromJson(Map<String, dynamic> json) {
    return Kategori(
      id: json['id']?.toString() ?? '',
      namaKategori: json['nama_kategori'] ?? '',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'nama_kategori': namaKategori,
    };
  }
}
