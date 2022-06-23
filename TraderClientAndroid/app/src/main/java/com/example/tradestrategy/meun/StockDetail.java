package com.example.tradestrategy.meun;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.RelativeLayout;

import com.example.tradestrategy.R;
import com.example.tradestrategy.http.ValidateUtil;
import com.tencent.smtt.sdk.TbsReaderView;

public class StockDetail extends AppCompatActivity  implements View.OnClickListener, TbsReaderView.ReaderCallback {

    private ImageView detail_fanhui;
    private RelativeLayout rl_root;
    private TbsReaderView  mTbsReaderView;
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.stock_detail);
        mTbsReaderView=new TbsReaderView(this,this);
        rl_root=findViewById(R.id.rl_root);
        rl_root.addView(mTbsReaderView,new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT));

        setStatusBar();
        initView();
        initData();
        displayFile();
    }
    private void initView() {
        detail_fanhui=findViewById(R.id.detail_fanhui);

    }

    private void initData() {
        detail_fanhui.setOnClickListener(this);

    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.detail_fanhui:
                finish();
                break;

        }
    }


    @Override
    public void onCallBackAction(Integer integer, Object o, Object o1) {

    }


    //本地文件预览
    public void displayFile(){
        Bundle bundle=new Bundle();
        bundle.putString("filePath","/storage/emulated/0/汇聚源商城关于试用的BUG问题反馈.docx");
        bundle.putString("tempPath", Environment.getExternalStorageDirectory().getPath());
        boolean result=mTbsReaderView.preOpen(parseFormat("汇聚源商城关于试用的BUG问题反馈.docx"),false);
        if (result){
            mTbsReaderView.openFile(bundle);
        }

    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (mTbsReaderView!=null){
            mTbsReaderView.onStop();
        }
    }
    //文件后缀
    private String parseFormat(String fileName) {
        return fileName.substring(fileName.lastIndexOf(".") + 1);
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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#ffffffff"));
        ValidateUtil.setLightStatusBar(this,true);
    }

}
