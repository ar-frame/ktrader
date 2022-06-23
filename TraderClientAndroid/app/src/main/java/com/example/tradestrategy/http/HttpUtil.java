package com.example.tradestrategy.http;

import android.content.Context;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;
import android.widget.EditText;
import android.widget.LinearLayout;


import com.coopcoder.getcoder.Config;
import com.coopcoder.getcoder.Fetch;
import com.example.tradestrategy.bean.WorksSizeCheckUtil;

import java.util.List;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;

public class HttpUtil {
    public static Config config=null;

    public static Fetch getconfig(Context context) {
        //http://192.168.2.18:8082  http://192.168.2.18/task/server/arws.php
//        http://192.168.2.5/task/server/arws.php
//        http://120.24.7.188:8082/

//        String server_api  = "http://192.168.2.168/task/server/arws.php/";
        String server_api  = "http://192.168.101.177:19008";
        if (config==null){
            config = new Config(server_api, "AABBCCKTRADER2022");
        }
        SharedPreferences userSettings = context.getSharedPreferences("ActivationCode", 0);
        String user_auth_key = userSettings.getString("ActivationCode", "");
        Log.e("----------------", "getconfig: "+user_auth_key);
        config.setUserAuthKey(user_auth_key);
        Fetch fetch = new Fetch(config);
        return fetch;
    }


    // tchecker web
    public static String getHttptitle()
    {
        return "http://192.168.101.177:19005/";
    }


    public static void getOkHttpResquest(String address,okhttp3.Callback callback){
        OkHttpClient client = new OkHttpClient();
        Request request = new Request.Builder()
                .url(address)
                .build();
        client.newCall(request).enqueue(callback);
    }

    public static void sendOkHttpResquest(RequestBody requestBody, String address, okhttp3.Callback callback){
        OkHttpClient client = new OkHttpClient();
        Request request = new Request.Builder()
                .url(address)
                //.addHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8")
                .post(requestBody)
                .build();
        client.newCall(request).enqueue(callback);
    }

    public static void sendPictureOkHttpResquest(RequestBody requestBody,String s,String address, okhttp3.Callback callback){
        OkHttpClient client = new OkHttpClient();
        Request request = new Request.Builder()
                .url(address)
                .addHeader("uri",s)
                .post(requestBody)
                .build();
        client.newCall(request).enqueue(callback);
    }

    //判断是否有网络连接
    public static boolean isNetworkAvalible(Context context) {
        // 获得网络状态管理器
        ConnectivityManager connectivityManager = (ConnectivityManager) context
                .getSystemService(Context.CONNECTIVITY_SERVICE);

        if (connectivityManager == null) {
            return false;
        } else {
            // 建立网络数组
            NetworkInfo[] net_info = connectivityManager.getAllNetworkInfo();

            if (net_info != null) {
                for (int i = 0; i < net_info.length; i++) {
                    // 判断获得的网络状态是否是处于连接状态
                    if (net_info[i].getState() == NetworkInfo.State.CONNECTED) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static void checkbutton(final LinearLayout linearLayout, List<EditText> editTextList, final int colour1, final int colour2){
        //1.创建工具类对象 把要改变颜色的tv先传过去
        WorksSizeCheckUtil.textChangeListener textChangeListener = new WorksSizeCheckUtil.textChangeListener(linearLayout);

        //2.把所有要监听的edittext都添加进去
        textChangeListener.addAllEditText(editTextList);
        //3.接口回调 在这里拿到boolean变量 根据isHasContent的值决定 tv 应该设置什么颜色
        WorksSizeCheckUtil.setChangeListener(new WorksSizeCheckUtil.IEditTextChangeListener() {
            @Override
            public void textChange(boolean isHasContent) {
                if(isHasContent){
                    linearLayout.setBackgroundResource(colour2);
                }else{
                    linearLayout.setBackgroundResource(colour1);
                }
            }
        });
    }
}

