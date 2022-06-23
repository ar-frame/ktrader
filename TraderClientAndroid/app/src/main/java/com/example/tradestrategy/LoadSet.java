package com.example.tradestrategy;

import android.content.ContentValues;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.bean.Saveset;
import com.example.tradestrategy.bean.SavesetAdapter;
import com.example.tradestrategy.bean.SavesetHelper;
import com.example.tradestrategy.http.ValidateUtil;

import java.util.ArrayList;
import java.util.List;

public class LoadSet extends AppCompatActivity implements View.OnClickListener {
    private RecyclerView loadset_rv;
    private RelativeLayout loadset_out,loadset_add;
    private List<Saveset> savesetList = new ArrayList<>();
    private LinearLayout loadset_nodata;
    private SavesetAdapter savesetAdapter;
    private Saveset saveset;
    private TextView nodata_text;
    private PopupWindow mPopupWindow;
    private WindowManager.LayoutParams lp;
    private int position;
   // private int i;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.loadset);

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
        loadset_rv = findViewById(R.id.loadset_rv);
        loadset_out = findViewById(R.id.loadset_out);
        loadset_add = findViewById(R.id.loadset_add);
        loadset_nodata = findViewById(R.id.loadset_nodata);
        nodata_text = findViewById(R.id.nodata_text);
    }

    private void initData() {
        loadset_out.setOnClickListener(this);
        loadset_add.setOnClickListener(this);

        lp= getWindow().getAttributes();

        nodata_text.setText("您还没有设置，点击右上角添加");
        LinearLayoutManager linearLayoutManager=new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false);
        loadset_rv.setLayoutManager(linearLayoutManager);

        SavesetHelper dbHelper=new SavesetHelper(this);
        Cursor cursor=dbHelper.query("saveset");
        while(cursor.moveToNext()){
            int id= cursor.getInt(cursor.getColumnIndex("id"));
            String name=cursor.getString(cursor.getColumnIndex("name"));
            String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
            String loss=cursor.getString(cursor.getColumnIndex("loss"));
            String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
            String price = cursor.getString(cursor.getColumnIndex("price"));
            int flag = cursor.getInt(cursor.getColumnIndex("flag"));
            Saveset saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
            savesetList.add(saveset);
        }
        cursor.close();
        dbHelper.close();
        //准备适配器中数据
        if(savesetList.size()==0){
            loadset_nodata.setVisibility(View.VISIBLE);
            loadset_rv.setVisibility(View.INVISIBLE);
        }else {
            loadset_nodata.setVisibility(View.INVISIBLE);
            loadset_rv.setVisibility(View.VISIBLE);
            savesetAdapter = new SavesetAdapter(savesetList);
            loadset_rv.setAdapter(savesetAdapter);

            savesetAdapter.setOnItemClickListener(
                    new SavesetAdapter.OnItemClickListener() {
                        @Override
                        public void onItemClick(View view,int Position) {
                            //将选中的项目保存下来，修改flag为1，然后将信息传递给主界面
                            SavesetHelper dbHelper=new SavesetHelper(LoadSet.this);
                            Cursor cursor=dbHelper.query("saveset");
                            while(cursor.moveToNext()){
                                int id= cursor.getInt(cursor.getColumnIndex("id"));
                                String name=cursor.getString(cursor.getColumnIndex("name"));
                                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                                String price = cursor.getString(cursor.getColumnIndex("price"));
                                int flag = cursor.getInt(cursor.getColumnIndex("flag"));
                                if(flag==1){
                                    saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
                                }
                            }
                            cursor.close();

                            ContentValues values=new ContentValues();
                            if(saveset!=null){
                                values.put("flag",0);
                                dbHelper.update("saveset",values,"id=?",saveset.getId());
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",Position+1);
                            }else {
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",Position+1);
                            }

                            dbHelper.close();

                            Intent intent = new Intent();
                            intent.putExtra("setdata_notifylevel",savesetList.get(Position).getNotifylevel());
                            intent.putExtra("setdata_loss", savesetList.get(Position).getLoss());
                            intent.putExtra("setdata_controlamount", savesetList.get(Position).getControlamount());
                            intent.putExtra("setdata_name", savesetList.get(Position).getName());
                            intent.putExtra("setdata_price", savesetList.get(Position).getPrice());
                            setResult(RESULT_OK,intent);
                            finish();
                        }
                    }
            );

            savesetAdapter.setOnItemLongClickListener(
                    new SavesetAdapter.OnItemLongClickListener() {
                        @Override
                        public void onItemLongClick(View view, int Position) {
                            initPopuptWindow();
                            position  = Position;
                        }
                    }
            );

        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.loadset_out:
                finish();
                break;
            case R.id.loadset_add:
                Intent intent_add = new Intent(LoadSet.this,Addload.class);
                startActivityForResult(intent_add,1);
                break;
            case R.id.loadset_item_edit:
             //   Toast.makeText(LoadSet.this,"你点击了 编辑",Toast.LENGTH_SHORT).show();
                lp.alpha=1f;
                getWindow().setAttributes(lp);
                mPopupWindow.dismiss();
                editdate_info();
                break;
            case R.id.loadset_item_delete:
              //  Toast.makeText(LoadSet.this,"你点击了 删除",Toast.LENGTH_SHORT).show();
                lp.alpha=1f;
                getWindow().setAttributes(lp);
                mPopupWindow.dismiss();
                deletedate_info();
                break;
            case R.id.loadset_item_cancel:
                lp.alpha=1f;
                getWindow().setAttributes(lp);
                mPopupWindow.dismiss();
                break;
        }
    }

    private void editdate_info() {
        Intent intent = new Intent(LoadSet.this,Addload.class);
        Saveset saveset = savesetList.get(position);
        intent.putExtra("reset_data",saveset);
        startActivityForResult(intent,2);
    }

    private void deletedate_info() {
        Saveset saveset_flag=null;
        SavesetHelper dbHelper=new SavesetHelper(this);
        Cursor cursor=dbHelper.query("saveset");
        while(cursor.moveToNext()){
            int id= cursor.getInt(cursor.getColumnIndex("id"));
            String name=cursor.getString(cursor.getColumnIndex("name"));
            String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
            String loss=cursor.getString(cursor.getColumnIndex("loss"));
            String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
            String price = cursor.getString(cursor.getColumnIndex("price"));
            int flag = cursor.getInt(cursor.getColumnIndex("flag"));
            if(flag==1){
                saveset_flag = new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
            }
        }
        cursor.close();

        if(saveset_flag!=null) {
            if (saveset_flag.getId() == savesetList.get(position).getId()) {
                Toast.makeText(LoadSet.this, "该设置为默认方案，请先更改默认设置！", Toast.LENGTH_SHORT).show();
            } else {
                dbHelper.delete(savesetList.get(position).getId(),"saveset");
                savesetList.remove(position);
                savesetAdapter.refresh(savesetList);
            }
        }else {
            dbHelper.delete(savesetList.get(position).getId(),"saveset");
            savesetList.remove(position);
            savesetAdapter.refresh(savesetList);
            if(savesetList.size()==0)
            {
                loadset_nodata.setVisibility(View.VISIBLE);
                loadset_rv.setVisibility(View.INVISIBLE);
            }
        }
        dbHelper.close();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode==1&&resultCode==RESULT_OK){
            //新增数据
            savesetList.clear();
            SavesetHelper dbHelper=new SavesetHelper(this);
            Cursor cursor=dbHelper.query("saveset");
            while(cursor.moveToNext()){
                int id= cursor.getInt(cursor.getColumnIndex("id"));
                String name=cursor.getString(cursor.getColumnIndex("name"));
                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                String price = cursor.getString(cursor.getColumnIndex("price"));
                int flag = cursor.getInt(cursor.getColumnIndex("flag"));
                Saveset saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
                savesetList.add(saveset);
            }
            cursor.close();
            dbHelper.close();
            //准备适配器中数据
            if(savesetList.size()==0){
                loadset_nodata.setVisibility(View.VISIBLE);
                loadset_rv.setVisibility(View.INVISIBLE);
            }else {
                loadset_nodata.setVisibility(View.INVISIBLE);
                loadset_rv.setVisibility(View.VISIBLE);
                savesetAdapter = new SavesetAdapter(savesetList);
                loadset_rv.setAdapter(savesetAdapter);
            }

            savesetAdapter.setOnItemClickListener(
                    new SavesetAdapter.OnItemClickListener() {
                        @Override
                        public void onItemClick(View view,int Position) {
                            //将选中的项目保存下来，修改flag为1，然后将信息传递给主界面
                            SavesetHelper dbHelper=new SavesetHelper(LoadSet.this);
                            Cursor cursor=dbHelper.query("saveset");
                            while(cursor.moveToNext()){
                                int id= cursor.getInt(cursor.getColumnIndex("id"));
                                String name=cursor.getString(cursor.getColumnIndex("name"));
                                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                                String price = cursor.getString(cursor.getColumnIndex("price"));
                                int flag = cursor.getInt(cursor.getColumnIndex("flag"));
                                if(flag==1){
                                    saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
                                }
                            }
                            cursor.close();

                            ContentValues values=new ContentValues();
                            if(saveset!=null){
                               // Log.e("我走的上面","id is "+saveset.getId()+" position is "+Position);
                                values.put("flag",0);
                                dbHelper.update("saveset",values,"id=?",saveset.getId());
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",savesetList.get(Position).getId());
                            }else {
                               // Log.e("我走的下面"," position is "+Position);
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",Position+1);
                            }

                            dbHelper.close();

                            Intent intent = new Intent();
                            intent.putExtra("setdata_notifylevel",savesetList.get(Position).getNotifylevel());
                            intent.putExtra("setdata_loss", savesetList.get(Position).getLoss());
                            intent.putExtra("setdata_controlamount", savesetList.get(Position).getControlamount());
                            intent.putExtra("setdata_name", savesetList.get(Position).getName());
                            intent.putExtra("setdata_price", savesetList.get(Position).getPrice());
                            setResult(RESULT_OK,intent);
                            finish();
                        }
                    }
            );

            savesetAdapter.setOnItemLongClickListener(
                    new SavesetAdapter.OnItemLongClickListener() {
                        @Override
                        public void onItemLongClick(View view, int Position) {
                            initPopuptWindow();
                            position  = Position;
                        }
                    }
            );

        }
        else if(requestCode==2&&resultCode==RESULT_OK)
        {
            //修改数据信息
            savesetList.clear();
            SavesetHelper dbHelper=new SavesetHelper(this);
            Cursor cursor=dbHelper.query("saveset");
            while(cursor.moveToNext()){
                int id= cursor.getInt(cursor.getColumnIndex("id"));
                String name=cursor.getString(cursor.getColumnIndex("name"));
                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                String price = cursor.getString(cursor.getColumnIndex("price"));
                int flag = cursor.getInt(cursor.getColumnIndex("flag"));
                Saveset saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
                savesetList.add(saveset);
            }
            cursor.close();
            dbHelper.close();
            //准备适配器中数据
            loadset_nodata.setVisibility(View.INVISIBLE);
            loadset_rv.setVisibility(View.VISIBLE);
            savesetAdapter = new SavesetAdapter(savesetList);
            loadset_rv.setAdapter(savesetAdapter);

            savesetAdapter.setOnItemClickListener(
                    new SavesetAdapter.OnItemClickListener() {
                        @Override
                        public void onItemClick(View view,int Position) {
                            //将选中的项目保存下来，修改flag为1，然后将信息传递给主界面
                            SavesetHelper dbHelper=new SavesetHelper(LoadSet.this);
                            Cursor cursor=dbHelper.query("saveset");
                            while(cursor.moveToNext()){
                                int id= cursor.getInt(cursor.getColumnIndex("id"));
                                String name=cursor.getString(cursor.getColumnIndex("name"));
                                String notifylevel=cursor.getString(cursor.getColumnIndex("notifylevel"));
                                String loss=cursor.getString(cursor.getColumnIndex("loss"));
                                String controlamount=cursor.getString(cursor.getColumnIndex("controlamount"));
                                String price = cursor.getString(cursor.getColumnIndex("price"));
                                int flag = cursor.getInt(cursor.getColumnIndex("flag"));
                                if(flag==1){
                                    saveset =new Saveset(id,name,notifylevel,loss,controlamount,price,flag);
                                }
                            }
                            cursor.close();

                            ContentValues values=new ContentValues();
                            if(saveset!=null){
                                // Log.e("我走的上面","id is "+saveset.getId()+" position is "+Position);
                                values.put("flag",0);
                                dbHelper.update("saveset",values,"id=?",saveset.getId());
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",savesetList.get(Position).getId());
                            }else {
                                // Log.e("我走的下面"," position is "+Position);
                                values.put("flag",1);
                                dbHelper.update("saveset",values,"id=?",Position+1);
                            }

                            dbHelper.close();

                            Intent intent = new Intent();
                            intent.putExtra("setdata_notifylevel",savesetList.get(Position).getNotifylevel());
                            intent.putExtra("setdata_loss", savesetList.get(Position).getLoss());
                            intent.putExtra("setdata_controlamount", savesetList.get(Position).getControlamount());
                            intent.putExtra("setdata_name", savesetList.get(Position).getName());
                            intent.putExtra("setdata_price", savesetList.get(Position).getPrice());
                            setResult(RESULT_OK,intent);
                            finish();
                        }
                    }
            );

            savesetAdapter.setOnItemLongClickListener(
                    new SavesetAdapter.OnItemLongClickListener() {
                        @Override
                        public void onItemLongClick(View view, int Position) {
                            initPopuptWindow();
                            position  = Position;
                        }
                    }
            );
        }
    }

    private void initPopuptWindow() {
        LayoutInflater layoutInflater = LayoutInflater.from(this);
        //user_icon替换成你自己的layout
        View popupWindow = layoutInflater.inflate(R.layout.loadset_item, null);

        mPopupWindow = new PopupWindow(popupWindow, LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.WRAP_CONTENT,false);

        LinearLayout loadset_item_edit = popupWindow.findViewById(R.id.loadset_item_edit);
        LinearLayout loadset_item_delete = popupWindow.findViewById(R.id.loadset_item_delete);
        LinearLayout loadset_item_cancel = popupWindow.findViewById(R.id.loadset_item_cancel);

        loadset_item_edit.setOnClickListener(this);
        loadset_item_delete.setOnClickListener(this);
        loadset_item_cancel.setOnClickListener(this);

        //点击外部区域是否可以取消PopupWindow
       // mPopupWindow.setOutsideTouchable(false);

        lp.alpha=0.3f;
        getWindow().setAttributes(lp);
        mPopupWindow.showAtLocation(popupWindow, Gravity.BOTTOM, 0, 0);
    }
}
