class ApiService {
  Future<Map<String, dynamic>> login(String email, String password) async {
    // Simulasi request login
    await Future.delayed(const Duration(seconds: 1)); // pura-pura loading

    if (email == '15230869@bsi.ac.id' && password == '21-07-2004') {
      return {'status': 'success', 'message': 'Login Berhasil'};
    } else {
      return {'status': 'error', 'message': 'Email atau Password salah!'};
    }
  }
}
