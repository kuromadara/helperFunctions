    public static boolean isRooted() {

        // get from build info
        String buildTags = android.os.Build.TAGS;
        if (buildTags != null && buildTags.contains("test-keys")) {
            return true;
        }

        // check package
        try {
            File file = new File("/system/app/Superuser.apk");
            if (file.exists()) {
                return true;
            }
        } catch (Exception e1) {
            // ignore
        }

        // try executing commands
        //return canExecuteCommand("/system/xbin/which su")|| canExecuteCommand("/system/bin/which su") || canExecuteCommand("which su");
        if(canExecuteCommand("su") ||findBinary("su"))
            return true;

        if(isEmulator()){
            return true;
        }
        return false;
    }

    public static boolean findBinary(String binaryName) {
        boolean found = false;
        if (!found) {
            String[] places = { "/sbin/", "/system/bin/", "/system/xbin/",
                    "/data/local/xbin/", "/data/local/bin/",
                    "/system/sd/xbin/", "/system/bin/failsafe/", "/data/local/" };
            Log.d("test", "loop okay");
            for (String where : places) {
                if (new File(where + binaryName).exists()) {
                    found = true;

                    break;
                }
            }
        }
        return found;
    }

    // executes a command on the system
    private static boolean canExecuteCommand(String command) {
        boolean executedSuccesfully;
        try {
            Runtime.getRuntime().exec(command);
            executedSuccesfully = true;
        } catch (Exception e) {
            executedSuccesfully = false;
        }

        return executedSuccesfully;
    }

    public static boolean isEmulator() {
        return (Build.BRAND.startsWith("generic") && Build.DEVICE.startsWith("generic"))
                || Build.FINGERPRINT.startsWith("generic")
                || Build.FINGERPRINT.startsWith("unknown")
                || Build.HARDWARE.contains("goldfish")
                || Build.HARDWARE.contains("ranchu")
                || Build.MODEL.contains("google_sdk")
                || Build.MODEL.contains("Emulator")
                || Build.MODEL.contains("Android SDK built for x86")
                || Build.MANUFACTURER.contains("Genymotion")
                || Build.PRODUCT.contains("sdk_google")
                || Build.PRODUCT.contains("google_sdk")
                || Build.PRODUCT.contains("sdk")
                || Build.PRODUCT.contains("sdk_x86")
                || Build.PRODUCT.contains("sdk_gphone64_arm64")
                || Build.PRODUCT.contains("vbox86p")
                || Build.PRODUCT.contains("emulator")
                || Build.PRODUCT.contains("simulator");
    }
}

// /dev/hRXKWVI/.magisk/mirror/system_root

// terminate app with a toast

Log.d("Root", "is the device rooted : " + " " + isRooted() + " " + "and" + " " + "is the device emulator : " + " " + isEmulator());

    if(isRooted()){
            Toast.makeText(LoginActivity.this, "Device is rooted or Emulator closing now.", Toast.LENGTH_LONG).show();
            AlertDialog.Builder builder
                    = new AlertDialog
                    .Builder(LoginActivity.this);
            builder.setMessage("Your device is rooted or you are using an emulator please use a different device.");

            builder.setTitle("Alert !");

            // Set Cancelable false
            // for when the user clicks on the outside
            // the Dialog Box then it will remain show
            builder.setCancelable(false);
            builder
                    .setPositiveButton(
                            "Close",
                            new DialogInterface
                                    .OnClickListener() {

                                @Override
                                public void onClick(DialogInterface dialog,
                                                    int which)
                                {

                                    finish();
                                }
                            });
            AlertDialog alertDialog = builder.create();

            // Show the Alert Dialog box
            alertDialog.show();

        }