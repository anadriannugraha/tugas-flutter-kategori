import 'package:flutter/material.dart';

class ProfileScreen extends StatelessWidget {
  final VoidCallback onLogout;

  const ProfileScreen({super.key, required this.onLogout});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFEFE8D8),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              const Text(
                'Profil Saya',
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF2B2B2B),
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 32),
              Container(
                padding: const EdgeInsets.all(24.0),
                decoration: BoxDecoration(
                  color: const Color(0xFFFDFBF7),
                  border: Border.all(color: const Color(0xFF2B2B2B), width: 3),
                  borderRadius: BorderRadius.circular(16),
                  boxShadow: const [
                    BoxShadow(
                      color: Color(0xFF2B2B2B),
                      offset: Offset(4, 4),
                    ),
                  ],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Selamat Datang,',
                      style: TextStyle(
                        fontSize: 16,
                        color: Color(0xFF2B2B2B),
                      ),
                    ),
                    const SizedBox(height: 8),
                    const Text(
                      '15230869@bsi.ac.id',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF2B2B2B),
                      ),
                    ),
                    const Divider(color: Color(0xFF2B2B2B), thickness: 2, height: 32),
                    const Text(
                      'Role: Administrator',
                      style: TextStyle(
                        fontSize: 16,
                        color: Color(0xFF2B2B2B),
                      ),
                    ),
                  ],
                ),
              ),
              const Spacer(),
              ElevatedButton(
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFFF8F4E6),
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                    side: const BorderSide(color: Color(0xFF2B2B2B), width: 2),
                  ),
                ),
                onPressed: onLogout,
                child: const Text(
                  'LOGOUT DARI AKUN',
                  style: TextStyle(
                    color: Color(0xFFE25E5E),
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
