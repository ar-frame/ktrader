package com.example.tradestrategy;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.Looper;
import android.provider.Settings;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.bean.CheckinfoData;
import com.example.tradestrategy.bean.CommonResponseData;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.MacAddresUtil;
import com.example.tradestrategy.http.OkGoUpdateHttpUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.meun.MainMeun;
import com.example.tradestrategy.meun.SoftwareDisclaimer;
import com.google.gson.Gson;
import com.vector.update_app.UpdateAppBean;
import com.vector.update_app.UpdateAppManager;
import com.vector.update_app.UpdateCallback;
import com.vector.update_app.utils.AppUpdateUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import okhttp3.Call;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

import static android.provider.Settings.EXTRA_APP_PACKAGE;
import static com.lzy.okgo.utils.HttpUtils.runOnUiThread;

public class SoftwareInformation extends Fragment implements View.OnClickListener {
    private LinearLayout softwareinformation_out,softwareinformation_sure,softwareinformation_updatalog;
    private RelativeLayout softwareinformation_update,softwareinformation_noticeset,softwareinformation_disclaimer,softwareinformation_isvip;
    private TextView softwareinformation_balanceday,softwareinformation_version,softwareinformation_suretext;
    private TextView softwareinformation_overhead,softwareinformation_agent;
    private EditText softwareinformation_key;
    private String version,activationcode;
    private static SharedPreferences.Editor editor;
    private TextView softwareinformation_call;
    private LinearLayout  softwareinformation_notvip;
    @SuppressLint("CommitPrefEdits")
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        
        View view=inflater.inflate(R.layout.softwareinformation,container,false);
        setStatusBar();
        version = AppUpdateUtils.getVersionName(getContext());

        SharedPreferences codeSettings = getActivity().getSharedPreferences("ActivationCode", 0);
        activationcode = codeSettings.getString("ActivationCode", "");
        editor = codeSettings.edit();

