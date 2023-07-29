import 'package:http/http.dart' as http;

class RegisterService extends ChangeNotifier {
  // Existing fields and constructor...

  Future<RegisterGet> fetchRegister() async {
    var request = http.MultipartRequest(
      'POST',
      Uri.parse(dotenv.env['BASE_URL']! + dotenv.env['REGISTER_URL']!),
    );

    request.headers.addAll(header);
    request.fields.addAll(registerPost.toFormData());

    // Add the image file to the request if available
    if (registerPost.imageFile != null) {
      request.files.add(http.MultipartFile(
        'image',
        http.ByteStream(Stream.castFrom(registerPost.imageFile!.openRead())),
        await registerPost.imageFile!.length(),
        filename: registerPost.imageFile!.path.split('/').last,
      ));
    }

    final response = await request.send();

    if (response.statusCode == 200) {
      final responseData = await response.stream.bytesToString();
      return RegisterGet.fromJson(jsonDecode(responseData));
    } else {
      final responseData = await response.stream.bytesToString();
      return RegisterGet.fromJson(jsonDecode(responseData));
    }
  }
}
