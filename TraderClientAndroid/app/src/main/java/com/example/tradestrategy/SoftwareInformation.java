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
                            softwareinformation_call.setText("客服电话："+checkinfoData.getService_call());
                            softwareinformation_isvip.setVisibility(View.VISIBLE);
                            softwareinformation_notvip.setVisibility(View.INVISIBLE);

                        }else {
                            softwareinformation_balanceday.setText("0");
                        //    softwareinformation_overhead.setText(checkinfoData.getService_info());
                            softwareinformation_agent.setText(checkinfoData.getVersion_name());
                            softwareinformation_call.setText("客服电话："+checkinfoData.getService_call());
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
                //    Toast.makeText(getContext(),"充值成功后,方可继续使用！",Toast.LENGTH_SHORT).show();
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
                //Toast.makeText(SoftwareInformation.this,"点击了升级！",Toast.LENGTH_SHORT).show();
                break;
            case R.id.softwareinformation_sure:
                String key = softwareinformation_key.getText().toString().trim();
                if(key.equals("")){
                    Toast.makeText(getContext(),"请输入激活码！",Toast.LENGTH_SHORT).show();
                }else {
                    new Thread(new Runnable() {
                        @Override
                        public void run() {
                            sendinfo();
                        }
                    }).start();
                }
                //Toast.makeText(SoftwareInformation.this,"点击了确认！",Toast.LENGTH_SHORT).show();
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
                                    Toast.makeText(getActivity(),"充值成功！",Toast.LENGTH_SHORT).show();
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
                //必须设置，当前Activity
                .setActivity(getActivity())
                //必须设置，实现httpManager接口的对象
                .setHttpManager(new OkGoUpdateHttpUtil())
                //必须设置，更新地址
                .setUpdateUrl("https://api.coopcoder.com/Open/checkAppVersion")
                //以下设置，都是可选
                //设置请求方式，默认get
                .setPost(true)
                //添加自定义参数，默认version=1.0.0（app的versionName）；apkKey=唯一表示（在AndroidManifest.xml配置）
                .setParams(params)
                //设置点击升级后，消失对话框，默认点击升级后，对话框显示下载进度
                //.hideDialogOnDownloading(flase)
                //设置头部，不设置显示默认的图片，设置图片后自动识别主色调，然后为按钮，进度条设置颜色
                .setTopPic(R.mipmap.top_8)
                //为按钮，进度条设置颜色，默认从顶部图片自动识别。
                //.setThemeColor(ColorUtil.getRandomColor())
                //设置apk下砸路径，默认是在下载到sd卡下/Download/1.0.0/test.apk
                .setTargetPath(path)
                //设置appKey，默认从AndroidManifest.xml获取，如果，使用自定义参数，则此项无效
                //.setAppKey("ab55ce55Ac4bcP408cPb8c1Aaeac179c5f6f")
                //不显示通知栏进度条
                .dismissNotificationProgress()
                //是否忽略版本
                //.showIgnoreVersion()
                .build()
                //检测是否有新版本
                .checkNewApp(new UpdateCallback() {
                    /**
                     * 解析json,自定义协议
                     *
                     * @param json 服务器返回的json
                     * @return UpdateAppBean
                     */
                    @Override
                    protected UpdateAppBean parseJson(String json) {
                        UpdateAppBean updateAppBean = new UpdateAppBean();
                        try {
                            JSONObject jsonObject = new JSONObject(json);
                            if (jsonObject.getString("update").equals("Yes")) {
                                updateAppBean
                                        //（必须）是否更新Yes,No
                                        .setUpdate(jsonObject.optString("update"))
                                        //（必须）新版本号，
                                        .setNewVersion(jsonObject.optString("new_version"))
                                        //（必须）下载地址
                                        .setApkFileUrl(jsonObject.optString("apk_file_url"))
                                        //（必须）更新内容
                                        .setUpdateLog(jsonObject.optString("update_log"))
                                        //大小，不设置不显示大小，可以不设置
                                        .setTargetSize(jsonObject.optString("target_size"))
                                        //是否强制更新，可以不设置
                                        .setConstraint(true)
                                        //设置md5，可以不设置
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

                 /*    //网络请求之前
                    @Override
                    public void onBefore() {
                        CProgressDialogUtils.showProgressDialog(MySet.this);
                    }

                    //网路请求之后

                    @Override
                    public void onAfter() {
                        CProgressDialogUtils.cancelProgressDialog(MySet.this);
                    }*/

                    /**
                     * 没有新版本
                     */
                    private void noNewApp() {
                        Toast.makeText(getActivity(), "已是最新版本！", Toast.LENGTH_SHORT).show();
                    }
                });
    }
    private void checkNotifySetting() {
        try {
            Intent intent = new Intent();
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                intent.setAction(Settings.ACTION_APP_NOTIFICATION_SETTINGS);
            }
            //这种方案适用于 API 26, 即8.0（含8.0）以上可以用
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                intent.putExtra(EXTRA_APP_PACKAGE, getActivity().getPackageName());
            }
            //intent.putExtra(EXTRA_CHANNEL_ID, getApplicationInfo().uid);

            //这种方案适用于 API21——25，即 5.0——7.1 之间的版本可以使用
            intent.putExtra("app_package", getActivity().getPackageName());
            intent.putExtra("app_uid", getActivity().getApplicationInfo().uid);

            // 小米6 -MIUI9.6-8.0.0系统，是个特例，通知设置界面只能控制"允许使用通知圆点"
            if ("MI 6".equals(Build.MODEL)) {
                intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                Uri uri = Uri.fromParts("package", getActivity().getPackageName(), null);
                intent.setData(uri);
                // intent.setAction("com.android.settings/.SubSettings");
            }
            startActivity(intent);
        } catch (Exception e) {
            e.printStackTrace();
            // 出现异常则跳转到应用设置界面：锤子坚果3——OC105 API25
            Intent intent = new Intent();

            //下面这种方案是直接跳转到当前应用的设置界面。
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
        //设置页面全屏显示
        WindowManager.LayoutParams lp = window.getAttributes();
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            lp.layoutInDisplayCutoutMode = WindowManager.LayoutParams.LAYOUT_IN_DISPLAY_CUTOUT_MODE_SHORT_EDGES;
        }
        //设置页面延伸到刘海区显示
        window.setAttributes(lp);
        ValidateUtil.setStatusBarLightMode(getActivity(),Color.parseColor("#21212B"));
        ValidateUtil.setLightStatusBar(getActivity(),false);
    }
}
