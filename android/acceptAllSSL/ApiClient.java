package com.techvariable.networktravels.api;

/**
 * Created by gitudrebel on 05-09-2016.
 *
 *
 *
 *
 */

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class ApiClient {

    //public static final String BASE_URL = "https://networktravels.org/";
//    public static final String BASE_URL = "http://143.110.248.194:8080/"; //production 27-APRIL
    public static final String BASE_URL = "https://www.networktravels.com:8443/"; //production 08-AUG
//    public static final String BASE_URL = "http://192.168.0.95:5000/"; //local test
    //public static final String BASE_URL = "http://143.110.248.194/"; //production non-ssl
    //public static final String BASE_URL = "http://192.168.0.109:5000";
    private static Retrofit retrofit = null;

    public static Retrofit getClient() {
        if (retrofit == null) {

            HttpLoggingInterceptor interceptor = new HttpLoggingInterceptor();
            interceptor.setLevel(HttpLoggingInterceptor.Level.BODY);
            OkHttpClient client = UnsafeOkHttpClient.getUnsafeOkHttpClient();

            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .client(client)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit;
    }

}
