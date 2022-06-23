package com.example.tradestrategy;

import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Looper;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.bean.CommonResponseData;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.MacAddresUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.meun.MainMeun;
import com.githang.statusbar.StatusBarCompat;
import com.google.gson.Gson;
import com.wang.avi.AVLoadingIndicatorView;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Login extends AppCompatActivity implements View.OnClickListener {
    private LinearLayout login;
    private RelativeLayout exit;
    private EditText login_activationcode;
    private static SharedPreferences.Editor editor;
    private List<EditText> editTextList = new ArrayList<>();
    private AVLoadingIndicatorView main_avliv;
    private TextView login_nonet;


    @SuppressLint("CommitPrefEdits")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        setStatusBar();
        SharedPreferences codeSettings = getSharedPreferences("ActivationCode", 0);
        editor = codeSettings.edit();
        initView();
        initData();
    }

    private void setStatusBar() {
        Window window = getWindow();
        window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
            window.setStatusBarColor(Color.TRANSPARENT);
        }
        //设置页面全屏显示
        WindowManager.LayoutParams lp = window.getAttributes();
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            lp.layoutInDisplayCutoutMode = WindowManager.LayoutParams.LAYOUT_IN_DISPLAY_CUTOUT_MODE_SHORT_EDGES;
        }
        //设置页面延伸到刘海区显示
        window.setAttributes(lp);
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#ffffffff"));
        ValidateUtil.setLightStatusBar(this,true);
    }

    private void initView() {
        exit = findViewById(R.id.exit);
        login = findViewById(R.id.login);
        login_activationcode = findViewById(R.id.login_activationcode);
        main_avliv =findViewById(R.id.main_avliv);
        login_nonet = findViewById(R.id.login_nonet);
    }

    private void initData() {
        exit.setOnClickListener(this);
        login.setOnClickListener(this);

        if(!ValidateUtil.isNetworkAvalible(this)){
            login_nonet.setVisibility(View.VISIBLE);
        }

        login_activationcode.addTextChangedListener(
                new TextWatcher() {
                    @Override
                    public void beforeTextChanged(CharSequence s, int start, int count, int after) {

                    }

                    @Override
                    public void onTextChanged(CharSequence s, int start, int before, int count) {

                    }

                    @Override
                    public void afterTextChanged(Editable s) {
                        if(s.toString().length()!=0){
                            editTextList.add(login_activationcode);
                            ValidateUtil.checkbutton(login,editTextList);
                        }
                    }
                }
        );
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.login:
                String code = login_activationcode.getText().toString().trim();
                if(!code.equals("")){
                    new Thread(new Runnable() {
                        @Override
                        public void run() {
                            checkcode();
                        }
                    }).start();
                }else {
                    Toast.makeText(Login.this,"请输入激活码",Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.exit:
                AlertDialog.Builder builder1=new AlertDialog.Builder(Login.this);
                builder1.setTitle("温馨提示")
                        .setMessage("您确认退出本系统？")
                        .setPositiveButton("确认", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                finish();
                            }
                        })
                        .setNegativeButton("取消", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.dismiss();
                            }
                        })
                        .create()
                        .show();

                break;
        }
    }

    private void checkcode() {
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                main_avliv.setVisibility(View.VISIBLE);
                main_avliv.show();
                String phoneinfo = ValidateUtil.getPhoneInformation();
                String mac = ValidateUtil.getMac(Login.this);
                MacAddresUtil macAddresUtil = new MacAddresUtil(Login.this);
                final String code = login_activationcode.getText().toString().trim();
                FormBody.Builder builder=new FormBody.Builder();
                builder.add("registerCode",code);
                builder.add("mac",mac);
                builder.add("pm",phoneinfo);
                builder.add("uid",macAddresUtil.getUniqueID());
                RequestBody formBody=builder.build();
                HttpUtil.sendOkHttpResquest(formBody,HttpUtil.getHttptitle()+"/Checker/registerCodeUser", new okhttp3.Callback() {
                    @Override
                    public void onFailure(Call call, IOException e) {
                        //Log.e("11111111111","e is "+e);
                    }

                    @Override
                    public void onResponse(Call call, Response response) throws IOException {
                        String responseData = response.body().string();
                        Gson gson = new Gson();
                        CommonResponseData commonResponseData = gson.fromJson(responseData,CommonResponseData.class);
                        if(commonResponseData.getRet_code().equals("1000")){
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    editor.putString("ActivationCode",code);
                                    editor.commit();
                                    Intent intent = new Intent(Login.this, MainMeun.class);
                                    startActivity(intent);
                                    main_avliv.hide();
                                    main_avliv.setVisibility(View.GONE);
                                    finish();
                                }
                            });
                        }else {
                            Looper.prepare();
                            Toast.makeText(Login.this,commonResponseData.getError_msg()+"",Toast.LENGTH_SHORT).show();
                            Looper.loop();
                        }
                    }
                });
            }
        });
    }
}
