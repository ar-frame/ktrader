package com.example.tradestrategy;

import android.annotation.SuppressLint;
import android.app.ActivityManager;
import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.content.SharedPreferences;
import android.content.res.TypedArray;
import android.database.Cursor;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.IBinder;
import android.os.Message;
import android.os.Parcelable;
import android.provider.Settings;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.bean.CheckinfoData;
import com.example.tradestrategy.bean.Flagchange;
import com.example.tradestrategy.bean.FrameAnimation;
import com.example.tradestrategy.bean.ResponseObjectData;
import com.example.tradestrategy.bean.Saveset;
import com.example.tradestrategy.bean.SavesetHelper;
import com.example.tradestrategy.bean.SummaryData;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.MacAddresUtil;
import com.example.tradestrategy.http.OkGoUpdateHttpUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.strategy.ResponseListData;
import com.example.tradestrategy.strategy.StrategyDataAdapter;
import com.example.tradestrategy.bean.SigninDialog;
import com.example.tradestrategy.strategy.StrategyData;
import com.example.tradestrategy.variety.Variety;
import com.github.mikephil.charting.components.IMarker;
import com.github.mmin18.widget.RealtimeBlurView;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.vector.update_app.UpdateAppBean;
import com.vector.update_app.UpdateAppManager;
import com.vector.update_app.UpdateCallback;
import com.vector.update_app.utils.AppUpdateUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.lang.reflect.Type;
import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Timer;
import java.util.TimerTask;

import okhttp3.Call;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

import static android.app.Notification.VISIBILITY_SECRET;
import static android.provider.Settings.EXTRA_APP_PACKAGE;
import static com.example.tradestrategy.http.ValidateUtil.runOnUiThread;

public class MainActivity extends Fragment implements View.OnClickListener {
    private RelativeLayout load,main_more,main_noticeset,mainvariety;
    private LinearLayout infomation,zhiyingzhisun,main_tradingtips;
    private static LinearLayout main_nonet,main_nodata,main_tradingtipsnodata,main_tradetips;
    private LinearLayout time;
    private ImageView main_img,main_load;
    private static SigninDialog signinDialog_info,signinDialog_thirdinfo;
    private static TextView tradingtips_time,tradingtips_price,tradingtips_level,tradingtips_direction,unit;
    private static TextView percentconversion,overallprofit,nowprice,allmenu,moremenu,emptymenu,direction;
    private TextView notifylevel,zhisun,kongcang,systemtime,setname,dangqianjiage;
    private static TextView last_time,info_time,info_direction,info_currency,info_variety,info_price,info_level;
    private static  ImageView info_direction_flag;
    private static RecyclerView scheme_rv;
    private TextView main_variety,main_text;
    private static StrategyDataAdapter strategyDataAdapter;
    private static List<StrategyData> strategyDataList ;
    private static List<StrategyData> strategyDataList_ex = new ArrayList<>();
    private static boolean isExit = false;
    private Handler handlers=new Handler();
    private int Flag = 0;//是否有网络
    private int flag=0;//升降序
    private static int flag_notice = 0; //是否是人为操作，开启或关闭通知

    private Timer timer=new Timer();

    private static double unitprice;//单元价格
    private double unitprice_now;
    private String activationcode;
    private static String varietycode;
    private String mac;
    private String notifylevel_str;

    private Saveset defaultset;
    private static SharedPreferences codeSettings;
    private static SharedPreferences.Editor editor;
    private SavesetHelper dbHelper;
    private static Context context;

    private static final String CHANNEL_ID="120";       //通道渠道id
    public static final String  CHANEL_NAME="通知"; //通道渠道名称
    private BindImmediateService mBindService; // 声明一个服务对象
    private RelativeLayout last_kcurve;
    private static DecimalFormat df ;
    private String variety;
    private LinearLayoutManager layoutManager;
    private ImageView blur_data;
    private static TextView blur_txt,item_vip;

    @SuppressLint("CommitPrefEdits")
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view =inflater.inflate(R.layout.mainactivity,container,false);

        setStatusBar();

        variety = getActivity().getIntent().getStringExtra("variety_data");
        codeSettings = getActivity().getSharedPreferences("ActivationCode", 0);
        activationcode = codeSettings.getString("ActivationCode", "");
        varietycode = codeSettings.getString("VarietyCode","12315");
        mac = codeSettings.getString("MacCode", "");
        notifylevel_str = codeSettings.getString("NotifyLevel","0");
        df = new DecimalFormat("#0.00");
        unitprice = Double.parseDouble(codeSettings.getString("unitPrice","100"));
        editor = codeSettings.edit();

