package com.example.tradestrategy.shares.fragment;

import android.accounts.NetworkErrorException;
import android.arch.lifecycle.ViewModelProvider;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.coopcoder.getcoder.Fetch;
import com.coopcoder.getcoder.ServerResponseException;
import com.example.tradestrategy.R;
import com.example.tradestrategy.http.HttpUtil;
import com.example.tradestrategy.shares.activity.SharesDetailActivity;
import com.example.tradestrategy.shares.adapter.SharesListAdapter;
import com.example.tradestrategy.shares.bean.ShareListData;
import com.example.tradestrategy.shares.bean.SharesData;
import com.example.tradestrategy.shares.bean.SortData;
import com.google.gson.Gson;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.google.gson.reflect.TypeToken;

import org.greenrobot.eventbus.EventBus;
import org.greenrobot.eventbus.Subscribe;
import org.greenrobot.eventbus.ThreadMode;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.List;

import static com.example.tradestrategy.http.ValidateUtil.runOnUiThread;

public class SharesFragment extends Fragment {
    private RecyclerView rv_shares;
    private LinearLayoutManager linearLayoutManager;
    private SharesListAdapter sharesListAdapter;
    private LinearLayout progressBar;
    private int sort_id;



    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_shares,container,false);
        initView(view);
        initData();

        return view;
    }
    public void  initView(View view){
        rv_shares=view.findViewById(R.id.rv_shares);
        progressBar=view.findViewById(R.id.progress);


        new Thread(new Runnable() {
            @Override
            public void run() {
                loadSharesData();
            }
        }).start();

    }
    public void initData(){



    }
    @Subscribe(sticky = true,threadMode = ThreadMode.MAIN)
    public void SortNumber(SortData sortData){
        sort_id=sortData.getSortnumber();
        Log.d("-------", "getSortNuber: "+sortData.getSortnumber());

    }


    //rv数据绑定
    public void  loadSharesData(){
        linearLayoutManager=new LinearLayoutManager(getActivity());
        rv_shares.setLayoutManager(linearLayoutManager);

        try {
            Fetch fetch= HttpUtil.getconfig(getContext());
            List<String> params=new ArrayList<>();
            params.add(""+0);
            params.add("");
            params.add(""+30);
            params.add(""+1);

            final JsonObject jsonObject=fetch.getObject("service.ctl.bestplan.user","get_r_shares_list",params);
            Log.e("-------", "loadSharesData: "+jsonObject.toString());
            Gson gson=new Gson();
            final ShareListData sharesDataList=gson.fromJson(jsonObject, ShareListData.class);
            List<SharesData> list=sharesDataList.getData();
            sharesListAdapter=new SharesListAdapter(list,getContext());
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    progressBar.setVisibility(View.GONE);
                    rv_shares.setAdapter(sharesListAdapter);
                    sharesListAdapter.setOnItemClickListener(new SharesListAdapter.OnItemClickListener() {
                        @Override
                        public void onItemClick(View view, int Position) {
                           // Log.d("-----点击------", "onItemClick: "+Position);
                            switch (view.getId()){
                                case R.id.item_shares:
                                    Intent intent_shares_detail=new Intent(getContext(), SharesDetailActivity.class);
                                    startActivity(intent_shares_detail);
                                    break;
                            }
                        }
                    });
                }
            });

        }catch (ServerResponseException |IllegalStateException e){
            e.printStackTrace();
            Log.e("----------", "loadSharesData: "+e.getMessage());
        }


    }

    @Override
    public void onResume() {
        super.onResume();
        EventBus.getDefault().register(this);
        if (sort_id==2){
            Log.e("------sharefragment--", "onResume: " );

        }

    }

    @Override
    public void onPause() {
        super.onPause();
        EventBus.getDefault().unregister(this);
    }
}
