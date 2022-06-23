package com.example.tradestrategy.meun;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.renderscript.Allocation;
import android.renderscript.RenderScript;
import android.renderscript.ScriptIntrinsicBlur;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.example.tradestrategy.R;
import com.example.tradestrategy.http.ValidateUtil;

public class StockResearch extends Fragment implements View.OnClickListener {

    private ImageView recommend_date_img,accuracy_img,profit_space_img,search_img;
    private TextView recommend_date_txt,accuracy_txt,profit_space_txt;
    private RelativeLayout  recommend_date,accuracy,profit_space;
    private Fragment fragment_recommend_date,fragment_accuracy,fragment_profit_space,mContent;
    private FragmentManager fragmentManager;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.stock_research,container,false);


        return view;
    }

    @Override
    public void onActivityCreated(@Nullable Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);

        initView();
        initData();

    }

    private void initView() {
        recommend_date=getActivity().findViewById(R.id.recommend_date);
        recommend_date_img=getActivity().findViewById(R.id.recommend_date_img);
        recommend_date_txt=getActivity().findViewById(R.id.recommend_date_txt);
        accuracy=getActivity().findViewById(R.id.accuracy);
        accuracy_img=getActivity().findViewById(R.id.accuracy_img);
        accuracy_txt=getActivity().findViewById(R.id.accuracy_txt);
        profit_space=getActivity().findViewById(R.id.profit_space);
        profit_space_img=getActivity().findViewById(R.id.profit_space_img);
        profit_space_txt=getActivity().findViewById(R.id.profit_space_txt);
        search_img=getActivity().findViewById(R.id.search_img);



        fragment_recommend_date=new FragmentRecommendDate();
        fragment_accuracy=new FragmentAccuracy();
        fragment_profit_space=new FragmentProfitSpace();


        fragmentManager=getChildFragmentManager();
        FragmentTransaction ft=fragmentManager.beginTransaction();
        ft.add(R.id.fragment_stock,fragment_recommend_date).commit();
        mContent=fragment_recommend_date;


    }

    private void initData() {
        recommend_date.setOnClickListener(this);
        accuracy.setOnClickListener(this);
        profit_space.setOnClickListener(this);
        search_img.setOnClickListener(this);


    }


    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.recommend_date:
                recommend_date_txt.setTextColor(Color.parseColor("#005AFF"));
                recommend_date_img.setImageResource(R.mipmap.arrow_blue);
                accuracy_txt.setTextColor(Color.parseColor("#A3A3B2"));
                accuracy_img.setImageResource(R.mipmap.arrow_grey);
                profit_space_txt.setTextColor(Color.parseColor("#A3A3B2"));
                profit_space_img.setImageResource(R.mipmap.arrow_grey);
                switchContent(fragment_recommend_date);
                break;
            case R.id.accuracy:
                 recommend_date_txt.setTextColor(Color.parseColor("#A3A3B2"));
                  recommend_date_img.setImageResource(R.mipmap.arrow_grey);
                  accuracy_txt.setTextColor(Color.parseColor("#005AFF"));
                  accuracy_img.setImageResource(R.mipmap.arrow_blue);
                  profit_space_txt.setTextColor(Color.parseColor("#A3A3B2"));
                  profit_space_img.setImageResource(R.mipmap.arrow_grey);
                  switchContent(fragment_accuracy);
                break;
            case R.id.profit_space:
                recommend_date_txt.setTextColor(Color.parseColor("#A3A3B2"));
                recommend_date_img.setImageResource(R.mipmap.arrow_grey);
                accuracy_txt.setTextColor(Color.parseColor("#A3A3B2"));
                accuracy_img.setImageResource(R.mipmap.arrow_grey);
                profit_space_txt.setTextColor(Color.parseColor("#005AFF"));
                profit_space_img.setImageResource(R.mipmap.arrow_blue);
                switchContent(fragment_profit_space);
                break;
            case R.id.search_img:
              //  Intent intent_search=new Intent(getActivity(),StockResearchSearch.class);
               // startActivity(intent_search);
                Toast.makeText(getContext(),"此功能即将开放",Toast.LENGTH_SHORT).show();
                break;
        }



    }
    public void switchContent(Fragment to) {
        if (mContent != to) {
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            // 先判断是否被add过
            if (!to.isAdded()) {
                // 隐藏当前的fragment
                transaction.hide(mContent).add(R.id.fragment_stock, to).commit();
            } else {
                transaction.hide(mContent).show(to).commit(); //提交
            }
            mContent = to;
        }
    }


    private void setStatusBar() {
        Window window = getActivity().getWindow();
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
        ValidateUtil.setStatusBarLightMode(getActivity(),Color.parseColor("#21212B"));
        ValidateUtil.setLightStatusBar(getActivity(),true);
    }
}
