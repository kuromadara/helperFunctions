import 'dart:io';

class RegisterPost {
  // Existing fields...
  String name;
  String mobileNo;
  String password;
  String confirmPassword;
  String isPolice;

  // New field for image file
  File? imageFile; // Use `File` class from `dart:io`

  RegisterPost({
    // Existing constructor...
    required this.name,
    required this.mobileNo,
    required this.password,
    required this.confirmPassword,
    required this.isPolice,
    // Add this constructor parameter for the image
    this.imageFile,
  });

  // Existing toJson() method...

  // New method to create the multipart request
  Map<String, dynamic> toFormData() {
    Map<String, dynamic> formData = {
      'name': name,
      'mobile_no': mobileNo,
      'password': password,
      'password_confirmation': confirmPassword,
      'is_police': isPolice
    };

    // Add the image file to the form data if available
    if (imageFile != null) {
      formData['image'] = http.MultipartFile.fromFileSync(imageFile!.path);
    }

    return formData;
  }
}
