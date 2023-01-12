// show hide password

class ChangePasswordDialog extends StatefulWidget {
  const ChangePasswordDialog({super.key});

  @override
  State<ChangePasswordDialog> createState() => _ChangePasswordDialogState();
}

class _ChangePasswordDialogState extends State<ChangePasswordDialog> {
  bool passwordVisibleOld = true;
  bool passwordVisibleNew = true;

  @override
  void initState() {
    super.initState();
    passwordVisibleOld = true;
    passwordVisibleNew = true;
  }

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('CHANGE PASSWORD'),
      content: SingleChildScrollView(
        child: ListBody(
          children: <Widget>[
            Container(
              margin: const EdgeInsets.only(bottom: 10),
              child: TextField(
                obscureText: passwordVisibleOld,
                decoration: InputDecoration(
                  border: const OutlineInputBorder(),
                  labelText: 'Enter Old Password',
                  suffixIcon: IconButton(
                    icon: Icon(passwordVisibleOld
                        ? Icons.visibility
                        : Icons.visibility_off),
                    onPressed: () {
                      setState(
                        () {
                          passwordVisibleOld = !passwordVisibleOld;
                        },
                      );
                    },
                  ),
                ),
              ),
            ),
            TextField(
              obscureText: passwordVisibleNew,
              decoration: InputDecoration(
                border: const OutlineInputBorder(),
                labelText: 'Enter New Password',
                suffixIcon: IconButton(
                  icon: Icon(passwordVisibleNew
                      ? Icons.visibility
                      : Icons.visibility_off),
                  onPressed: () {
                    setState(
                      () {
                        passwordVisibleNew = !passwordVisibleNew;
                      },
                    );
                  },
                ),
              ),
            ),
          ],
        ),
      ),
      actions: <Widget>[
        TextButton(
          child: const Text('Cancel'),
          onPressed: () {
            Navigator.of(context).pop();
          },
        ),
        TextButton(
          child: const Text('Change'),
          onPressed: () {
            Navigator.of(context).pop();
          },
        ),
      ],
    );
  }
}


// how to call the dialog box

ListTile(
  leading: Image.asset(
    "images/lock.png",
    width: 20,
    height: 20,
  ),
  title: const Text("CHANGE PASSWORD"),
  onTap: () {
    print("calling change password dialog");
    showDialog(
      context: context,
      builder: (context) => ChangePasswordDialog(),
    );
  },
),
