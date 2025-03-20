Future<void> main() async {

  WidgetsFlutterBinding.ensureInitialized();
  await initializeService();

  initAutoStart();
  runApp(const MyApp());
}


// initializeService runs the app in Background.
// initAutoStart check if app has on boot run permission.

// on 3 shake call  a number from home activity.


import 'package:shake/shake.dart';

// method 1

_callNumber() async {
    const number = '6000850950'; //set the number here
    bool? res = await FlutterPhoneDirectCaller.callNumber(number);
    print("call result: $res");
  }

// method 2

String phoneNumber = '6000850950';
int simSlot = 1; // 1 or 2
void makePhoneCall(String phoneNumber, int simSlot) {
  if (Platform.isAndroid) {
    final intent = AndroidIntent(
      action: 'android.intent.action.CALL',
      data: 'tel:$phoneNumber',
      arguments: {
        'com.android.phone.force.slot': true,
        'com.android.phone.extra.slot':
            simSlot - 1, // slot index starts from 0
      },
    );
    intent.launch();

    print('Calling $phoneNumber on sim slot $simSlot');
  } else {
    // call phone directly on other platforms
    // ...
  }
}


@override
void initState() {
  super.initState();
  ShakeDetector detector = ShakeDetector.autoStart(
    onPhoneShake: () {
      // _callNumber();
      makePhoneCall(phoneNumber, simSlot);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Shake!'),
        ),
      );
    },
    minimumShakeCount: 3,
    shakeSlopTimeMS: 500,
    shakeCountResetTime: 3000,
    shakeThresholdGravity: 2.7,
  );

  // To close: detector.stopListening();
  // ShakeDetector.waitForStart() waits for user to call detector.startListening();
}

/**
 * Method 1 doesnot but doesnot lunch the UI so indroid native intent is being used in the second method
 * ShakeDetector is in the initState.
 */
