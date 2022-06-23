package com.example.tradestrategy.meun;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.MainActivity;
import com.example.tradestrategy.R;
import com.example.tradestrategy.SoftwareInformation;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.shares.bean.SortData;
import com.example.tradestrategy.shares.fragment.SharesFragment;

import org.greenrobot.eventbus.EventBus;

import java.util.Map;

public class MainMeun extends AppCompatActivity implements View.OnClickListener {
    private Fragment  mContent,mainacticity,stockresearch,softwareinformation,shareFragment;
    private FragmentManager fragmentManager;
    private LinearLayout bnav_currency,bnav_report,bnav_oftware_information;
    private ImageView bnav_software_information_img,bnav_currency_img,bnav_report_img,saixuan,search_img;
    private TextView bnav_report_txt,bnav_currency_txt,bnav_software_information_txt,confirm;
    private static boolean isExit = false;
    private DrawerLayout drawerLayout;
    private RelativeLayout bar_shares;
    private String statuscolor="#21212B";
    private boolean statustxt=false;
    private TextView total_sort,time_sort,space_sort,rate_sort;
    private ImageView total_sort_img,time_sort_img,space_sort_img,rate_sort_img;
    private RelativeLayout total,time,space,rate;
    private int TOTALFLAG=0;
    private int TIMEFLAG=0;
    private int RATEFLAG=0;
    private int SPACEFLAG=0;
    private int sort_number=0;
    private Fragment sortFragment;


    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.mainmeun);
        initView();
        initData();
        setStatusBar();

    }
    private void initView() {
        bnav_report=findViewById(R.id.bnav_report);
        bnav_currency=findViewById(R.id.bnav_currency);
        bnav_oftware_information=findViewById(R.id.bnav_oftware_information);
        bnav_report_img=findViewById(R.id.bnav_report_img);
        bnav_currency_img=findViewById(R.id.bnav_currency_img);
        bnav_software_information_img=findViewById(R.id.bnav_software_information_img);
        bnav_report_txt=findViewById(R.id.bnav_report_txt);
        bnav_currency_txt=findViewById(R.id.bnav_currency_txt);
        bnav_software_information_txt=findViewById(R.id.bnav_software_information_txt);
        drawerLayout = findViewById(R.id.draw);
        saixuan=findViewById(R.id.saixuan);
        bar_shares=findViewById(R.id.bar_shares);
        search_img=findViewById(R.id.search_img);
        time_sort=findViewById(R.id.time_sort);
        time_sort_img=findViewById(R.id.time_sort_img);
        total_sort=findViewById(R.id.total_sort);
        total_sort_img=findViewById(R.id.total_sort_img);
        space_sort=findViewById(R.id.space_sort);
        space_sort_img=findViewById(R.id.space_sort_img);
        rate_sort=findViewById(R.id.rate_sort);
        rate_sort_img=findViewById(R.id.rate_sort_img);
        total=findViewById(R.id.total);
        time=findViewById(R.id.time);
        space=findViewById(R.id.space);
        rate=findViewById(R.id.rate);
        confirm=findViewById(R.id.confirm);






        mainacticity=new MainActivity();
        shareFragment=new SharesFragment();
        softwareinformation=new SoftwareInformation();

        fragmentManager=getSupportFragmentManager();
        FragmentTransaction ft=fragmentManager.beginTransaction();
        ft.add(R.id.fragment,mainacticity).commit();
        mContent=mainacticity;

    }

    private void initData() {
        bnav_report.setOnClickListener(this);
        bnav_currency.setOnClickListener(this);
        bnav_oftware_information.setOnClickListener(this);
        saixuan.setOnClickListener(this);
        search_img.setOnClickListener(this);
        total.setOnClickListener(this);
        time.setOnClickListener(this);
        rate.setOnClickListener(this);
        space.setOnClickListener(this);
        confirm.setOnClickListener(this);

    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.bnav_report:
                Toast.makeText(getApplicationContext(), "暂未开放", Toast.LENGTH_SHORT).show();

//                statuscolor="#F7F8FC";
//                statustxt=true;
//                setStatusBar();
//                bar_shares.setVisibility(View.VISIBLE);
//                bnav_report_img.setImageResource(R.mipmap.report_blue);
//                bnav_report_txt.setTextColor(Color.parseColor("#005AFF"));
//                bnav_currency_img.setImageResource(R.mipmap.currency_black);
//                bnav_currency_txt.setTextColor(Color.parseColor("#525265"));
//                bnav_software_information_img.setImageResource(R.mipmap.information_black);
//                bnav_software_information_txt.setTextColor(Color.parseColor("#525265"));
//                switchContent(shareFragment);

                break;
            case R.id.bnav_currency:
                statuscolor="#21212B";
                statustxt=false;
                setStatusBar();
                bar_shares.setVisibility(View.GONE);
                bnav_report_img.setImageResource(R.mipmap.report_black);
                bnav_report_txt.setTextColor(Color.parseColor("#525265"));
                bnav_currency_img.setImageResource(R.mipmap.currency_blue);
                bnav_currency_txt.setTextColor(Color.parseColor("#005AFF"));
                bnav_software_information_img.setImageResource(R.mipmap.information_black);
                bnav_software_information_txt.setTextColor(Color.parseColor("#525265"));
                switchContent(mainacticity);
                break;
            case R.id.bnav_oftware_information:
                statuscolor="#21212B";
                statustxt=false;
                setStatusBar();
                bar_shares.setVisibility(View.GONE);
                bnav_report_img.setImageResource(R.mipmap.report_black);
                bnav_report_txt.setTextColor(Color.parseColor("#525265"));
                bnav_currency_img.setImageResource(R.mipmap.currency_black);
                bnav_currency_txt.setTextColor(Color.parseColor("#525265"));
                bnav_software_information_img.setImageResource(R.mipmap.information_blue);
                bnav_software_information_txt.setTextColor(Color.parseColor("#005AFF"));
                switchContent(softwareinformation);
                break;
            case R.id.saixuan:
                drawerLayout.openDrawer(Gravity.RIGHT);//右侧菜单栏
                break;
            case R.id.search_img:
                Intent intent_search=new Intent(this,StockResearchSearch.class);
                startActivity(intent_search);
                break;
            case R.id.total:
                if (TOTALFLAG==0){
                    total_sort.setTextColor(getResources().getColor(R.color.total_blue));
                    total_sort_img.setImageResource(R.mipmap.icon_zhenxu);
                    space_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    space_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    time_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    time_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    rate_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    rate_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    TIMEFLAG=0;
                    SPACEFLAG=0;
                    RATEFLAG=0;
                    sort_number=0;//综合排序
                    TOTALFLAG=1;
                }else {
                    total_sort_img.setImageResource(R.mipmap.icon_daoxu);
                    TOTALFLAG=0;
                }
                break;
            case R.id.time:
                if (TIMEFLAG==0){
                    time_sort.setTextColor(getResources().getColor(R.color.total_blue));
                    time_sort_img.setImageResource(R.mipmap.icon_zhenxu);
                    space_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    space_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    total_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    total_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    rate_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    rate_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    TOTALFLAG=0;
                    SPACEFLAG=0;
                    RATEFLAG=0;
                    sort_number=1;//时间正序
                    TIMEFLAG=1;
                }else {
                    time_sort_img.setImageResource(R.mipmap.icon_daoxu);
                    TIMEFLAG=0;
                    sort_number=2;//时间倒序
                }
                break;
            case R.id.space:
                if (SPACEFLAG==0){
                    space_sort.setTextColor(getResources().getColor(R.color.total_blue));
                    space_sort_img.setImageResource(R.mipmap.icon_zhenxu);
                    time_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    time_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    total_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    total_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    rate_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    rate_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    TIMEFLAG=0;
                    TOTALFLAG=0;
                    RATEFLAG=0;
                    sort_number=3;//空间正序
                    SPACEFLAG=1;
                }else {
                    space_sort_img.setImageResource(R.mipmap.icon_daoxu);
                    SPACEFLAG=0;
                    sort_number=4;//空间倒序
                }
                break;
            case R.id.rate:
                if (RATEFLAG==0){
                    rate_sort.setTextColor(getResources().getColor(R.color.total_blue));
                    rate_sort_img.setImageResource(R.mipmap.icon_zhenxu);
                    time_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    time_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    total_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    total_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    space_sort.setTextColor(getResources().getColor(R.color.total_txt_hui));
                    space_sort_img.setImageResource(R.mipmap.icon_defaultxu);
                    TIMEFLAG=0;
                    SPACEFLAG=0;
                    TOTALFLAG=0;
                    sort_number=5;//准确率正序
                    RATEFLAG=1;
                }else {
                    rate_sort_img.setImageResource(R.mipmap.icon_daoxu);
                    RATEFLAG=0;
                    sort_number=6;//准确率倒序
                }
                break;
            case R.id.confirm:
                EventBus.getDefault().postSticky(new SortData(sort_number));
                sortFragment=new SharesFragment();
                pageContent(sortFragment);
                drawerLayout.closeDrawer(Gravity.RIGHT);

            break;

        }

    }
    //排序切换
    public void pageContent(Fragment fragment){
            if (mContent==shareFragment){
                FragmentTransaction transaction = fragmentManager.beginTransaction();
                transaction.hide(shareFragment).add(R.id.fragment,fragment).commit();
            }
            mContent=fragment;

    }

    public void switchContent(Fragment to) {
        if (mContent != to) {
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            // 先判断是否被add过
            if (!to.isAdded()) {
                // 隐藏当前的fragment
                transaction.hide(mContent).add(R.id.fragment, to).commit();
            } else {
                transaction.hide(mContent).show(to).commit(); //提交
            }
            mContent = to;
        }
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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor(statuscolor));
        ValidateUtil.setLightStatusBar(this,statustxt);
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            exit();
            return false;
        }
        return super.onKeyDown(keyCode, event);
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
            Toast.makeText(getApplicationContext(), "再按一次退出程序",Toast.LENGTH_SHORT).show();
            // 利用handler延迟发送更改状态信息
            mHandler.sendEmptyMessageDelayed(0, 2000);
        } else {
            //参数用作状态码；根据惯例，非 0 的状态码表示异常终止。
            // Log.e("11111","快结束了");
            finish();
            System.exit(0);
        }
    }

}