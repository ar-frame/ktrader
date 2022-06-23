package com.example.tradestrategy;

import android.content.ContentValues;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.example.tradestrategy.bean.Saveset;
import com.example.tradestrategy.bean.SavesetHelper;
import com.example.tradestrategy.http.ValidateUtil;

import java.util.ArrayList;
import java.util.List;

public class Addload extends AppCompatActivity implements View.OnClickListener {
    private RelativeLayout addload_out,addload_question;
    private EditText addload_notifylevel,one,two,yuan,mingchen;
    private LinearLayout addload_cancel,addload_sure;
    private List<EditText> editTextList = new ArrayList<>();
    private SavesetHelper savesetHelper;
    private Saveset re_saveset;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.addload);

        setStatusBar();
        re_saveset = getIntent().getParcelableExtra("reset_data");
        initView();
        initData();
    }

    private void setStatusBar() {
        Window window = getWindow();
        window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
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
        addload_out = findViewById(R.id.addload_out);
        addload_notifylevel = findViewById(R.id.addload_notifylevel);
        one = findViewById(R.id.one);
        two = findViewById(R.id.two);
        yuan = findViewById(R.id.yuan);
        addload_cancel = findViewById(R.id.addload_cancel);
        addload_sure = findViewById(R.id.addload_sure);
        mingchen = findViewById(R.id.mingchen);
        addload_question = findViewById(R.id.addload_question);
    }

    private void initData() {
        addload_out.setOnClickListener(this);
        addload_cancel.setOnClickListener(this);
        addload_sure.setOnClickListener(this);
        addload_question.setOnClickListener(this);

        EditCheck(yuan);
        EditCheck(addload_notifylevel);
        EditCheck(one);
        EditCheck(two);


        if(re_saveset!=null){
            mingchen.setText(re_saveset.getName());
            yuan.setText(re_saveset.getPrice());
            addload_notifylevel.setText(re_saveset.getNotifylevel());
            one.setText(re_saveset.getLoss());
            two.setText(re_saveset.getControlamount());
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.addload_out:
                finish();
                break;
            case R.id.addload_cancel:
                finish();
                break;
            case R.id.addload_sure:
                if(checkinfo()){
                    if(re_saveset!=null){
                        String name = mingchen.getText().toString().trim();
                        String notifylevel = addload_notifylevel.getText().toString().trim();
                        String loss = one.getText().toString().trim();
                        String controlamount= two.getText().toString().trim();
                        String price = yuan.getText().toString().trim();
                        savesetHelper =new SavesetHelper(Addload.this);
                        ContentValues values=new ContentValues();
                        values.put("name",name);
                        values.put("notifylevel",notifylevel);
                        values.put("loss",loss);
                        values.put("controlamount",controlamount);
                        values.put("price",price);
                        savesetHelper.update("saveset",values,"id=?",re_saveset.getId());
                        savesetHelper.close();
                        Toast.makeText(Addload.this,"修改成功",Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent();
                        setResult(RESULT_OK,intent);
                        finish();
                    }else {
                        String name = mingchen.getText().toString().trim();
                        String notifylevel = addload_notifylevel.getText().toString().trim();
                        String loss = one.getText().toString().trim();
                        String controlamount= two.getText().toString().trim();
                        String price = yuan.getText().toString().trim();
                        savesetHelper =new SavesetHelper(Addload.this);
                        ContentValues values=new ContentValues();
                        values.put("name",name);
                        values.put("notifylevel",notifylevel);
                        values.put("loss",loss);
                        values.put("controlamount",controlamount);
                        values.put("price",price);
                        values.put("flag",0);
                        savesetHelper.insert(values,"saveset");
                        savesetHelper.close();
                        Toast.makeText(Addload.this,"保存成功",Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent();
                        setResult(RESULT_OK,intent);
                        finish();
                    }
                }
                break;
            case R.id.addload_question:
                Toast.makeText(Addload.this,"此功能即将开放！",Toast.LENGTH_SHORT).show();
                break;
        }
    }

    private boolean checkinfo() {
        String notifyleveldata =addload_notifylevel.getText().toString().trim();
        String kuidata = one.getText().toString().trim();
        String kongliangdata = two.getText().toString().trim();
        String yuandata = yuan.getText().toString().trim();
        String mingchendata = mingchen.getText().toString().trim();
        if(notifyleveldata.equals(""))
        {
            Toast.makeText(Addload.this,"请输入止盈点数！",Toast.LENGTH_SHORT).show();
            return false;
        }
        else if(kuidata.equals(""))
        {
            Toast.makeText(Addload.this,"请输入止损点数！",Toast.LENGTH_SHORT).show();
            return false;
        }
        else if(kongliangdata.equals(""))
        {
            Toast.makeText(Addload.this,"请输入控量比！",Toast.LENGTH_SHORT).show();
            return false;
        }
        else if(yuandata.equals(""))
        {
            Toast.makeText(Addload.this,"请输入单元价格！",Toast.LENGTH_SHORT).show();
            return false;
        }
        else if(mingchendata.equals(""))
        {
            Toast.makeText(Addload.this,"请输入设置名称！",Toast.LENGTH_SHORT).show();
            return false;
        }
        return true;
    }

    public void EditCheck(final EditText editText){
        editText.addTextChangedListener(
                new TextWatcher() {
                    @Override
                    public void beforeTextChanged(CharSequence s, int start, int count, int after) {

                    }

                    @Override
                    public void onTextChanged(CharSequence s, int start, int before, int count) {

                    }

                    @Override
                    public void afterTextChanged(Editable s) {
                        ValidateUtil.checkFirstZero(s,editText);
                        if(s.toString().length()!=0){
                            editTextList.add(addload_notifylevel);
                            editTextList.add(one);
                            editTextList.add(two);
                            editTextList.add(yuan);
                            editTextList.add(mingchen);
                            ValidateUtil.checkbutton(addload_sure,editTextList);
                        }
                    }
                }
        );
    }
}
