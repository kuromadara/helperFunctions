Bad certificate error

https://stackoverflow.com/questions/54285172/how-to-solve-flutter-certificate-verify-failed-error-while-performing-a-post-req


// alternate
class IgnoreCertificateErrorOverrides extends HttpOverrides{
  @override
  HttpClient createHttpClient(SecurityContext context){
    return super.createHttpClient(context)
      ..badCertificateCallback = ((X509Certificate cert, String host, int port) {
      return true;
    });
  }
}


Future<void> myNonSecurityCriticalApiCall() async {
  await HttpOverrides.runWithHttpOverrides(() async {
    String url = 'https://api.example.com/non/security/critical/service';
    Response response = await get(url);

    // ... do something with the response ...
  }, IgnoreCertificateErrorOverrides());
}
