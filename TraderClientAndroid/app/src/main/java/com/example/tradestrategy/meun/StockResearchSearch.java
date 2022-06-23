package com.example.tradestrategy.meun;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.Toast;

import com.example.tradestrategy.R;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.shares.bean.SearchHistoryData;
import com.example.tradestrategy.shares.fragment.ShareSearchHistoryFragment;
import com.example.tradestrategy.shares.fragment.SharesFragment;

import org.greenrobot.eventbus.EventBus;
import org.litepal.LitePal;

public class StockResearchSearch extends AppCompatActivity implements View.OnClickListener{
    private ImageView strock_fanhui,strock_clear,confirm_search;
    private EditText edit_stock;
    private FragmentManager fragmentManager;
    private Fragment mContent,shareSearchHistoryFragment,shareFragment;
    private FrameLayout fragment;
    public static boolean isHistorypage=false;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.stock_research_search);
        setStatusBar();
        initView();
        initData();


    }
    private void initView() {
        strock_fanhui=findViewById(R.id.strock_fanhui);
        strock_clear=findViewById(R.id.strock_clear);
        edit_stock=findViewById(R.id.edit_stock);
        fragment=findViewById(R.id.fragment);
        confirm_search=findViewById(R.id.confirm_search);


    }

    private void initData() {
        strock_fanhui.setOnClickListener(this);
        strock_clear.setOnClickListener(this);
        confirm_search.setOnClickListener(this);



        shareSearchHistoryFragment=new ShareSearchHistoryFragment();
        shareFragment=new SharesFragment();

        fragmentManager=getSupportFragmentManager();
        FragmentTransaction ft=fragmentManager.beginTransaction();
        ft.add(R.id.fragment,shareSearchHistoryFragment).commit();
        mContent=shareSearchHistoryFragment;

    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.strock_fanhui:

                if (isHistorypage){
                    switchContent(shareSearchHistoryFragment);
                    isHistorypage=false;
                }else {
                    finish();
                }

                break;
            case R.id.strock_clear:
                edit_stock.setText("");
                break;
            case R.id.confirm_search:
                Log.d("--------------", "onClick: "+edit_stock.getText().toString());
                if (edit_stock.getText().toString().length()>0){

                    SQLiteDatabase db= LitePal.getDatabase();//创建数据库
                    if (db!=null){
                        SearchHistoryData searchHistoryData=new SearchHistoryData();
                        searchHistoryData.setHistorytext(edit_stock.getText().toString());
                        searchHistoryData.save();
                        Toast.makeText(this,"保存"+edit_stock.getText().toString(),Toast.LENGTH_SHORT).show();
                    }

                    switchContent(shareFragment);
                    isHistorypage=true;
                }

                break;
        }
    }

    @Override
    public void onBackPressed() {

        if (isHistorypage){
            switchContent(shareSearchHistoryFragment);
            isHistorypage=false;
        }else {
            super.onBackPressed();
        }
    }

    private void setStatusBar() {
        Window window =getWindow();
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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#fff7f8fc"));
        ValidateUtil.setLightStatusBar(this,true);
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


}
