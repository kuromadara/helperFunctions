AlertDialog.Builder builder;
builder = new AlertDialog.Builder(getActivity(), R.style.AppAlertDialog);
builder.setMessage(R.string.service_charge)
       .setTitle("PLEASE NOTE")

       .setIcon(R.drawable.logo_splash)
       .setCancelable(false)
       .setPositiveButton("Payment", new DialogInterface.OnClickListener() {
           public void onClick(DialogInterface dialog, int id) {
               dialog.cancel();
               //Role id 1 is for admin

               if (mSessionManager.getRoleId() == 1) {
                   bookTicketRequestModel.setAgentFare(null);
                   mPresenter.bookTicket(bookTicketRequestModel, mSessionManager.getToken());
                   //viewModel.storeTemp(bookTicketRequestModel, mSessionManager.getToken());
                   showLoader();
               } else if (mSessionManager.getRoleId() == 2  ) {
                   //mPresenter.bookTicket(bookTicketRequestModel, mSessionManager.getToken());
                   viewModel.storeTemp(bookTicketRequestModel, mSessionManager.getToken());
                   showLoader();
               } else {
                   bookTicketRequestModel.setAgentFare(null);
                   //mPresenter.bookTicket(bookTicketRequestModel, mSessionManager.getToken());
                   viewModel.storeTemp(bookTicketRequestModel, mSessionManager.getToken());
                   showLoader();
               }
           }
       })
       .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
           public void onClick(DialogInterface dialog, int id) {
               //  Action for 'NO' Button
               dialog.cancel();
               hideLoader();

           }
       });
AlertDialog alert = builder.create();
alert.show();

TextView textView = (TextView) alert.findViewById(android.R.id.message);
Typeface face=Typeface.createFromAsset(getActivity().getAssets() ,"fonts/montserrat_regular.ttf");
textView.setAllCaps(true);
textView.setTypeface(face);
