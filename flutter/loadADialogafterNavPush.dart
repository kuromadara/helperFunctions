WidgetsBinding.instance.addPostFrameCallback((_) {
              showDialog(
                context: context,
                builder: (context) => const ChangePasswordDialog(),
              );
            });
            Navigator.pushReplacement(
              context,
              MaterialPageRoute(
                builder: (context) => UserProfile(
                  loginType: 1,
                ),
              ),
            );
