AccelerometerEvent _accelerometerEvent = AccelerometerEvent(0, 0, 0);
  late StreamSubscription<AccelerometerEvent> _streamSubscription;
  double _thresholdGravity = 2.5;
  double _gravitational_acceleration_constant = 9.81;

  void _initializeAccelerometer() {
    _streamSubscription =
        accelerometerEvents.listen((AccelerometerEvent event) {
      setState(() {
        _accelerometerEvent = event;
        if (_accelerometerEvent != null) {
          double x = _accelerometerEvent.x;
          double y = _accelerometerEvent.y;
          double z = _accelerometerEvent.z;

          double acceleration = sqrt(x * x + y * y + z * z) -
              _gravitational_acceleration_constant;
          print("acceleration: ${acceleration}");
          _thresholdGravity = max(acceleration, _thresholdGravity);

          if (_samplingRate == null) {
            // Start timer when first event is received
            Timer.periodic(Duration(milliseconds: 1), (timer) {
              if (_accelerometerEvent != null) {
                // Stop timer when second event is received
                timer.cancel();
                double elapsedMs = timer.tick * 1.0;
                _samplingRate = 1000.0 / elapsedMs;
                print("Sampling rate: $_samplingRate Hz");
              }
            });
          }
        }

        print("accelerometerEvent: ${_accelerometerEvent}");
        print("gravity: ${_thresholdGravity}");
      });
    });
  }

  String phoneNumber = '7002613213';
  int simSlot = 1; // 1 or 2

  @override
  void initState() {
    super.initState();

    _initializeAccelerometer();

    ShakeDetector detector = ShakeDetector.autoStart(
      onPhoneShake: () {
        // _callNumber();
        CommonServices().makePhoneCall(phoneNumber, simSlot);
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Shake!'),
          ),
        );
      },
      minimumShakeCount: 2,
      shakeSlopTimeMS: 500,
      shakeCountResetTime: 3000,
      shakeThresholdGravity: _thresholdGravity,
    );

    // To close: detector.stopListening();
    // ShakeDetector.waitForStart() waits for user to call detector.startListening();
  }
