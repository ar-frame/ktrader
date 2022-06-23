package com.example.tradestrategy;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;

import com.example.tradestrategy.http.ValidateUtil;

public class UpdataLog extends AppCompatActivity{
    private LinearLayout updatalog_out,updatalog_nodata;
    private RecyclerView updatalog_rv;

    private RelativeLayout updatalog_item;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.updatalog);
        setStatusBar();
       // strategyDataList = getIntent().getParcelableArrayListExtra("exdata");
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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#FFFFFFFF"));
        ValidateUtil.setLightStatusBar(this,true);
    }

    private void initView() {
        updatalog_out = findViewById(R.id.updatalog_out);
        updatalog_nodata = findViewById(R.id.updatalog_nodata);
        updatalog_rv = findViewById(R.id.updatalog_rv);

        updatalog_item = findViewById(R.id.updatalog_item);
    }

    private void initData() {
        updatalog_out.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        finish();
                    }
                }
        );

        updatalog_item.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent intent = new Intent(UpdataLog.this,UpdataLogInfo.class);
                        startActivity(intent);


                    }
                }
        );
    }
}
