package com.example.tradestrategy.variety;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.MainActivity;
import com.example.tradestrategy.R;
import com.example.tradestrategy.bean.Flagchange;
import com.example.tradestrategy.bean.XRadioGroup;
import com.example.tradestrategy.http.ValidateUtil;
import com.example.tradestrategy.meun.MainMeun;
import com.wang.avi.AVLoadingIndicatorView;

public class Variety extends AppCompatActivity implements View.OnClickListener {
    private LinearLayout variety_out,variety_cancel,variety_sure,variety_item;
    private String variety_Name="";
    private XRadioGroup variety_rg;
    private RadioButton btn_eth,btn_eos,btn_btc,btn_ltc,btn_etc,btn_bch,btn_gt,btn_gupiao;
    private int RESULT_VARIETY = 2;
    private String varietycode;
    private static SharedPreferences.Editor editor;
    private static AVLoadingIndicatorView avliv;
    private String variety="";


    @SuppressLint("CommitPrefEdits")
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.variety);

        SharedPreferences codeSettings = getSharedPreferences("ActivationCode", 0);
        varietycode = codeSettings.getString("VarietyCode","");
        editor = codeSettings.edit();
        setStatusBar();

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
        ValidateUtil.setStatusBarLightMode(this,Color.parseColor("#ffffffff"));
        ValidateUtil.setLightStatusBar(this,true);
    }

    private void initView() {
        // variety_rv = findViewById(R.id.variety_rv);
        variety_out = findViewById(R.id.variety_out);
        variety_cancel = findViewById(R.id.variety_cancel);
        variety_sure = findViewById(R.id.variety_sure);
        variety_rg = findViewById(R.id.variety_rg);
        btn_eth = findViewById(R.id.btn_eth);
        btn_eos = findViewById(R.id.btn_eos);
        btn_btc = findViewById(R.id.btn_btc);

        btn_gupiao = findViewById(R.id.btn_gupiao);
        variety_item = findViewById(R.id.variety_item);
        avliv = findViewById(R.id.avliv);
    }

    private void initData() {
        variety_out.setOnClickListener(this);
        variety_cancel.setOnClickListener(this);
        variety_sure.setOnClickListener(this);


        if(varietycode.equals("12315")||varietycode.equals("")){
            btn_eth.setChecked(true);
        }
        else if(varietycode.equals("12316")){
            btn_eos.setChecked(true);
        }
        else if(varietycode.equals("12317")){
            btn_btc.setChecked(true);
        }
        else if(varietycode.equals("10808")){
            btn_ltc.setChecked(true);
        }
        else if(varietycode.equals("10800")){
            btn_etc.setChecked(true);
        }
        else if(varietycode.equals("10802")){
            btn_bch.setChecked(true);
        }
        else if(varietycode.equals("10809")){
            btn_gt.setChecked(true);
        }


        variety_rg.setOnCheckedChangeListener(
                new XRadioGroup.OnCheckedChangeListener() {
                    @Override
                    public void onCheckedChanged(XRadioGroup group, int checkedId) {
                        variety_item.setVisibility(View.VISIBLE);
                        // 获取选中的RadioButton的id
                        if(checkedId==R.id.btn_eth){
                            variety_Name = "ETH-USDT";
                        }
                        else if(checkedId==R.id.btn_eos){
                            variety_Name = "EOS-USDT";
                           // Toast.makeText(Variety.this,"eos",Toast.LENGTH_SHORT).show();
                        }
                        else if(checkedId==R.id.btn_btc){
                            variety_Name = "BTC-USDT";
                           // Toast.makeText(Variety.this,"btc",Toast.LENGTH_SHORT).show();
                        }

                        else if(checkedId==R.id.btn_gupiao){
                            variety_Name = "股票";
                            Toast.makeText(Variety.this,"暂未开放",Toast.LENGTH_SHORT).show();
                        }
                    }
                }
        );
    }



    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.variety_out:
                avliv.setVisibility(View.VISIBLE);
                avliv.show();
                new Handler().postDelayed(new Runnable(){
                    public void run() {
                        Intent intent_out = new Intent(Variety.this, MainMeun.class);
                        startActivity(intent_out);
                        avliv.hide();
                        avliv.setVisibility(View.GONE);
                        Flagchange.setFlag(0);
                        finish();
                    }}, 1500);
                break;
            case R.id.variety_cancel:
                //Toast.makeText(Variety.this,"取消",Toast.LENGTH_SHORT).show();
                variety_item.setVisibility(View.INVISIBLE);
                break;
            case R.id.variety_sure:
                avliv.setVisibility(View.VISIBLE);
                avliv.show();

                //Toast.makeText(Variety.this,"确定",Toast.LENGTH_SHORT).show();
                if(variety_Name.equals("")){
                    Intent intent = new Intent(Variety.this,MainMeun.class);
                    intent.putExtra("variety_data",variety);
                    startActivity(intent);
                    finish();
                }else {
                    if(variety_Name.equals("股票")){
                        Toast.makeText(Variety.this,"此功能即将开放，敬请期待！",Toast.LENGTH_SHORT).show();
                    }else {
                        //Toast.makeText(MainActivity.this,"此功能即将开放！",Toast.LENGTH_SHORT).show();
                        if(variety_Name.equals("ETH-USDT"))
                        {
                            editor.putString("VarietyCode","12315");
                            variety = "12315";
                            editor.commit();
                        }
                        else if(variety_Name.equals("EOS-USDT")){
                            editor.putString("VarietyCode","12316");
                            variety = "12316";
                            editor.commit();
                        }
                        else if(variety_Name.equals("BTC-USDT")){
                            editor.putString("VarietyCode","12317");
                            variety = "12317";
                            editor.commit();
                        }
                        else if(variety_Name.equals("LTC-USDT")){
                            editor.putString("VarietyCode","10808");
                            variety = "10808";
                            editor.commit();
                        }
                        else if(variety_Name.equals("ETC-USDT")){
                            editor.putString("VarietyCode","10800");
                            variety = "10800";
                            editor.commit();
                        }
                        else if(variety_Name.equals("BCH-USDT")){
                            editor.putString("VarietyCode","10802");
                            variety = "10802";
                            editor.commit();
                        }
                        else if(variety_Name.equals("GT-USDT")){
                            editor.putString("VarietyCode","10809");
                            variety = "10809";
                            editor.commit();
                        }
                    }
                    new Handler().postDelayed(new Runnable(){
                        public void run() {
                            Intent intent = new Intent(Variety.this,MainMeun.class);
                            intent.putExtra("variety_data",variety);
                            startActivity(intent);
                            avliv.hide();
                            avliv.setVisibility(View.GONE);
                            Flagchange.setFlag(0);
                            finish();
                           // Log.e("11111111111","11111111111111");
                            }}, 1500);
                }
                break;
        }
    }
}
