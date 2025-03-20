// Set the image file before calling the service
File imageFile = File('path_to_image.jpg');

RegisterService(
  registerPost: RegisterPost(
    name: _nameController.text,
    mobileNo: _mobileNoController.text,
    password: _passwordController.text,
    confirmPassword: _confirmPasswordController.text,
    isPolice: isPolice,
    imageFile: imageFile, // Set the image file here
  ),
).fetchRegister().then((response) {
  // Process the response as before
});
