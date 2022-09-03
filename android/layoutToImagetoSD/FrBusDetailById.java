package com.techvariable.networktravels.bus;

import static android.content.ContentValues.TAG;

import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.nfc.Tag;
import android.os.Bundle;
import android.os.Environment;
import android.text.Layout;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.fragment.app.Fragment;

import com.techvariable.networktravels.Data.ApiResponse;
import com.techvariable.networktravels.Data.BookTicketResponse;
import com.techvariable.networktravels.Data.BusRepository;
import com.techvariable.networktravels.Data.DataCallback;
import com.techvariable.networktravels.Data.TicketDetails;
import com.techvariable.networktravels.Data.TicketResponse;
import com.techvariable.networktravels.Data.TicketResponseA;
import com.techvariable.networktravels.R;
import com.techvariable.networktravels.SessionManager;
import com.techvariable.networktravels.adapters.TicketDownloadAdapter;
import com.techvariable.networktravels.api.ApiClient;
import com.techvariable.networktravels.api.ApiInterface;
import com.techvariable.networktravels.payment.PaymentViewModel;

import java.io.File;
import java.io.FileOutputStream;
import java.util.List;

import okhttp3.ResponseBody;

/**
 * A simple {@link Fragment} subclass.
 */
public class FrBusDetailById extends Fragment {


    private SessionManager mSessionManager;
    private BookTicketResponse mBookTicketResponse;
    BusRepository mRepository;
    public static FrBusDetailById newInstance() {

        Bundle args = new Bundle();

        FrBusDetailById fragment = new FrBusDetailById();
        fragment.setArguments(args);
        return fragment;
    }

    public FrBusDetailById() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {



        View view = inflater.inflate(R.layout.fr_bus_detail_id, container, false);

        EditText busIdInput = view.findViewById(R.id.busIdInput);
        TextView busDetailTextView = (TextView) view.findViewById(R.id.busDetailText);

        LinearLayout SearchLinearLayout = (LinearLayout) view.findViewById(R.id.search_layout);
        LinearLayout TicketLinearLayout = (LinearLayout) view.findViewById(R.id.ticket_layout);

        TextView PnrTextView = (TextView) view.findViewById(R.id.pnr);
        TextView MobileTextView = (TextView) view.findViewById(R.id.mobile);
        TextView FromCityTextView = (TextView) view.findViewById(R.id.from);
        TextView ToCityTextView = (TextView) view.findViewById(R.id.to);
        TextView DateTextView = (TextView) view.findViewById(R.id.date);
        TextView BoardingPointTextView = (TextView) view.findViewById(R.id.board_point);
        TextView DeptTimeTextView = (TextView) view.findViewById(R.id.dep_time);
        TextView SeatsTextView = (TextView) view.findViewById(R.id.seats);
        TextView TotalFareTextView = (TextView) view.findViewById(R.id.total_fare);

        Button btnBusIdSubmit = (Button) view.findViewById(R.id.busIdSubmit);

        Button convertImg = (Button) view.findViewById(R.id.btnConvertToimage);

        btnBusIdSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // busDetailText

                ApiInterface service = ApiClient.getClient().create(ApiInterface.class);


                //get text from busIdInput
                String busId = busIdInput.getText().toString();

                ActivityBusDetails ViewTicket = new ActivityBusDetails();

                ViewTicket. ViewTicketTwo(busId,
                        new DataCallback<BookTicketResponse>() {
                            @Override
                            public void onSuccess(BookTicketResponse bookTicketResponse) {
                                Log.d(TAG, "noSeats: " + bookTicketResponse.getmNoOfSeats());


                                TicketLinearLayout.setVisibility(View.VISIBLE);
                                convertImg.setVisibility(View.VISIBLE);

                                SearchLinearLayout.setVisibility(View.GONE);

//                                busDetailTextView.setVisibility(View.VISIBLE);

                                if (busDetailTextView.getVisibility() == View.VISIBLE)
                                    busDetailTextView.setVisibility(View.GONE);
                                else
                                    busDetailTextView.setVisibility(View.VISIBLE);

                                PnrTextView.setText(bookTicketResponse.getmPnrNumber());
                                MobileTextView.setText(bookTicketResponse.getmMobile());
                                FromCityTextView.setText(bookTicketResponse.getmFromCity());
                                ToCityTextView.setText(bookTicketResponse.getmToCity());
                                DateTextView.setText(bookTicketResponse.getmJourneyDate());
                                BoardingPointTextView.setText(bookTicketResponse.getBoardingPoint());
                                DeptTimeTextView.setText(bookTicketResponse.getmStartTime());
                                SeatsTextView.setText(String.valueOf(bookTicketResponse.getmNoOfSeats()));
                                TotalFareTextView.setText(String.valueOf(bookTicketResponse.getmTotalFare()));
//                                if(bookTicketResponse.getBoardingPoint() != null) {
//                                    busDetailTextView.setText(bookTicketResponse.getBoardingPoint());
//                                Log.d("TicketResponse", bookTicketResponse.toString());
//                                } else {
//                                    busDetailTextView.setText("No ticket found");
//                                }
                            }

                            @Override
                            public void onError(String message) {
                                busDetailTextView.setVisibility(View.VISIBLE);
                                busDetailTextView.setText("No ticket found. \n Please check your Booking ID/PNR");
                            }
                        }
                );
            }
        });


//        ImageView TicketImage = (ImageView) view.findViewById(R.id.imgResultImage);


        convertImg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Bitmap image = TicketDownloadAdapter.getBitmapFromView(TicketLinearLayout);
                TicketDownloadAdapter.saveImage(image, (String) PnrTextView.getText());
//                TicketImage.setImageBitmap(image);
            }


        });


        return view;
    }
}