        strategyDataList = new ArrayList<>();

        new Thread(new Runnable() {
            @Override
            public void run() {
                checkupdate();
            }
        }).start();

        getTime();

        initView(view);
        initData(view);

      //  stockInit();
        return view;
    }
        
    



    private void initView(View view) {
        //main_noticeset = view.findViewById(R.id.main_noticeset);
        load = view.findViewById(R.id.load);
        //infomation = view.findViewById(R.id.infomation);
        unit = view.findViewById(R.id.unit);
        percentconversion = view.findViewById(R.id.percentconversion);
        overallprofit = view.findViewById(R.id.overallprofit);
        nowprice = view.findViewById(R.id.nowprice);
        allmenu = view.findViewById(R.id.allmenu);
        moremenu = view.findViewById(R.id.moremenu);
        emptymenu = view.findViewById(R.id.emptymenu);
        direction = view.findViewById(R.id.direction);
        notifylevel = view.findViewById(R.id.notifylevel);
        zhisun = view.findViewById(R.id.zhisun);
        kongcang = view.findViewById(R.id.kongcang);
        setname = view.findViewById(R.id.setname);
        scheme_rv = view.findViewById(R.id.scheme_rv);
        main_variety = view.findViewById(R.id.main_variety);
        main_nonet = view.findViewById(R.id.main_nonet);
        mainvariety = view.findViewById(R.id.mainvariety);
        systemtime = view.findViewById(R.id.systemtime);
        dangqianjiage = view.findViewById(R.id.dangqianjiage);
        main_nodata =view.findViewById(R.id.main_nodata);
        tradingtips_time =view.findViewById(R.id.tradingtips_time);
        tradingtips_price = view.findViewById(R.id.tradingtips_price);
        tradingtips_level = view.findViewById(R.id.tradingtips_level);
        tradingtips_direction = view.findViewById(R.id.tradingtips_direction);
        main_more = view.findViewById(R.id.main_more);
        last_time = view.findViewById(R.id.last_time);
        time = view.findViewById(R.id.time);
        main_text = view.findViewById(R.id.main_text);
        main_img = view.findViewById(R.id.main_img);
        main_load = view.findViewById(R.id.main_load);
        main_tradetips = view.findViewById(R.id.main_tradetips);
        last_kcurve = view.findViewById(R.id.last_kcurve);
        zhiyingzhisun=view.findViewById(R.id.zhiyingzhisun);
        main_tradingtips=view.findViewById(R.id.main_tradingtips);
        blur_data=view.findViewById(R.id.blur_data);


        main_tradingtipsnodata = view.findViewById(R.id.main_tradingtipsnodata);
        signinDialog_info = new SigninDialog(getContext(),R.layout.info_item,new int[]{
                R.id.info_time,R.id.info_direction,R.id.info_currency,R.id.info_variety,
                R.id.info_price,R.id.info_level,R.id.info_direction_flag});
        signinDialog_thirdinfo=new SigninDialog(getContext(),R.layout.info_thirditem,new int[]{R.id.item_vip});
    }

    private void initData(View view) {
        load.setOnClickListener(this);
//        infomation.setOnClickListener(this);
        main_more.setOnClickListener(this);
        time.setOnClickListener(this);
//        main_noticeset.setOnClickListener(this);
        mainvariety.setOnClickListener(this);
        //last_kcurve.setOnClickListener(this);
        blur_data.setOnClickListener(this);

        LinearLayoutManager layoutManager=new LinearLayoutManager(getActivity());
        scheme_rv.setLayoutManager(layoutManager);
        RecyclerView.LayoutManager manager=scheme_rv.getLayoutManager();
        for (int i = 0; i <manager.getChildCount()-3 ; i++) {
                View view1=manager.getChildAt(i);


        }

        context = getActivity();

        if(varietycode.equals("12316")){
            main_variety.setText("EOS-USDT");
        }
        else if(varietycode.equals("12317")){
            main_variety.setText("BTC-USDT");
        }
        else if(varietycode.equals("10808")){
            main_variety.setText("LTC-USDT");
        }
        else if(varietycode.equals("10800")){
            main_variety.setText("ETC-USDT");
        }
        else if(varietycode.equals("10802")){
            main_variety.setText("BCH-USDT");
        }
        else if(varietycode.equals("10809")){
            main_variety.setText("GT-USDT");
        }

        dbHelper=new SavesetHelper(getContext());
        Cursor cursor=dbHelper.query("saveset");
        while(cursor.moveToNext()){
            int flag = cursor.getInt(cursor.getColumnIndex("flag"));
            if(flag==1){
                int id= cursor.getInt(cursor.getColumnIndex("id"));
                String name=cursor.getString(cursor.getColumnIndex("name"));
                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                String price = cursor.getString(cursor.getColumnIndex("price"));
                defaultset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
            }
        }
        cursor.close();
        dbHelper.close();

        if(defaultset!=null){
            setname.setText(defaultset.getName());
            dangqianjiage.setText(defaultset.getPrice());
            notifylevel.setText(defaultset.getNotifylevel());
            zhisun.setText(defaultset.getLoss()+"点");
            kongcang.setText(defaultset.getControlamount()+"%");
        }

        if(ValidateUtil.isNetworkAvalible(context)){
            // 创建一个通往立即绑定服务的意图
            Intent mIntent = new Intent(getActivity(), BindImmediateService.class);
            mIntent.putExtra("varietydate",variety);
            getActivity().bindService(mIntent,mFirstConn, Context.BIND_AUTO_CREATE);
        }else {
            main_text.setText("您的网络存在问题！请检查后重新启动程序！");
        }

        final FrameAnimation frameAnimation = new FrameAnimation(main_load, getRes(), 30, true);
        frameAnimation.setAnimationListener(new FrameAnimation.AnimationListener() {
            @Override
            public void onAnimationStart() {
                Log.e("M_onAnimationStart()","开始");
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
                    }
                }*/
            }
            @Override
            public void onAnimationRepeat() {
                Log.e("M_onAnimationRepeat()","继续");
                if(strategyDataList.size()!=0){
                    frameAnimation.release();
                }
            }
        });
       new  Thread (new Runnable(){
           @Override
           public void run() {
               checkinfo();
           }
       }).start();

    }
    //recyclerview显示
    public void recyData(){
        scheme_rv.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(RecyclerView recyclerView, int newState) {
            }
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
            //得到当前显示的最后一个item的view
                View lastChildView = recyclerView.getLayoutManager().getChildAt(recyclerView.getLayoutManager().getChildCount()-1);
            //得到lastChildView的bottom坐标值
                int lastChildBottom = lastChildView.getBottom()+1;
                Log.e("lastChildBottom","lastChildBottom"+lastChildBottom);
            //得到Recyclerview的底部坐标减去底部padding值，也就是显示内容最底部的坐标
                int recyclerBottom = recyclerView.getBottom()-recyclerView.getPaddingBottom();
                Log.e("recyclerBottom","recyclerBottom"+recyclerBottom);

            //通过这个lastChildView得到这个view当前的position值
                int lastPosition = recyclerView.getLayoutManager().getPosition(lastChildView);
                Log.e("lastPosition","lastPosition"+lastPosition);

            //判断lastChildView的bottom值跟recyclerBottom
            //判断lastPosition是不是最后一个position
            //如果两个条件都满足则说明是真正的滑动到了底部

                if(lastChildBottom == recyclerBottom && lastPosition-2 == recyclerView.getLayoutManager().getItemCount()-3 ){
                    Log.e("last","last"+(recyclerView.getLayoutManager().getItemCount()-3));
                    Toast.makeText(getActivity(), "滑动到底了", Toast.LENGTH_SHORT).show();
                    blur_data.setVisibility(View.VISIBLE);
                    blur_txt.setVisibility(View.VISIBLE);
                }
                else if (lastPosition==recyclerView.getLayoutManager().getItemCount()-4){
                    blur_data.setVisibility(View.INVISIBLE);
                    blur_txt.setVisibility(View.INVISIBLE);

                }



            }
        });

    }


    //VIP判断显示
    private void  checkinfo(){
        String phoneinfo=ValidateUtil.getPhoneInformation();
        String mac=ValidateUtil.getMac(getContext());
        MacAddresUtil macAddresUtil=new MacAddresUtil(getContext());
        FormBody.Builder builder=new FormBody.Builder();
        builder.add("lastRegisterCode", activationcode);
        builder.add("mac",mac);
        builder.add("pm",phoneinfo);
        builder.add("uid",macAddresUtil.getPesudoUniqueID());
        RequestBody fromBody=builder.build();
        HttpUtil.sendOkHttpResquest(fromBody,HttpUtil.getHttptitle()+"Checker/authUser",new okhttp3.Callback(){
            @Override
            public void onFailure(Call call, IOException e) {

            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
               final String responseData =response.body().string();
               final Gson gson=new Gson();
               final CheckinfoData checkinfoData=gson.fromJson(responseData,CheckinfoData.class);
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        if (checkinfoData.isCheck_result()&&checkinfoData.getIsvip()==1){
                            zhiyingzhisun.setVisibility(View.GONE);
                            main_tradingtips.setVisibility(View.GONE);
                           // LinearLayoutManager layoutManager=new LinearLayoutManager(getActivity(),LinearLayoutManager.VERTICAL,false){

                            //    @Override
                             //   public boolean canScrollVertically() {
                                   // return false;
                              //  }
                          //  };
                           // scheme_rv.setLayoutManager(layoutManager);
                            last_kcurve.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View v) {
                                    Toast.makeText(getActivity(),"该功能普通用户不能使用",Toast.LENGTH_SHORT).show();
                                }
                            });
                           // recyData();

                            blur_data.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View v) {
                                    signinDialog_thirdinfo.show();
                                }
                            });
                            time.setOnClickListener(null);
                            main_img.setVisibility(View.INVISIBLE);


                        }else {
                            zhiyingzhisun.setVisibility(View.VISIBLE);
                            main_tradingtips.setVisibility(View.VISIBLE);
                            LinearLayoutManager layoutManager=new LinearLayoutManager(getActivity());
                            scheme_rv.setLayoutManager(layoutManager);
                            last_kcurve.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View v) {
                                    Intent intent_last_kcurve = new Intent(getActivity(),KCurve.class);
                                    intent_last_kcurve.putParcelableArrayListExtra("list_data", (ArrayList<? extends Parcelable>)strategyDataList);
                                    startActivity(intent_last_kcurve);

                                }
                            });
                            main_img.setVisibility(View.VISIBLE);
                            blur_data.setVisibility(View.INVISIBLE);


                        }

                    }
                });



            }
        });



    }

    private int[] getRes() {
        TypedArray typedArray = getResources().obtainTypedArray(R.array.mainload_pic);
        int len = typedArray.length();
        int[] resId = new int[len];
        for (int i = 0; i < len; i++) {
            resId[i] = typedArray.getResourceId(i, -1);
        }
        typedArray.recycle();
        return resId;
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

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.load:
                Intent intent_load = new Intent(getActivity(),LoadSet.class);
                startActivityForResult(intent_load,1);
                break;
           // case R.id.infomation:
               // Intent intent_infomation = new Intent(MainActivity.this,SoftwareInformation.class);
               // startActivity(intent_infomation);
               // break;
            case R.id.mainvariety:
                timer.cancel();
                if (mBindService != null) {
                    // 解绑服务。如果先前服务立即绑定，则此时解绑之后自动停止服务
                    getActivity().unbindService(mFirstConn);
                    mBindService = null;
                }
                Flagchange.setFlag(1);
                Intent intent_variety = new Intent(getActivity(), Variety.class);
                startActivity(intent_variety);
                getActivity().finish();
                break;
            case R.id.main_more:
                Intent intent_more = new Intent(getActivity(),MoreEX.class);
                intent_more.putParcelableArrayListExtra("exdata", (ArrayList<? extends Parcelable>)strategyDataList_ex);
                startActivity(intent_more);
                break;
            case R.id.time:
                if(flag==0){
                    //默认顺序(降序)->升序
                    List<StrategyData> list = new ArrayList<>();
                    for(int i=strategyDataList.size();i>0;i--){
                        StrategyData strategyData = strategyDataList.get(i-1);
                        list.add(strategyData);

                    }
                    //strategyDataAdapter.refresh(list);
                    strategyDataAdapter = new StrategyDataAdapter(list);
                    //strategyDataAdapter.setHasStableIds(true);
                    scheme_rv.setAdapter(strategyDataAdapter);
                    main_img.setImageResource(R.drawable.shengxu);
                    strategyDataAdapter.setOnItemClickListener(
                            new StrategyDataAdapter.OnItemClickListener() {
                                @Override
                                public void onItemClick(View view, int Position) {
                                    showinfo(Position);
                                }
                            }
                    );
                    flag=1;
                }else {
                    //升序->降序
                    //strategyDataAdapter.refresh(strategyDataList);
                    strategyDataAdapter = new StrategyDataAdapter(strategyDataList);
                    //strategyDataAdapter.setHasStableIds(true);
                    scheme_rv.setAdapter(strategyDataAdapter);
                    main_img.setImageResource(R.drawable.jiangxu);
                    strategyDataAdapter.setOnItemClickListener(
                            new StrategyDataAdapter.OnItemClickListener() {
                                @Override
                                public void onItemClick(View view, int Position) {
                                   showinfo(Position);
                                }
                            }
                    );

                    flag=0;
                }
                break;
           // case R.id.main_noticeset:
              // checkNotifySetting();

               // break;

        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        if(resultCode==getActivity().RESULT_OK){
            String notifyleveldata =data.getStringExtra("setdata_notifylevel");
            String loss =data.getStringExtra("setdata_loss");
            String controlamount =data.getStringExtra("setdata_controlamount");
            String name = data.getStringExtra("setdata_name");
            String price = data.getStringExtra("setdata_price");
            notifylevel.setText(notifyleveldata);
            zhisun.setText(loss);
            kongcang.setText(controlamount+"%");
            setname.setText(name);
            dangqianjiage.setText(price);
            unitprice_now = Double.parseDouble(price);
            editor.putString("unitPrice", String.valueOf(unitprice_now));
            editor.putString("NotifyLevel",notifyleveldata);
            editor.commit();
            flag_notice=1;
        }
    }

    private static void noticeuser(String s) {
        if(ValidateUtil.isNotificationEnabled(context)){
            NotificationChannel channel = null;
            PendingIntent pendingIntent = PendingIntent.getActivity(context, 0,  new Intent(context, MainActivity.class), 0);
            if(Build.VERSION.SDK_INT>=Build.VERSION_CODES.O){
                //创建 通知通道  channelid和channelname是必须的（自己命名就好）
                channel = new NotificationChannel(CHANNEL_ID, CHANEL_NAME,NotificationManager.IMPORTANCE_HIGH);
                // 设置通知出现时的闪灯（如果 android 设备支持的话）
                channel.enableLights(true);
                channel.setLightColor(Color.RED);
                channel.setLockscreenVisibility(VISIBILITY_SECRET);//设置在锁屏界面上显示这条通知
                // 设置通知出现时的震动（如果 android 设备支持的话）
                channel.setSound(RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION),Notification.AUDIO_ATTRIBUTES_DEFAULT);
                channel.enableVibration(true);
                channel.setVibrationPattern(new long[]{100, 200, 300, 400, 500, 400, 300, 200, 400});
//                channel.enableVibration(true);
//                channel.enableLights(true);
//                channel.setBypassDnd(true);
//                channel.setShowBadge(true);
                channel.enableLights(true);//是否在桌面icon右上角展示小红点
                channel.setLightColor(Color.GREEN);//小红点颜色
                channel.setShowBadge(true); //是否在久按桌面图标时显示此渠道的通知
            }
            Notification notification = null;

            //获取Notification实例   获取Notification实例有很多方法处理    在此我只展示通用的方法（虽然这种方式是属于api16以上，但是已经可以了，毕竟16以下的Android机很少了，如果非要全面兼容可以用）

            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                notification = new Notification.Builder(context, CHANNEL_ID)
                        .setContentTitle("新的交易提示")
                        .setContentText(s)
                        .setContentIntent(pendingIntent)
                        .setWhen(System.currentTimeMillis())
                        .setSmallIcon(R.mipmap.logo)
                        .setColor(Color.parseColor("#FEDA26"))
                        .setShowWhen(true)
                        .setAutoCancel(true) //设置通知是否自动清除
                        //.setNumber(number) //设置通知集合的数量
                        .setVisibility(VISIBILITY_SECRET)//控制通知的显示等级
                        .setNumber(99)
                        .setLargeIcon(BitmapFactory.decodeResource(context.getResources(), R.mipmap.logo))
                        .build();
            }
            else if(Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP){
                notification = new Notification.Builder(context)
                        .setContentTitle("新的交易提示")
                        .setContentText(s)
                        .setContentIntent(pendingIntent)
                        .setSound(RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION),Notification.AUDIO_ATTRIBUTES_DEFAULT)
                        .setWhen(System.currentTimeMillis())
                        .setSmallIcon(R.mipmap.logo)
                        .setColor(Color.parseColor("#FEDA26"))
                        .setVisibility(VISIBILITY_SECRET)           //控制通知的显示等级
                        .setShowWhen(true)
                        .setAutoCancel(true) //设置通知是否自动清除
                        //.setNumber(number) //设置通知集合的数量
                        .setNumber(99)
                        .setLargeIcon(BitmapFactory.decodeResource(context.getResources(), R.mipmap.logo))
                        .build();

                }
            else {
                notification = new Notification.Builder(context)
                        .setContentTitle("新的交易提示")
                        .setContentText(s)
                        .setContentIntent(pendingIntent)
                        .setWhen(System.currentTimeMillis())
                        .setSmallIcon(R.mipmap.logo)
                        .setShowWhen(true)
                        .setAutoCancel(true) //设置通知是否自动清除
                        .setNumber(99) //设置通知集合的数量
                        .setLargeIcon(BitmapFactory.decodeResource(context.getResources(), R.mipmap.logo))
                        .build();
            }
            int notifiId = (int) System.currentTimeMillis();
            //创建一个通知管理器
            NotificationManager  notificationManager= (NotificationManager)context.getSystemService(Context.NOTIFICATION_SERVICE);
            if(Build.VERSION.SDK_INT>=Build.VERSION_CODES.O) {   //8.0
                //发送通知
                notificationManager.createNotificationChannel(channel);
            }
            notificationManager.notify(notifiId,notification);
        }
    }


    private static void showinfo(int position) {
        signinDialog_info.show();
        info_time = signinDialog_info.findViewById(R.id.info_time);
        info_direction = signinDialog_info.findViewById(R.id.info_direction);
        info_currency = signinDialog_info.findViewById(R.id.info_currency);
        info_variety = signinDialog_info.findViewById(R.id.info_variety);
        info_price = signinDialog_info.findViewById(R.id.info_price);
        info_level = signinDialog_info.findViewById(R.id.info_level);
        info_direction_flag =signinDialog_info.findViewById(R.id.info_direction_flag);

        StrategyData strategyData = strategyDataList.get(position);

        info_time.setText(strategyData.getTimedate());
        if(strategyData.getType().equals("sell"))
        {
            info_direction.setText("卖出");
            info_direction.setTextColor(Color.parseColor("#ff29c367"));
        }else {
            info_direction.setText("买入");
            info_direction.setTextColor(Color.RED);
        }

        if(strategyData.getLevel()>0){
            info_direction_flag.setVisibility(View.VISIBLE);
            if(strategyData.getType().equals("sell")){
                info_direction_flag.setImageResource(R.mipmap.sell);
            }else {
                info_direction_flag.setImageResource(R.mipmap.buy);
            }
        }else {
            info_direction_flag.setVisibility(View.INVISIBLE);
        }

        info_level.setText(strategyData.getLevel()+"级");
        info_currency.setText(strategyData.getCurrency()+"");
        info_variety.setText(strategyData.getPair());
        info_price.setText(strategyData.getPrice()+"");
    }


    public void getTime(){
        Timer timer=new Timer();
        TimerTask timerTask=new TimerTask() {
            @Override
            public void run() {
                SimpleDateFormat format=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                final String times=format.format(new Date());
                handlers.post(new Runnable() {
                    @Override
                    public void run() {
                        systemtime.setText(times);
                    }
                });
            }
        };
        timer.schedule(timerTask,0,1000);
    }



   /* @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            exit();
            return false;
        }
        return super.getActivity().onKeyDown(keyCode, event);
    }

    @SuppressLint("HandlerLeak")
    Handler mHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            super.handleMessage(msg);
            isExit = false;
        }
    };

    private void exit() {
        if (!isExit) {
            isExit = true;
            Toast.makeText(getActivity().getApplicationContext(), "再按一次退出程序",Toast.LENGTH_SHORT).show();
            // 利用handler延迟发送更改状态信息
            mHandler.sendEmptyMessageDelayed(0, 2000);
        } else {
            //参数用作状态码；根据惯例，非 0 的状态码表示异常终止。
           // Log.e("11111","快结束了");
            getActivity().finish();
            System.exit(0);
        }
    }*/


    private void checkupdate() {
        String path = Environment.getExternalStorageDirectory().getAbsolutePath();
        final String version = AppUpdateUtils.getVersionName(getContext());
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
                           // Log.e("11111111","json is "+json);
                           // Log.e("jsonObject","jsonObject is "+jsonObject);
                            if(jsonObject.getString("update").equals("Yes"))
                            {
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
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        return updateAppBean;
                    }
                });
    }



    @Override
    public void onDestroy() {
        Log.e("trader","onDestroy()");
        super.onDestroy();
        if (mBindService != null) {
            // 解绑服务。如果先前服务立即绑定，则此时解绑之后自动停止服务
            getActivity().unbindService(mFirstConn);
            mBindService = null;
        }
        dbHelper.close();
        //Log.e("111111111","onDestroy()");
        //unregisterReceiver(msendNoticeReceiver);
    }

    //设置刘海屏：
    private void setStatusBar() {
        Window window = getActivity().getWindow();
        window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
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

    private ServiceConnection mFirstConn = new ServiceConnection() {
        // 获取服务对象时的操作
        public void onServiceConnected(ComponentName name, IBinder service) {
            // 如果服务运行于另外一个进程，则不能直接强制转换类型，
            // 否则会报错“java.lang.ClassCastException: android.os.BinderProxy cannot be cast to...”
            if(variety!=null){
                if(variety.equals("")){
                    variety = codeSettings.getString("VarietyCode","12315");
                }
            }
            mBindService = ((BindImmediateService.LocalBinder) service).getService();
            //Log.d(TAG, "onServiceConnected");
        }

        // 无法获取到服务对象时的操作:Android系统在同service的连接意外丢失时调用这个．
        // 比如当service崩溃了或被强杀了．当客户端解除绑定时，这个方法不会被调用．
        public void onServiceDisconnected(ComponentName name) {
            mBindService = null;
           // Log.d(TAG, "onServiceDisconnected");
        }
    };

    public static class LocalReceiver extends BroadcastReceiver {
        @Override
        public void onReceive(Context context, Intent intent) {
            String mistake_message = intent.getStringExtra("initialnews_login_mistake_message");
            String initialnews_getlist_message = intent.getStringExtra("initialnews_getlist_message");
            String initialnews_getsummary_message = intent.getStringExtra("initialnews_getsummary_message");
            String connecting_nointernet = intent.getStringExtra("connecting_nointernet");

            if (mistake_message != null) {
                if (mistake_message.length() != 0) {
                    Toast.makeText(context, mistake_message + "", Toast.LENGTH_SHORT).show();
                } else {
                    BindImmediateService.refresh("第一次刷新");
                }
            }

            if (connecting_nointernet != null) {
                main_nodata.setVisibility(View.GONE);
                scheme_rv.setVisibility(View.GONE);
                main_nonet.setVisibility(View.VISIBLE);
                main_tradingtipsnodata.setVisibility(View.VISIBLE);
                main_tradetips.setVisibility(View.GONE);
                Toast.makeText(context, "当前网络异常，请检查您的网络状况！", Toast.LENGTH_SHORT).show();
            }

            if (initialnews_getlist_message != null) {
                // Log.e("11111111111","strategyDataList size  is "+strategyDataList.size());
                if (strategyDataList.size() != 0) {
                    main_nodata.setVisibility(View.GONE);
                    scheme_rv.setVisibility(View.VISIBLE);
                    main_nonet.setVisibility(View.GONE);
                    Gson gson = new Gson();
                    Type type = new TypeToken<ResponseListData<StrategyData>>() {}.getType();
                    ResponseListData<StrategyData> responseListData_sd = gson.fromJson(initialnews_getlist_message, type);
                    List<StrategyData> list = responseListData_sd.getData();
                    if (list != null) {
                        double unitprice_now = Double.parseDouble(codeSettings.getString("unitPrice", "100"));
                        if (unitprice_now != unitprice) {
                            //Log.e("11111111","两次价格不一样哦");
                            strategyDataList.clear();
                            strategyDataList.addAll(list);
                            strategyDataAdapter = new StrategyDataAdapter(strategyDataList);
                            scheme_rv.setAdapter(strategyDataAdapter);
                            unitprice = unitprice_now;
                        } else {
                            if (strategyDataList.size() != list.size()) {
                                strategyDataList.clear();
                                strategyDataList.addAll(list);
                                strategyDataAdapter = new StrategyDataAdapter(strategyDataList);
                                scheme_rv.setAdapter(strategyDataAdapter);
                                //strategyDataAdapter.refresh(list);
                                String varietycode_new = codeSettings.getString("VarietyCode", "12315");
                                if (varietycode.equals(varietycode_new)) {
                                    if (flag_notice == 0) {
                                        StrategyData strategyData = strategyDataList.get(strategyDataList.size() - 1);
                                        int levels = Integer.parseInt(codeSettings.getString("NotifyLevel", "0"));
                                        if (strategyData.getLevel() >= levels) {
                                            String price = strategyData.getPrice() + "";
                                            String level = strategyData.getLevel() + "级";
                                            String pair = strategyData.getPair();
                                            String tp;
                                            if (strategyData.getType().equals("sell")) {
                                                tp = "卖出";
                                            } else {
                                                tp = "买入";
                                            }
                                            String notice = "类型：" + pair + "，等级：" + level + "，方向：" + tp + "，价格：" + price;
                                            ///noticeuser(notice);
                                        }
                                    } else {
                                        flag_notice = 0;
                                    }
                                }
                            }
                        }
                    } else {
                        main_nodata.setVisibility(View.VISIBLE);
                        scheme_rv.setVisibility(View.GONE);
                        main_nonet.setVisibility(View.GONE);
                    }
                    main_tradingtipsnodata.setVisibility(View.GONE);
                    main_tradetips.setVisibility(View.VISIBLE);

                    StrategyData strategyData = strategyDataList.get(strategyDataList.size() - 1);
                    tradingtips_time.setText(strategyData.getTimedate());
                    tradingtips_price.setText(strategyData.getPrice() + "");
                    tradingtips_level.setText(strategyData.getLevel() + "级");
                    if (strategyData.getType().equals("sell")) {
                        tradingtips_direction.setText("卖出");
                        tradingtips_direction.setTextColor(Color.parseColor("#ff29c367"));
                    } else {
                        tradingtips_direction.setText("买入");
                        tradingtips_direction.setTextColor(android.graphics.Color.RED);
                    }
                    strategyDataAdapter.setOnItemClickListener(
                            new StrategyDataAdapter.OnItemClickListener() {
                                @Override
                                public void onItemClick(View view, int Position) {
                                showinfo(Position);
                                }
                            }
                    );
                } else {
                    Gson gson = new Gson();
                    Type type = new TypeToken<ResponseListData<StrategyData>>() {}.getType();
                    ResponseListData<StrategyData> responseListData_sd = gson.fromJson(initialnews_getlist_message, type);
                    strategyDataList = responseListData_sd.getData();
                    if (strategyDataList.size() == 0) {
                        main_nodata.setVisibility(View.VISIBLE);
                        main_nonet.setVisibility(View.GONE);
                        scheme_rv.setVisibility(View.GONE);
                    } else {
                        main_nodata.setVisibility(View.GONE);
                        scheme_rv.setVisibility(View.VISIBLE);
                        main_nonet.setVisibility(View.GONE);
                        strategyDataAdapter = new StrategyDataAdapter(strategyDataList);
                        scheme_rv.setAdapter(strategyDataAdapter);
                    }

                    List<StrategyData> list_show = new ArrayList<>();

                    for (int i = 0; i < strategyDataList.size(); i++) {
                        if (strategyDataList.get(i).getLevel() > 0) {
                            StrategyData strategyData = strategyDataList.get(i);
                            list_show.add(strategyData);
                        }
                    }

                    if (list_show.size() != 0) {
                        main_tradingtipsnodata.setVisibility(View.GONE);
                        main_tradetips.setVisibility(View.VISIBLE);

                        strategyDataList_ex.clear();
                        strategyDataList_ex.addAll(list_show);

                        StrategyData strategyData = strategyDataList_ex.get(strategyDataList_ex.size() - 1);
                        tradingtips_time.setText(strategyData.getTimedate());
                        tradingtips_price.setText(strategyData.getPrice() + "");
                        tradingtips_level.setText(strategyData.getLevel() + "级");
                        if (strategyData.getType().equals("sell")) {
                            tradingtips_direction.setText("卖出");
                            tradingtips_direction.setTextColor(Color.parseColor("#ff29c367"));
                        } else {
                            tradingtips_direction.setText("买入");
                            tradingtips_direction.setTextColor(android.graphics.Color.RED);
                        }
                        strategyDataAdapter.setOnItemClickListener(
                                new StrategyDataAdapter.OnItemClickListener() {
                                    @Override
                                    public void onItemClick(View view, int Position) {
                                      showinfo(Position);
                                    }
                                }
                        );
                    } else {
                        main_tradingtipsnodata.setVisibility(View.VISIBLE);
                        main_tradetips.setVisibility(View.GONE);
                    }

                }


            }

            if(initialnews_getsummary_message!= null){
                //Log.e("11111111","getsummary is "+initialnews_getsummary_message);
                Gson gson = new Gson();
                Type type=new TypeToken<ResponseObjectData<SummaryData>>(){}.getType();
                ResponseObjectData<SummaryData> responseObjectData =gson.fromJson(initialnews_getsummary_message,type);
                SummaryData summaryData= responseObjectData.getData();
                unit.setText(df.format(summaryData.getUnit()));
                percentconversion.setText(df.format(Double.parseDouble(summaryData.getTransferRate())));
                overallprofit.setText(df.format(Double.parseDouble(summaryData.getProfit())));
                nowprice.setText(df.format(summaryData.getCprice()));
                allmenu.setText(summaryData.getOrderCount()+"");
                moremenu.setText(summaryData.getOrderBuyCount()+"");
                emptymenu.setText(summaryData.getOrderSellCount()+"");
                direction.setText(summaryData.getSummary());

                SimpleDateFormat format=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                String times=format.format(new Date());
                last_time.setText("最后更新："+times);
            }
        }
    }
}


