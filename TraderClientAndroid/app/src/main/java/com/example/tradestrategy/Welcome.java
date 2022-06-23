package com.example.tradestrategy;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.content.res.TypedArray;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.telephony.TelephonyManager;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.Toast;

import com.example.tradestrategy.bean.CheckinfoData;
import com.example.tradestrategy.bean.FrameAnimation;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.MacAddresUtil;
import com.example.tradestrategy.http.OkGoUpdateHttpUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.meun.MainMeun;
import com.google.gson.Gson;
import com.vector.update_app.UpdateAppBean;
import com.vector.update_app.UpdateAppManager;
import com.vector.update_app.UpdateCallback;
import com.vector.update_app.utils.AppUpdateUtils;
import com.wang.avi.AVLoadingIndicatorView;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Objects;

import okhttp3.Call;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Welcome extends AppCompatActivity {
    private static SharedPreferences.Editor editor;
    private String activationcode;
    private ImageView welcome_img;
    private CheckinfoData checkinfoData;
    private FrameAnimation frameAnimation;
    private int Flag = 0;  //判断是否滑到顶端
    private AVLoadingIndicatorView welcome_avliv;
    private int last_top = 0;

    @SuppressLint("CommitPrefEdits")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.welcome);

        // getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_FULLSCREEN | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
        // getSupportActionBar().hide();


        new Thread(new Runnable() {
            @Override
            public void run() {
                checkupdate();
            }
        }).start();


        if (ValidateUtil.hasNotchInScreen(this)) {
            setStatusBar();
            //   Log.e("1111","走的上面");
        } else {
            //  Log.e("1111","走的下面");
            getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        }

        SharedPreferences codeSettings = getSharedPreferences("ActivationCode", 0);
        activationcode = codeSettings.getString("ActivationCode", "");
        editor = codeSettings.edit();


        // Log.e("新的mac地址：",""+macAddresUtil.getUniqueID());

        initView();
        getPermission();
