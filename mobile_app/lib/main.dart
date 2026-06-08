import 'package:flutter/material.dart';
import 'screens/berita/berita_screen.dart';
import 'screens/kategori/list_kategori.dart';
import 'screens/notes/notes_screen.dart';
import 'screens/login_screen.dart';
import 'screens/dashboard/view_profile.dart'; 

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Tugas Kategori',
      theme: ThemeData(
        scaffoldBackgroundColor: const Color(0xFFFDFBF7), 
        fontFamily: 'Comic Sans MS', 
      ),
      home: const MainNavigation(),
    );
  }
}

class MainNavigation extends StatefulWidget {
  const MainNavigation({super.key});

  @override
  State<MainNavigation> createState() => _MainNavigationState();
}

class _MainNavigationState extends State<MainNavigation> {
  int _currentIndex = 0;
  bool _isLoggedIn = false;

  void _updateLoginStatus(bool status) {
    setState(() {
      _isLoggedIn = status;
      if (!status) {
        _currentIndex = 0;
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final List<Widget> screens = [
      const BeritaScreen(),
      const ListKategoriScreen(),
      const NotesScreen(),
      _isLoggedIn
          ? ProfileScreen(onLogout: () => _updateLoginStatus(false))
          : LoginScreen(onLoginSuccess: () => _updateLoginStatus(true)),
    ];

    return Scaffold(
      body: screens[_currentIndex],
      bottomNavigationBar: Container(
        decoration: const BoxDecoration(
          border: Border(
            top: BorderSide(
              color: Color(0xFF2B2B2B),
              width: 3,
            ),
          ),
        ),
        child: BottomNavigationBar(
          currentIndex: _currentIndex,
          onTap: (index) {
            setState(() {
              _currentIndex = index;
            });
          },
          type: BottomNavigationBarType.fixed,
          backgroundColor: const Color(0xFFFDFBF7),
          selectedItemColor: const Color(0xFF2B2B2B),
          unselectedItemColor: Colors.grey.shade500,
          selectedLabelStyle: const TextStyle(
            fontWeight: FontWeight.bold,
            fontSize: 12,
          ),
          unselectedLabelStyle: const TextStyle(
            fontWeight: FontWeight.normal,
            fontSize: 12,
          ),
          items: [
            const BottomNavigationBarItem(
              icon: Icon(Icons.home_outlined),
              activeIcon: Icon(Icons.home),
              label: 'Berita',
            ),
            const BottomNavigationBarItem(
              icon: Icon(Icons.list_alt_outlined),
              activeIcon: Icon(Icons.list_alt),
              label: 'Kategori',
            ),
            const BottomNavigationBarItem(
              icon: Icon(Icons.book_outlined),
              activeIcon: Icon(Icons.book),
              label: 'Notes',
            ),
            BottomNavigationBarItem(
              icon: Icon(
                _isLoggedIn ? Icons.dashboard_outlined : Icons.login_outlined,
              ),
              activeIcon: Icon(_isLoggedIn ? Icons.logout : Icons.login),
              label: _isLoggedIn ? 'Logout' : 'Login',
            ),
          ],
        ),
      ),
    );
  }
}

