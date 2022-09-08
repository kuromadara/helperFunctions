package com.techvariable.networktravels.bus;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import androidx.annotation.Nullable;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import com.google.android.material.snackbar.Snackbar;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;
import androidx.appcompat.widget.Toolbar;
import androidx.viewpager.widget.ViewPager;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.techvariable.networktravels.ActivityDatePicker;
import com.techvariable.networktravels.BaseFragment;
import com.techvariable.networktravels.CityListDialogFragment;
import com.techvariable.networktravels.Data.City;
import com.techvariable.networktravels.Injector;
import com.techvariable.networktravels.MainActivity;
import com.techvariable.networktravels.R;
import com.techvariable.networktravels.SessionManager;
import com.techvariable.networktravels.adapters.ViewPagerAdapter;
import com.techvariable.networktravels.customloader.BusListAutoCompleteTextView;
import com.techvariable.networktravels.customloader.LoaderHelper;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
/**
 * Created by gitudrebel on 07-07-2016.
 */
public class FrSearchBus extends BaseFragment implements BusContract.View,CityListDialogFragment.CityListClickedListener{

    public interface SearchBusListener{
        void onSearchClicked(Bundle arg);

    }


    @BindView(R.id.tvLabelFrom) TextView mTvLabelFrom;
    @BindView(R.id.tvLabelTo) TextView mTvLabelTo;
    @BindView(R.id.tvValueFrom)
    BusListAutoCompleteTextView mTvValueFrom;
    @BindView(R.id.tvValueTo) BusListAutoCompleteTextView mTvValueTo;
    @BindView(R.id.departDate) LinearLayout mTvDepartDate;
    //  @BindView(R.id.returnDate) TextView mTvReturnDate;
    //@BindView(R.id.tvDate) TextView mTvValueJourneyDate;
    //  @BindView(R.id.month) TextView mTvJourneyMonth;
    // @BindView(R.id.day) TextView mTvJourneyDay;
    //  @BindView(R.id.tvDate) TextView mTvJourneyDate;
    @BindView(R.id.btnGo) Button buttonGo;
    @BindView(R.id.mainContainer)CoordinatorLayout clMainBG;
    @BindView(R.id.tvDateValue)TextView mDateValue;
    @BindView(R.id.labelDate)TextView mTvLabelDate;
    @BindView(R.id.tvLoginDetails)TextView mTvLoginDetails;
    @BindView(R.id.tvLogout)TextView mTvLogout;
    @BindView(R.id.llLoginDetails)LinearLayout mLlLoginDetails;
    @BindView(R.id.ll_content)ViewGroup mVContent;
    @BindView(R.id.ll_fr_loader) android.view.View mLLFRLoader;

    @BindView(R.id.viewPagerMain)
    ViewPager mViewPager;


    private LoaderHelper mLoaderHelper;
    private String mDate;
    private Toolbar toolbar;
    private CityListDialogFragment mDialogCityList;
    private int KEY_CITY_TO_FROM=0;
    private static final int REQ_DATE_PICK=1;
    private SearchBusPresenter mPresenter;
    public SearchBusListener mListener;

    private SessionManager mSessionManager;

    public static FrSearchBus newInstance() {

        Bundle args = new Bundle();

        FrSearchBus fragment = new FrSearchBus();
        fragment.setArguments(args);
        return fragment;

    }


    @Override
    public void onResume() {
        super.onResume();
        mSessionManager=new SessionManager(getActivity());

        if(mSessionManager.isLoggedIn()) {
            if(mLlLoginDetails!=null)
                mLlLoginDetails.setVisibility(android.view.View.VISIBLE);

            if(mTvLoginDetails!=null)
                mTvLoginDetails.setText("" + mSessionManager.getUserEmail());
        }
        else
        {
            if(mLlLoginDetails!=null)
                mLlLoginDetails.setVisibility(android.view.View.GONE);
        }

    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);

        if (context instanceof SearchBusListener)
        {
            mListener= (SearchBusListener) context;
        }
    }

    @Nullable
    public android.view.View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        android.view.View view = inflater.inflate(R.layout.fr_search_bus, container, false);
        ButterKnife.bind((Object) this, view);
//        setFonts();

        ViewPagerAdapter mViewPagerAdapter;

        mViewPager = (ViewPager)view.findViewById(R.id.viewPagerMain);

        // Initializing the ViewPagerAdapter
        mViewPagerAdapter = new ViewPagerAdapter(getActivity());

        // Adding the Adapter to the ViewPager
        mViewPager.setAdapter(mViewPagerAdapter);
        


        this.mLoaderHelper = new LoaderHelper(getActivity(),mVContent, mLLFRLoader);

        return view;
    }

    @Override
    public void showErrorMessage(String message) {
        Toast.makeText(context(), message, Toast.LENGTH_SHORT).show();
    }



    @Override
    public Context context() {
        return getActivity();
    }




}