        initView(view);
        initData();
        return view;
    }

    
    

        
    

    private void initView(View view) {
       // softwareinformation_out = view.findViewById(R.id.softwareinformation_out);
        softwareinformation_update = view.findViewById(R.id.softwareinformation_update);
        softwareinformation_balanceday = view.findViewById(R.id.softwareinformation_balanceday);
        softwareinformation_version = view.findViewById(R.id.softwareinformation_version);
        softwareinformation_sure = view.findViewById(R.id.softwareinformation_sure);
        softwareinformation_key = view.findViewById(R.id.softwareinformation_key);
        softwareinformation_suretext = view.findViewById(R.id.softwareinformation_suretext);
        softwareinformation_updatalog = view.findViewById(R.id.softwareinformation_updatalog);
        softwareinformation_call = view.findViewById(R.id.softwareinformation_call);
      //  softwareinformation_overhead = view.findViewById(R.id.softwareinformation_overhead);
        softwareinformation_agent = view.findViewById(R.id.softwareinformation_agent);
        softwareinformation_noticeset=view.findViewById(R.id.softwareinformation_noticeset);
        softwareinformation_disclaimer=view.findViewById(R.id.softwareinformation_disclaimer);
        softwareinformation_notvip=view.findViewById(R.id.softwareinformation_notvip);
        softwareinformation_isvip=view.findViewById(R.id.softwareinformation_isvip);
    }

    private void initData() {
       // softwareinformation_out.setOnClickListener(this);
        softwareinformation_update.setOnClickListener(this);
        softwareinformation_sure.setOnClickListener(this);
        softwareinformation_updatalog.setOnClickListener(this);
        softwareinformation_call.setOnClickListener(this);
        softwareinformation_version.setText("V"+version);
        softwareinformation_noticeset.setOnClickListener(this);
        softwareinformation_disclaimer.setOnClickListener(this);
        softwareinformation_notvip.setOnClickListener(this);
        softwareinformation_isvip.setOnClickListener(this);



        new Thread(new Runnable() {
            @Override
            public void run() {
                checkinfo();
            }
        }).start();

        softwareinformation_key.addTextChangedListener(
                new TextWatcher() {
                    @Override
                    public void beforeTextChanged(CharSequence s, int start, int count, int after) {

                    }

                    @Override
                    public void onTextChanged(CharSequence s, int start, int before, int count) {

                    }

                    @Override
                    public void afterTextChanged(Editable s) {
                        if(s.toString().length()!=0) {
                            softwareinformation_suretext.setTextColor(Color.BLACK);
                        }else {
                            softwareinformation_suretext.setTextColor(Color.parseColor("#9b9b9b"));
                        }
                    }
                }
        );
    }

    private void checkinfo() {
        String phoneinfo = ValidateUtil.getPhoneInformation();
        String mac = ValidateUtil.getMac(getContext());
        MacAddresUtil macAddresUtil = new MacAddresUtil(getContext());
        FormBody.Builder builder=new FormBody.Builder();
        builder.add("lastRegisterCode",activationcode);
        builder.add("mac",mac);
        builder.add("pm",phoneinfo);
        builder.add("uid",macAddresUtil.getUniqueID());
      /*  Log.e("111111111","lastRegisterCode is "+activationcode);
        Log.e("111111111","mac is "+mac);
        Log.e("111111111","pm is "+phoneinfo);
        Log.e("111111111","uid is "+macAddresUtil.getUniqueID());*/
        RequestBody formBody=builder.build();
        HttpUtil.sendOkHttpResquest(formBody,HttpUtil.getHttptitle()+"Checker/authUser", new okhttp3.Callback() {
            @Override
            public void onFailure(Call call, IOException e) {

            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String responseData = response.body().string();
                Log.e("---------", "onResponse: "+responseData );
                final Gson gson = new Gson();
                final CheckinfoData checkinfoData = gson.fromJson(responseData, CheckinfoData.class);

                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        if(checkinfoData.isCheck_result()&&checkinfoData.getIsvip()==0){
                            softwareinformation_balanceday.setText(checkinfoData.getCan_use_dayoff()+"");
                            Log.e("------------", "run: "+ checkinfoData.getCan_use_dayoff()+"");
//                            softwareinformation_overhead.setText(checkinfoData.getService_info());
                            softwareinformation_agent.setText(checkinfoData.getVersion_name());
                            softwareinformation_call.setText("???????????????"+checkinfoData.getService_call());
                            softwareinformation_isvip.setVisibility(View.VISIBLE);
                            softwareinformation_notvip.setVisibility(View.INVISIBLE);

                        }else {
                            softwareinformation_balanceday.setText("0");
                        //    softwareinformation_overhead.setText(checkinfoData.getService_info());
                            softwareinformation_agent.setText(checkinfoData.getVersion_name());
                            softwareinformation_call.setText("???????????????"+checkinfoData.getService_call());
                            softwareinformation_isvip.setVisibility(View.VISIBLE);
                            softwareinformation_notvip.setVisibility(View.INVISIBLE);
                        }
                    }
                });

            }
        });
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            //case R.id.softwareinformation_out:
              //  if(softwareinformation_balanceday.getText().equals("0")){
                //    Toast.makeText(getContext(),"???????????????,?????????????????????",Toast.LENGTH_SHORT).show();
               // }
                //else {
                 //   getActivity().finish();
               // }
               // break;

            case R.id.softwareinformation_update:
                new Thread(new Runnable() {
                    @Override
                    public void run() {
                        checkupdate();
                    }
                }).start();
                //Toast.makeText(SoftwareInformation.this,"??????????????????",Toast.LENGTH_SHORT).show();
                break;
            case R.id.softwareinformation_sure:
                String key = softwareinformation_key.getText().toString().trim();
                if(key.equals("")){
                    Toast.makeText(getContext(),"?????????????????????",Toast.LENGTH_SHORT).show();
                }else {
                    new Thread(new Runnable() {
                        @Override
                        public void run() {
                            sendinfo();
                        }
                    }).start();
                }
                //Toast.makeText(SoftwareInformation.this,"??????????????????",Toast.LENGTH_SHORT).show();
                break;
            case R.id.softwareinformation_updatalog:
                Intent intent_updatalog = new Intent(getActivity(),UpdataLogInfo.class);
                startActivity(intent_updatalog);
                break;
            case R.id.softwareinformation_call:
                String phone = softwareinformation_call.getText().toString().trim();
                ValidateUtil.callphone(phone,getContext());
                break;
            case  R.id.softwareinformation_noticeset:
                checkNotifySetting();
                break;
            case R.id.softwareinformation_disclaimer:
                Intent intent_softwareinformation_disclaimer=new Intent(getActivity(), SoftwareDisclaimer.class);
                startActivity(intent_softwareinformation_disclaimer);
                break;

        }
    }

    private void sendinfo() {
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                final String code = softwareinformation_key.getText().toString().trim();
                String mac = ValidateUtil.getMac(getContext());
                String phoneinfo = ValidateUtil.getPhoneInformation();
                MacAddresUtil macAddresUtil = new MacAddresUtil(getActivity());
                FormBody.Builder builder=new FormBody.Builder();
                builder.add("registerCode",code);
                builder.add("pm",phoneinfo);
                builder.add("mac",mac);
                builder.add("uid",macAddresUtil.getUniqueID());
                RequestBody formBody=builder.build();
                HttpUtil.sendOkHttpResquest(formBody,HttpUtil.getHttptitle()+"/Checker/registerCodeUser", new okhttp3.Callback() {
                    @Override
                    public void onFailure(Call call, IOException e) {

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
                                    Toast.makeText(getActivity(),"???????????????",Toast.LENGTH_SHORT).show();
                                    Intent intent = new Intent(getActivity(), MainMeun.class);
                                    startActivity(intent);
                                    getActivity().finish();
                                }
                            });
                        }else {
                            Looper.prepare();
                            Toast.makeText(getActivity(),commonResponseData.getError_msg()+"",Toast.LENGTH_SHORT).show();
                            Looper.loop();
                        }
                    }
                });
            }
        });
    }

    private void checkupdate() {
        String path = Environment.getExternalStorageDirectory().getAbsolutePath();
        Map<String, String> params = new HashMap<String, String>();
        params.put("access_token", "fromwalletapp");
        params.put("version", version);
        params.put("appname", "trader");
        new UpdateAppManager
                .Builder()
                //?????????????????????Activity
                .setActivity(getActivity())
                //?????????????????????httpManager???????????????
                .setHttpManager(new OkGoUpdateHttpUtil())
                //???????????????????????????
                .setUpdateUrl("https://api.coopcoder.com/Open/checkAppVersion")
                //???????????????????????????
                //???????????????????????????get
                .setPost(true)
                //??????????????????????????????version=1.0.0???app???versionName??????apkKey=??????????????????AndroidManifest.xml?????????
                .setParams(params)
                //?????????????????????????????????????????????????????????????????????????????????????????????
                //.hideDialogOnDownloading(flase)
                //??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
                .setTopPic(R.mipmap.top_8)
                //????????????????????????????????????????????????????????????????????????
                //.setThemeColor(ColorUtil.getRandomColor())
                //??????apk????????????????????????????????????sd??????/Download/1.0.0/test.apk
                .setTargetPath(path)
                //??????appKey????????????AndroidManifest.xml?????????????????????????????????????????????????????????
                //.setAppKey("ab55ce55Ac4bcP408cPb8c1Aaeac179c5f6f")
                //???????????????????????????
                .dismissNotificationProgress()
                //??????????????????
                //.showIgnoreVersion()
                .build()
                //????????????????????????
                .checkNewApp(new UpdateCallback() {
                    /**
                     * ??????json,???????????????
                     *
                     * @param json ??????????????????json
                     * @return UpdateAppBean
                     */
                    @Override
                    protected UpdateAppBean parseJson(String json) {
                        UpdateAppBean updateAppBean = new UpdateAppBean();
                        try {
                            JSONObject jsonObject = new JSONObject(json);
                            if (jsonObject.getString("update").equals("Yes")) {
                                updateAppBean
                                        //????????????????????????Yes,No
                                        .setUpdate(jsonObject.optString("update"))
                                        //???????????????????????????
                                        .setNewVersion(jsonObject.optString("new_version"))
                                        //????????????????????????
                                        .setApkFileUrl(jsonObject.optString("apk_file_url"))
                                        //????????????????????????
                                        .setUpdateLog(jsonObject.optString("update_log"))
                                        //???????????????????????????????????????????????????
                                        .setTargetSize(jsonObject.optString("target_size"))
                                        //????????????????????????????????????
                                        .setConstraint(true)
                                        //??????md5??????????????????
                                        .setNewMd5(jsonObject.optString("new_md51"));
                         /*   if (updateAppBean.getNewVersion().equals(version)||
                                    updateAppBean.getNewVersion().compareTo(version)<0) {
                                noNewApp();
                                return null;
                            }*/
                            }else {
                                noNewApp();
                            }
                        }catch(JSONException e){
                            e.printStackTrace();
                        }
                        return updateAppBean;
                    }

                 /*    //??????????????????
                    @Override
                    public void onBefore() {
                        CProgressDialogUtils.showProgressDialog(MySet.this);
                    }

                    //??????????????????

                    @Override
                    public void onAfter() {
                        CProgressDialogUtils.cancelProgressDialog(MySet.this);
                    }*/

                    /**
                     * ???????????????
                     */
                    private void noNewApp() {
                        Toast.makeText(getActivity(), "?????????????????????", Toast.LENGTH_SHORT).show();
                    }
                });
    }
    private void checkNotifySetting() {
        try {
            Intent intent = new Intent();
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                intent.setAction(Settings.ACTION_APP_NOTIFICATION_SETTINGS);
            }
            //????????????????????? API 26, ???8.0??????8.0??????????????????
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                intent.putExtra(EXTRA_APP_PACKAGE, getActivity().getPackageName());
            }
            //intent.putExtra(EXTRA_CHANNEL_ID, getApplicationInfo().uid);

            //????????????????????? API21??????25?????? 5.0??????7.1 ???????????????????????????
            intent.putExtra("app_package", getActivity().getPackageName());
            intent.putExtra("app_uid", getActivity().getApplicationInfo().uid);

            // ??????6 -MIUI9.6-8.0.0??????????????????????????????????????????????????????"????????????????????????"
            if ("MI 6".equals(Build.MODEL)) {
                intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                Uri uri = Uri.fromParts("package", getActivity().getPackageName(), null);
                intent.setData(uri);
                // intent.setAction("com.android.settings/.SubSettings");
            }
            startActivity(intent);
        } catch (Exception e) {
            e.printStackTrace();
            // ?????????????????????????????????????????????????????????3??????OC105 API25
            Intent intent = new Intent();

            //??????????????????????????????????????????????????????????????????
            //https://blog.csdn.net/ysy950803/article/details/71910806
            intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
            Uri uri = Uri.fromParts("package", getActivity().getPackageName(), null);
            intent.setData(uri);
            startActivity(intent);
        }
    }

    private void setStatusBar() {
        Window window = getActivity().getWindow();
        window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
            window.setStatusBarColor(Color.TRANSPARENT);
        }
        //????????????????????????
        WindowManager.LayoutParams lp = window.getAttributes();
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            lp.layoutInDisplayCutoutMode = WindowManager.LayoutParams.LAYOUT_IN_DISPLAY_CUTOUT_MODE_SHORT_EDGES;
        }
        //????????????????????????????????????
        window.setAttributes(lp);
        ValidateUtil.setStatusBarLightMode(getActivity(),Color.parseColor("#21212B"));
        ValidateUtil.setLightStatusBar(getActivity(),false);
    }
}
