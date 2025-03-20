
// Below condition is required to prevent twice back
int count = 0;
Navigator.of(context).popUntil((_) => count++ >= 1);
Navigator.pushReplacement(
  context,
  CustomPageRoute(
    builder: (context) {
      return const SurveyScreen();
    },
  ),
);

// if i move from SurveyScreen to screenA and it moves me back to SurveyScreen the count condition will remove duplicate SurveyScreen from the stack 
