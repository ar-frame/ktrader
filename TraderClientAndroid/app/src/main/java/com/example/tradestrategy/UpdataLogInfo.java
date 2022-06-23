package com.example.tradestrategy;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.meun.MainMeun;
import com.example.tradestrategy.meun.StockDetail;
import com.tencent.smtt.sdk.TbsReaderView;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;

public class UpdataLogInfo extends AppCompatActivity implements TbsReaderView.ReaderCallback {
    private TbsReaderView mTbsReaderView;
    private LinearLayout updataloginfo_out;
    private TextView updataloginfo_name,updataloginfo_time,updataloginfo_content;
    private RelativeLayout rl_log;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.updataloginfo);
        setStatusBar();
        // strategyDataList = getIntent().getParcelableArrayListExtra("exdata");
        mTbsReaderView=new TbsReaderView(this,this);
        rl_log=findViewById(R.id.rl_log);
        rl_log.addView(mTbsReaderView,new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT));

        initView();
        initData();
        displayFile();

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
        updataloginfo_out = findViewById(R.id.updataloginfo_out);
      //  updataloginfo_name = findViewById(R.id.updataloginfo_name);
       // updataloginfo_time =findViewById(R.id.updataloginfo_time);
       // updataloginfo_content = findViewById(R.id.updataloginfo_content);
    }

    private void initData() {
        updataloginfo_out.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        finish();
                    }
                }
        );
    }
    //@Override
    //public void onBackPressed() {
        // super.onBackPressed();
       // startActivity(new Intent(UpdataLogInfo.this, UpdataLog.class));
       // finish();
  //  }

    @Override
    public void onCallBackAction(Integer integer, Object o, Object o1) {

    }

    //本地文件预览
    public void displayFile(){
        Bundle bundle=new Bundle();
        String path="file///android_asset/updatelog.docx";
        //File dataFile=new File(getCacheDir(),"updatelog.docx");
      //  Log.d("88888888888888888","filePath:" + dataFile.getAbsolutePath());
        //InputStream abpath = getClass().getResourceAsStream("/assets/updatelog.docx");
       /// String path= new String(InputStreamToByte(abpath));
        bundle.putString("filePath",path);
        bundle.putString("tempPath", Environment.getExternalStorageDirectory().getPath());
        boolean result=mTbsReaderView.preOpen(parseFormat("updatelog.docx"),false);
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

    private boolean copyAssetAndWrite(String filesName){
        try {
            File cacheDir=getCacheDir();
            if (!cacheDir.exists()){
                cacheDir.mkdirs();
            }
            File outFile =new File(cacheDir,filesName);
            if (!outFile.exists()){
                boolean res=outFile.createNewFile();
                if (!res){
                    return false;
                }
            }else {
                if (outFile.length()>10){//表示已经写入一次
                    return true;
                }
            }
            InputStream is=getAssets().open(filesName);
            FileOutputStream fos = new FileOutputStream(outFile);
            byte[] buffer = new byte[1024];
            int byteCount;
            while ((byteCount = is.read(buffer)) != -1) {
                fos.write(buffer, 0, byteCount);
            }
            fos.flush();
            is.close();
            fos.close();
            return true;
        } catch (IOException e) {
            e.printStackTrace();
        }

        return false;

    }


}