//        initData();
    }


    private void initView() {
        welcome_img = findViewById(R.id.welcome_img);
        welcome_avliv = findViewById(R.id.welcome_avliv);
    }

    @SuppressLint("ClickableViewAccessibility")
    private void initData() {

        welcome_img.setOnTouchListener(shopCarSettleTouch);

        frameAnimation = new FrameAnimation(welcome_img, getRes(), 50, false);
        frameAnimation.setAnimationListener(new FrameAnimation.AnimationListener() {
            @Override
            public void onAnimationStart() {
                Log.e("onAnimationStart()", "开始");
            }

            @Override
            public void onAnimationEnd() {
              /*  Log.e("onAnimationEnd()","结束");
                //申请调用相册权限
                if (Build.VERSION.SDK_INT >= 23){
                    if(requestPermission()){
                        Timer timer = new Timer();
                        timer.schedule(new LoadPage.Task(),2000);
                    }else {
                        Intent intent = new Intent(LoadPage.this,MainActivity.class);
                        startActivity(intent);
                    }checkinfoData
                }*/
                welcome_avliv.setVisibility(View.VISIBLE);
                welcome_avliv.show();
                new Thread(new Runnable() {
                    @Override
                    public void run() {
                        Log.e("trader", "thread start checkinfo");
                        checkinfo();
                    }
                }).start();
            }

            @Override
            public void onAnimationRepeat() {
                Log.e("onAnimationRepeat()", "继续");
                //Log.e("1111111","在等Flag");

            }
        });

//        frameAnimation.restartAnimation();

    }

    // 进入内部页面
    private void gotoInnerPage() {
        welcome_avliv.setVisibility(View.VISIBLE);
        welcome_avliv.show();
        if (checkinfoData != null && checkinfoData.isCheck_result()) {
            Intent intent = new Intent(Welcome.this, MainMeun.class);
            startActivity(intent);
            welcome_avliv.hide();
            welcome_avliv.setVisibility(View.GONE);
            finish();
        } else {
            Intent intent = new Intent(Welcome.this, Login.class);
            if (checkinfoData.getErr_msg() != null) {
                Toast.makeText(Welcome.this, checkinfoData.getErr_msg() + "", Toast.LENGTH_SHORT).show();
            }
            startActivity(intent);
            welcome_avliv.hide();
            welcome_avliv.setVisibility(View.GONE);
            finish();
        }


//        if (checkinfoData == null) {
//            Log.e("trader", "checking data");
//        } else {
//            Intent intent = new Intent(Welcome.this, Login.class);
//            if(checkinfoData.getErr_msg()!=null){
//                Toast.makeText(Welcome.this,checkinfoData.getErr_msg()+"",Toast.LENGTH_SHORT).show();
//            }
//            startActivity(intent);
//            welcome_avliv.hide();
//            welcome_avliv.setVisibility(View.GONE);
//            finish();
//        }
    }

    private View.OnTouchListener shopCarSettleTouch = new View.OnTouchListener() {
        int lastX, lastY;

        @SuppressLint("ClickableViewAccessibility")
        @Override
        public boolean onTouch(View v, MotionEvent event) {
            int ea = event.getAction();
            DisplayMetrics dm = getResources().getDisplayMetrics();
            int screenWidth = dm.widthPixels;
//            int screenHeight = dm.heightPixels - 100;//需要减掉图片的高度
            int screenHeight = dm.heightPixels;//需要减掉图片的高度
            switch (ea) {
                case MotionEvent.ACTION_DOWN:
                    lastX = (int) event.getRawX();       //获取触摸事件触摸位置的原始X坐标
                    lastY = (int) event.getRawY();
                    last_top = lastY;
                    Log.e("11111", "lastX is " + lastX);
                    Log.e("11111", "lastY is " + lastY);
                case MotionEvent.ACTION_MOVE:
                    //event.getRawX();获得移动的位置
                    int dx = (int) event.getRawX() - lastX;
                    int dy = (int) event.getRawY() - lastY;
                    int l = v.getLeft() + dx;
                    int b = v.getBottom() + dy;
                    int r = v.getRight() + dx;
                    int t = v.getTop() + dy;

                    //下面判断移动是否超出屏幕
                    if (l < 0) {
                        l = v.getLeft();
                        r = v.getRight();
                    }
                    if (t < 0) {
                        t = 0;
                        b = t + v.getHeight();
                    }
                    if (r > v.getRight()) {
                        l = v.getLeft();
                        r = v.getRight();
                    }

                    if (t > last_top) {
                        t = v.getTop();
                        b = v.getBottom();
                    }
                    v.layout(l, t, r, b);

                    Log.e("111", "onTouch: " + l + "==" + t + "==" + r + "==" + b);
                    lastX = (int) event.getRawX();
                    lastY = (int) event.getRawY();
                    last_top = t;
                    v.postInvalidate();
                    if (t == 0) {
                        Log.e("111", "到顶了");
                        Flag = 1;
                        welcome_avliv.setVisibility(View.VISIBLE);
                        welcome_avliv.show();
                        checkinfo();
//                        if (checkinfoData != null && checkinfoData.isCheck_result()) {
//                            Intent intent = new Intent(Welcome.this, MainActivity.class);
//                            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);  //注意本行的FLAG设置
//                            startActivity(intent);
//                            welcome_avliv.hide();
//                            welcome_avliv.setVisibility(View.GONE);
//                            finish();
//                        } else {
//                            Intent intent = new Intent(Welcome.this, Login.class);
//                            startActivity(intent);
//                            welcome_avliv.hide();
//                            welcome_avliv.setVisibility(View.GONE);
//                            finish();
//                        }
                    }
                    break;
                case MotionEvent.ACTION_UP:
                    break;
            }
            return true;
        }
    };

    // 检查更新
    private void checkupdate() {
        String path = Environment.getExternalStorageDirectory().getAbsolutePath();
        final String version = AppUpdateUtils.getVersionName(this);
        Map<String, String> params = new HashMap<String, String>();
        params.put("access_token", "fromwalletapp");
        params.put("version", version);
        params.put("appname", "trader");
        new UpdateAppManager
                .Builder()
                //必须设置，当前Activity
                .setActivity(this)
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
                            // Log.e("11111111","json is "+json);
                            // Log.e("jsonObject","jsonObject is "+jsonObject);
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
                                        .setConstraint(false)
                                        //设置md5，可以不设置
                                        .setNewMd5(jsonObject.optString("new_md51"));
                            } else {
                                initData();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        return updateAppBean;
                    }
                });
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
        ValidateUtil.setStatusBarLightMode(this, Color.parseColor("#ffffffff"));
        ValidateUtil.setLightStatusBar(this, false);
    }

    private int[] getRes() {
        TypedArray typedArray = getResources().obtainTypedArray(R.array.load_pic);
        int len = typedArray.length();
        int[] resId = new int[len];
        for (int i = 0; i < len; i++) {
            resId[i] = typedArray.getResourceId(i, -1);
        }
        typedArray.recycle();
        return resId;
    }

    // 检查用户数据
    private void checkinfo() {
        String phoneinfo = ValidateUtil.getPhoneInformation();
        String mac = ValidateUtil.getMac(Welcome.this);
        MacAddresUtil macAddresUtil = new MacAddresUtil(this);
        FormBody.Builder builder = new FormBody.Builder();
        builder.add("lastRegisterCode", activationcode);
        builder.add("mac", mac);
        builder.add("pm", phoneinfo);
        builder.add("uid", macAddresUtil.getUniqueID());
        RequestBody formBody = builder.build();
        HttpUtil.sendOkHttpResquest(formBody, HttpUtil.getHttptitle() + "/Checker/authUser", new okhttp3.Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                Log.e("trader", "get checker failed");
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        Toast.makeText(Welcome.this, "网络异常", Toast.LENGTH_SHORT).show();
                    }
                });
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseData = response.body().string();
                Log.e("trader", responseData);
                Gson gson = new Gson();
                checkinfoData = gson.fromJson(responseData, CheckinfoData.class);
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        gotoInnerPage();
                    }
                });
            }
        });

    }
    //读写权限
    public void getPermission(){

        if (Build.VERSION.SDK_INT >= 23) {
            int REQUEST_CODE_CONTACT = 101;
            String[] permissions = {Manifest.permission.WRITE_EXTERNAL_STORAGE};
            //验证是否许可权限
            for (String str : permissions) {
                if (this.checkSelfPermission(str) != PackageManager.PERMISSION_GRANTED) {
                    //申请权限
                    this.requestPermissions(permissions, REQUEST_CODE_CONTACT);
                }
            }
        }


    }


    @Override
    protected void onDestroy() {
        super.onDestroy();
        frameAnimation.release();
        Log.e("111", "onDestroy() ");
    }

}
