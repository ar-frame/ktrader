package com.example.tradestrategy.shares.activity;

import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.animation.LinearInterpolator;
import android.widget.ImageView;
import android.widget.TextView;

import com.coopcoder.getcoder.Fetch;
import com.coopcoder.getcoder.ServerResponseException;
import com.example.tradestrategy.R;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.shares.adapter.ShareRecommendAdapter;
import com.example.tradestrategy.shares.bean.RecommendInfoData;
import com.example.tradestrategy.shares.bean.RecommendRateData;
import com.example.tradestrategy.shares.bean.ShareRecommendListData;
import com.example.tradestrategy.shares.bean.SharesData;
import com.example.tradestrategy.shares.bean.SharesRecommendData;
import com.google.gson.Gson;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.google.gson.reflect.TypeToken;

import org.greenrobot.eventbus.EventBus;
import org.greenrobot.eventbus.Subscribe;
import org.greenrobot.eventbus.ThreadMode;
import org.json.JSONObject;

import java.sql.Time;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.LinkedBlockingDeque;
import java.util.concurrent.ThreadPoolExecutor;
import java.util.concurrent.TimeUnit;

public class SharesDetailActivity extends AppCompatActivity  implements View.OnClickListener{

    private ImageView xuanzhuan_img,fanhui;
    private ThreadPoolExecutor pool;
    private RecyclerView rv_recommend;
    private ShareRecommendAdapter shareRecommendAdapter;
    private TextView history_number,accuracy,profit,shares_name,shares_code,shares_time,mode,start_price,goal_price;
    private Typeface typeface;
    private int share_id;


    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sharesdetail);
        setStatusBar();
        initView();
        initData();

    }
    private void initView() {
        xuanzhuan_img=findViewById(R.id.xuanzhuan_img);
        fanhui=findViewById(R.id.fanhui);
        rv_recommend=findViewById(R.id.rv_recommend);
        history_number=findViewById(R.id.history_number);
        profit=findViewById(R.id.profit);
        accuracy=findViewById(R.id.accuracy);
        shares_name=findViewById(R.id.shares_name);
        shares_code=findViewById(R.id.shares_code);
        shares_time=findViewById(R.id.shares_time);
        mode=findViewById(R.id.mode);
        start_price=findViewById(R.id.start_price);
        goal_price=findViewById(R.id.goal_price);
        //设置字体样式
        typeface=Typeface.createFromAsset(getAssets(),"MixolydianTitlingRg-Regular.otf");

        Animation animation = AnimationUtils.loadAnimation(this, R.anim.img_animation);
        LinearInterpolator linearInterpolator=new LinearInterpolator();//设置动画匀速运动
        animation.setInterpolator(linearInterpolator);
        xuanzhuan_img.setAnimation(animation);
        pool=new ThreadPoolExecutor(
            3,6,30L, TimeUnit.SECONDS,
                new LinkedBlockingDeque<Runnable>(60)
        );

    }

    private void initData() {
        fanhui.setOnClickListener(this);
        Runnable runnable_history_shares=new Runnable() {
            @Override
            public void run() {
                historyRecommendShares();//历史股票
            }
        };
        pool.execute(runnable_history_shares);
        Runnable runnable_recommend_rate=new Runnable() {
            @Override
            public void run() {
                recommendRate();//推荐率
            }
        };
        pool.execute(runnable_recommend_rate);
        Runnable runnable_recommend_info=new Runnable() {
            @Override
            public void run() {
                getRecommendShares();//推荐中股票
            }
        };
        pool.execute(runnable_recommend_info);


    }
    //推荐中股票
    public void getRecommendShares(){
        try {
            Fetch fetch= HttpUtil.getconfig(getApplicationContext());
            List<String> params=new ArrayList<>();
            params.add(""+share_id);
            JsonObject jsonObject=fetch.getObject("service.ctl.bestplan.user","get_r_shares",params);
           // Log.d("--------------", "getRecommendShares: "+jsonObject.toString());
            Gson gson=new Gson();
            final RecommendInfoData recommendInfoData=gson.fromJson(jsonObject,RecommendInfoData.class);
            if (recommendInfoData.isOpt_result()){
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        shares_name.setText(recommendInfoData.getShares_name());
                        shares_code.setText(""+recommendInfoData.getShares_code());
                        shares_time.setText(recommendInfoData.getShares_time());
                        start_price.setTypeface(typeface);
                        start_price.setText(recommendInfoData.getStart_price());
                        goal_price.setTypeface(typeface);
                        goal_price.setText(recommendInfoData.getGoal_price());
                    }
                });
            }
        }catch (ServerResponseException e){

            e.printStackTrace();
        }


    }
    //准确率及推荐次数
    public void recommendRate(){
        try {
            Fetch fetch=HttpUtil.getconfig(getApplicationContext());
            List<String> params=new ArrayList<>();
            params.add(""+share_id);
            JsonObject jsonObject=fetch.getObject("service.ctl.bestplan.user","get_shares_census",params);
            Gson gson = new Gson();
            final RecommendRateData recommendRateData=gson.fromJson(jsonObject,RecommendRateData.class);
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    accuracy.setTypeface(typeface);
                    accuracy.setText(recommendRateData.getAccuracy());
                    profit.setTypeface(typeface);
                    profit.setText(recommendRateData.getProfit());
                    history_number.setText(recommendRateData.getHistory_number());

                }
            });



        }catch (ServerResponseException e){

        }

    }

    //历史推荐
    public void historyRecommendShares(){
        LinearLayoutManager linearLayoutManager_recommend=new LinearLayoutManager(getApplicationContext());
        rv_recommend.setLayoutManager(linearLayoutManager_recommend);
        try {
            Fetch fetch=HttpUtil.getconfig(getApplicationContext());
            List<String> params=new ArrayList<>();
            params.add(""+share_id);
            JsonObject jsonObject=fetch.getObject("service.ctl.bestplan.user","get_h_shares_list",params);
           // Log.d("----------", "historyRecommendShares: ");
            Gson gson=new Gson();
            ShareRecommendListData sharesRecommendData=gson.fromJson(jsonObject,ShareRecommendListData.class);
            List<SharesRecommendData> sharesRecommendDataList=sharesRecommendData.getData();
            shareRecommendAdapter=new ShareRecommendAdapter(sharesRecommendDataList,getApplicationContext());
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    rv_recommend.setAdapter(shareRecommendAdapter);
                }
            });


        }catch (ServerResponseException e){
            e.printStackTrace();
        }

    }
    @Subscribe(sticky = true, threadMode = ThreadMode.MAIN)
    public void onMessageEvent(SharesData sharesData){
        share_id=sharesData.getShares_id();
        Log.d("---------", "onMessageEvent: "+sharesData.getShares_id());
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.fanhui:
                finish();
                break;
        }
    }

    @Override
    protected void onStart() {
        super.onStart();
        EventBus.getDefault().register(this);
    }

    @Override
    protected void onStop() {
        super.onStop();

    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        EventBus.getDefault().unregister(this);
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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#F7F8FC"));
        ValidateUtil.setLightStatusBar(this,true);
    }
}
