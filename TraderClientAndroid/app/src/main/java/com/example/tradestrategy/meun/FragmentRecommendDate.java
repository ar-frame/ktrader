package com.example.tradestrategy.meun;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.os.Bundle;
import android.renderscript.Allocation;
import android.renderscript.Element;
import android.renderscript.RenderScript;
import android.renderscript.ScriptIntrinsicBlur;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.widget.NestedScrollView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewParent;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.example.tradestrategy.R;
import com.example.tradestrategy.bean.CheckinfoData;
import com.example.tradestrategy.bean.StockData;
import com.example.tradestrategy.bean.StockRecycleAdapter;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.http.MacAddresUtil;
import com.example.tradestrategy.http.ValidateUtil;
import com.google.gson.Gson;
import com.vector.update_app.utils.AppUpdateUtils;

import java.io.IOException;
import java.security.interfaces.DSAKey;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

import static com.example.tradestrategy.http.ValidateUtil.runOnUiThread;


public class FragmentRecommendDate extends Fragment  implements View.OnClickListener{
    private TextView history_txt_b,history_txt_a,history_txt_c;
    private LinearLayout stock_detail_a,stock_detail_b,stock_detail_c,ly_blur;
    private ImageView blur_bg;
    private RecyclerView scroll_stock;
    private FrameLayout fl_hide_stock;
    private String version,activationcode;
    private List<StockData> stocklist;
    private  StockRecycleAdapter stockRecycleAdapter;
    private LinearLayoutManager linearLayoutManager;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_stock_date,container,false);
        version = AppUpdateUtils.getVersionName(getContext());

        SharedPreferences codeSettings = getActivity().getSharedPreferences("ActivationCode", 0);
        activationcode = codeSettings.getString("ActivationCode", "");

        initView(view);
        initData(view);
        stocklist=new ArrayList<>();
        stocklist.add(new StockData(""));
        stockRecycleAdapter=new StockRecycleAdapter(stocklist);
        linearLayoutManager=new LinearLayoutManager(getContext());
        scroll_stock.setLayoutManager(linearLayoutManager);
        scroll_stock.setAdapter(stockRecycleAdapter);



    //Bitmap bmp= BitmapFactory.decodeResource(getResources(),R.mipmap.transparent);
      // blurByRenderScript(bmp,12,blur_bg,getContext());
       // blurBitmap(bmp);
      //  showGuideView();
        return view;
    }
    private void initView(View view) {
        history_txt_b=view.findViewById(R.id.history_txt_b);
        history_txt_a=view.findViewById(R.id.history_txt_a);
        history_txt_c=view.findViewById(R.id.history_txt_c);
        stock_detail_b=view.findViewById(R.id.stock_detail_b);
        stock_detail_a=view.findViewById(R.id.stock_detail_a);
        stock_detail_c=view.findViewById(R.id.stock_detail_c);
       // blur_bg=view.findViewById(R.id.blur_bg);
       ly_blur=view.findViewById(R.id.ly_blur);
        scroll_stock=view.findViewById(R.id.scroll_stock);
        fl_hide_stock=view.findViewById(R.id.fl_hide_stock);





    }

    private void initData(View view) {

        new Thread(new Runnable() {
            @Override
            public void run() {
                checkinfo();
            }
        }).start();





    }

    private void  checkinfo(){
        String phoneinfo= ValidateUtil.getPhoneInformation();
        String mac=ValidateUtil.getMac(getContext());
        MacAddresUtil macAddresUtil=new MacAddresUtil(getContext());
        FormBody.Builder builder=new FormBody.Builder();
        builder.add("lastRegisterCode", activationcode);
        builder.add("mac",mac);
        builder.add("pm",phoneinfo);
        builder.add("uid",macAddresUtil.getPesudoUniqueID());
        RequestBody fromBody=builder.build();
        HttpUtil.sendOkHttpResquest(fromBody,HttpUtil.getHttptitle()+"Checker/authUser",new okhttp3.Callback(){
            @Override
            public void onFailure(Call call, IOException e) {

            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String responseData =response.body().string();
                final Gson gson=new Gson();
                final CheckinfoData checkinfoData=gson.fromJson(responseData,CheckinfoData.class);
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        if (checkinfoData.isCheck_result()&&checkinfoData.getIsvip()==0){
                          //  scroll_stock.setNestedScrollingEnabled(true);
                            LinearLayoutManager layoutManager=new LinearLayoutManager(getActivity(),LinearLayoutManager.VERTICAL,false){

                                @Override
                                public boolean canScrollVertically() {
                                    return false;
                                }
                            };
                            scroll_stock.setLayoutManager(layoutManager);
                            fl_hide_stock.setVisibility(View.VISIBLE);
                        }else {
                            LinearLayoutManager layoutManager=new LinearLayoutManager(getActivity());
                            scroll_stock.setLayoutManager(layoutManager);


                        }

                    }
                });



            }
        });



    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.history_txt_b:
                Intent intent_history_b=new Intent(getActivity(),StockHistory.class);
                startActivity(intent_history_b);
                break;
            case R.id.history_txt_a:
                Intent intent_history_a=new Intent(getActivity(),StockHistory.class);
                startActivity(intent_history_a);
                break;
            case R.id.history_txt_c:
                Intent intent_history_c=new Intent(getActivity(),StockHistory.class);
                startActivity(intent_history_c);
                break;
            case R.id.stock_detail_b:
                Intent intent_stock_detail_b=new Intent(getActivity(),StockDetail.class);
                startActivity(intent_stock_detail_b);
                break;
            case R.id.stock_detail_a:
                Intent intent_stock_detail_a=new Intent(getActivity(),StockDetail.class);
                startActivity(intent_stock_detail_a);
                break;
            case R.id.stock_detail_c:
                Intent intent_stock_detail_c=new Intent(getActivity(),StockDetail.class);
                startActivity(intent_stock_detail_c);
                break;


        }

    }

    public static void blurByRenderScript(Bitmap bitmap, int radius, ImageView img, Context context) {
        //初始化ReaderScript类
        RenderScript rs = RenderScript.create(context);
        //创建Allocation对象，此类是传递给RenderScript内核的主要方法
        Allocation allocation = Allocation.createFromBitmap(rs, bitmap);
        //创建高斯模糊对象
        ScriptIntrinsicBlur blur = ScriptIntrinsicBlur.create(rs, allocation.getElement());
        //设置blur对象输入内存中
        blur.setInput(allocation);
        //设置渲染模糊程度0~25f
        blur.setRadius(radius);
        //将数据保存到输出内存中
        blur.forEach(allocation);
        //将数据填充进Allocation
        allocation.copyTo(bitmap);
        img.setImageBitmap(bitmap);

        rs.destroy();
    }
    public void showGuideView() {

        View view = getActivity().getWindow().getDecorView().findViewById(R.id.rl_blur);
        if (view == null) return;

        ViewParent viewParent = view.getParent();
        if (viewParent instanceof RelativeLayout) {
            final RelativeLayout relativeLayout = (RelativeLayout) viewParent;//整个父布局

            final LinearLayout linearLayout = new LinearLayout(getContext());//新建一个LinearLayout
            linearLayout.setLayoutParams(new LinearLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT));
            linearLayout.setOrientation(LinearLayout.VERTICAL);
            linearLayout.setBackgroundColor(Color.parseColor("#fffffffff"));//背景设置灰色透明
            linearLayout.setGravity(Gravity.CENTER_HORIZONTAL);
            relativeLayout.addView(linearLayout);
        }
    }
}
