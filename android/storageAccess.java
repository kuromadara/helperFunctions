// on main activity onCreate()

        if (Build.VERSION.SDK_INT >= 30){
            if (!Environment.isExternalStorageManager()){
                Intent getpermission = new Intent();
                getpermission.setAction(Settings.ACTION_MANAGE_ALL_FILES_ACCESS_PERMISSION);
                startActivity(getpermission);
            }
        }
	
Declare the MANAGE_EXTERNAL_STORAGE permission in the manifest.
	
https://stackoverflow.com/questions/66839849/android-studio-getting-error-ioexception-operation-not-permitted-while-creating

//use legacy to get access in android 10

android:requestLegacyExternalStorage='true'

//use legacy to get access in android 11 should work but didn't

android:preserveLegacyExternalStorage='true'

//the above cannot be uploaded to play store so

IMAGE_DIRECTORY = "/Documents"; 

//use public directory such as these

https://stackoverflow.com/questions/64221188/write-external-storage-when-targeting-android-10?noredirect=1&lq=1