class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    // Elsewhere in your code

    //bottom navigation bar
    HttpOverrides.global = MyHttpOverrides();
  }

}
