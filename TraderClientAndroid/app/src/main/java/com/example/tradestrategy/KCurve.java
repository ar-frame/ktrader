package com.example.tradestrategy;

import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;

import com.example.tradestrategy.bean.ChartUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.strategy.StrategyData;

import com.github.mikephil.charting.charts.CombinedChart;

import java.util.ArrayList;
import java.util.List;

public class KCurve extends AppCompatActivity {
    private List<StrategyData> strategyDataList=new ArrayList<>();
    private CombinedChart chart;
    private LinearLayout kcurve_out;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.kcurve);

        setStatusBar();

        strategyDataList = getIntent().getParcelableArrayListExtra("list_data");

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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#f8f8f8f8"));
        ValidateUtil.setLightStatusBar(this,true);
    }

    private void initView() {
        chart = findViewById(R.id.chart1);
        kcurve_out = findViewById(R.id.kcurve_out);
    }

    private void initData() {

        kcurve_out.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        finish();
                    }
                }
        );

        List<String> xDataList = new ArrayList<>();// x轴数据源
        List<Float> lineDataList = new ArrayList<>();// 线数据数据源
        List<Float> barDataList = new ArrayList<>();// 柱数据数据源

        //Float.parseFloat(strategyDataList.get(1).getPrice())
        for(int i = 0 ;i<strategyDataList.size();i++){
            lineDataList.add(i,Float.parseFloat(String.valueOf(strategyDataList.get(i).getPrice())));
            barDataList.add(i,Float.parseFloat(String.valueOf(strategyDataList.get(i).getCode())));
        }

        ChartUtil.showChart(chart,strategyDataList,lineDataList, barDataList,"价格走势图","能级走势图");
    }


}
