package com.example.tradestrategy;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Toast;

public class Searchinfo extends AppCompatActivity implements View.OnClickListener {
    private LinearLayout searchinfo_out;
    private RelativeLayout searchinfo_dataanalysis;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.searchinfo);
        initView();
        initData();
    }

    private void initView() {
        searchinfo_out = findViewById(R.id.searchinfo_out);
        searchinfo_dataanalysis = findViewById(R.id.searchinfo_dataanalysis);
    }

    private void initData() {
        searchinfo_out.setOnClickListener(this);
        searchinfo_dataanalysis.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.searchinfo_out:
                finish();
                break;
            case R.id.searchinfo_dataanalysis:
                Toast.makeText(Searchinfo.this,"数据分析",Toast.LENGTH_SHORT).show();
                break;
        }
    }
}
