package com.example.tradestrategy;

import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.example.tradestrategy.bean.MoreExDataAdapter;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.strategy.StrategyData;

import java.util.ArrayList;
import java.util.List;

public class MoreEX extends AppCompatActivity implements View.OnClickListener {
    private LinearLayout moreex_out;
    private RecyclerView moreex_rv;
    private List<StrategyData> strategyDataList=new ArrayList<>();
    private LinearLayout moreex_nodata,moreex_time,moreex_level;
    private MoreExDataAdapter moreExDataAdapter;
    private ImageView moreex_time_img;
    private int Flag_time = 0;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.moreex);

        setStatusBar();
        strategyDataList = getIntent().getParcelableArrayListExtra("exdata");

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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#21212B"));
        ValidateUtil.setLightStatusBar(this,false);
    }

    private void initView() {
        moreex_out = findViewById(R.id.moreex_out);
        moreex_rv = findViewById(R.id.moreex_rv);
        moreex_nodata = findViewById(R.id.moreex_nodata);
        moreex_time = findViewById(R.id.moreex_time);
        moreex_level = findViewById(R.id.moreex_level);
        moreex_time_img = findViewById(R.id.moreex_time_img);

    }

    private void initData() {
        moreex_out.setOnClickListener(this);
        moreex_time.setOnClickListener(this);
        moreex_level.setOnClickListener(this);


        LinearLayoutManager layoutManager=new LinearLayoutManager(MoreEX.this);
        moreex_rv.setLayoutManager(layoutManager);

        if(strategyDataList.size()==0){
            moreex_nodata.setVisibility(View.VISIBLE);
            moreex_rv.setVisibility(View.GONE);
        }else {
            moreex_rv.setVisibility(View.VISIBLE);
            moreex_nodata.setVisibility(View.GONE);

            moreExDataAdapter = new MoreExDataAdapter(strategyDataList);
            moreex_rv.setAdapter(moreExDataAdapter);
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.moreex_out:
                finish();
                break;
            case R.id.moreex_time:
                if(Flag_time==0){
                    //默认顺序->倒序
                    List<StrategyData> list = new ArrayList<>();
                    for(int i=strategyDataList.size();i>0;i--){
                        StrategyData strategyData = strategyDataList.get(i-1);
                        list.add(strategyData);
                    }
                    //strategyDataAdapter.refresh(list);
                    moreExDataAdapter = new MoreExDataAdapter(list);
                    //strategyDataAdapter.setHasStableIds(true);
                    moreex_rv.setAdapter(moreExDataAdapter);
                    moreex_time_img.setImageResource(R.drawable.jiangxu);
                    Flag_time=1;
                }else {
                    //降序->升序
                    //strategyDataAdapter.refresh(strategyDataList);
                    moreExDataAdapter = new MoreExDataAdapter(strategyDataList);
                    //strategyDataAdapter.setHasStableIds(true);
                    moreex_rv.setAdapter(moreExDataAdapter);
                    moreex_time_img.setImageResource(R.drawable.shengxu);
                    Flag_time=0;
                }
                break;
        }
    }
}
