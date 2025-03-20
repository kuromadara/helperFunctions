import 'dart:io';
import 'package:android_intent_plus/android_intent.dart';
import 'package:android_intent_plus/flag.dart';
import 'dart:io' show Platform;

class CommonServices {
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
}


// call

String phoneNumber = '6000850950';
int simSlot = 1; // 1 or 2

CommonServices().makePhoneCall(phoneNumber, simSlot);
