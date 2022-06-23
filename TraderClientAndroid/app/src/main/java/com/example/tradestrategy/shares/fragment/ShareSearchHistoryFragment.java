package com.example.tradestrategy.shares.fragment;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.chad.library.adapter.base.BaseQuickAdapter;
import com.example.tradestrategy.R;
import com.example.tradestrategy.bean.SigninDialog;
import com.example.tradestrategy.meun.StockResearchSearch;
import com.example.tradestrategy.shares.adapter.SearchAdapter;
import com.example.tradestrategy.shares.bean.SearchHistoryData;
import com.example.tradestrategy.shares.dialog.ShareHistoryDialog;
import com.google.android.flexbox.FlexboxLayoutManager;

import org.litepal.LitePal;

import java.util.ArrayList;
import java.util.List;

public class ShareSearchHistoryFragment extends Fragment implements View.OnClickListener{
    private SearchAdapter searchAdapter;
   // private GridLayoutManager gridLayoutManager;
    private RecyclerView rv_shares_search_history;
    private List<SearchHistoryData> list=new ArrayList<>();
    private ImageView delete_history_img;
    private ShareHistoryDialog shareHistoryDialog;
    private TextView resetmyname_cancel,resetmyname_srue;
    private Fragment sharesFragment;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_share_searchhistory,container,false);
        initView(view);
        initData();
        return view;
    }

    private void initView(View view) {
        rv_shares_search_history=view.findViewById(R.id.rv_shares_search_history);
        delete_history_img=view.findViewById(R.id.delete_history_img);
        shareHistoryDialog=new ShareHistoryDialog(getContext(),R.layout.dialog_search_history,new int[]{R.id.resetmyname_cancel,R.id.resetmyname_srue});



    }

    private void initData() {
        delete_history_img.setOnClickListener(this);
        shareHistoryDialog.setOnCenterItemClickListener(new ShareHistoryDialog.OnCenterItemClickListener() {
            @Override
            public void OnCenterItemClick(ShareHistoryDialog dialog, View view) {
                switch (view.getId()){
                    case R.id.resetmyname_cancel:
                        shareHistoryDialog.cancel();
                    break;
                }

            }
        });

        loadSearchHistory();

    }
    //加载历史搜索数据

    public void  loadSearchHistory(){

        //gridLayoutManager=new GridLayoutManager(getActivity(),3);
        rv_shares_search_history.setLayoutManager(new FlexboxLayoutManager(getContext()));
        list= LitePal.findAll(SearchHistoryData.class);
       // Log.d("-------", "loadSearchHistory: "+list.size());
        List<SearchHistoryData> addlist=new ArrayList<>();
        for (int i = list.size(); i >0 ; i--) {
            SearchHistoryData searchHistoryData=list.get(i-1);
            addlist.add(searchHistoryData);

        }
        searchAdapter=new SearchAdapter(addlist);
        rv_shares_search_history.setAdapter(searchAdapter);
        searchAdapter.setOnItemChildClickListener(new BaseQuickAdapter.OnItemChildClickListener() {
            @Override
            public void onItemChildClick(BaseQuickAdapter adapter, View view, int position) {
                switch (view.getId()){
                    case R.id.history_item:
                        StockResearchSearch activity=(StockResearchSearch)getActivity();
                        sharesFragment=new SharesFragment();
                        activity.switchContent(sharesFragment);
                        StockResearchSearch.isHistorypage=true;
                        break;
                }
            }
        });

    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.delete_history_img:
                shareHistoryDialog.show();
                resetmyname_srue=shareHistoryDialog.findViewById(R.id.resetmyname_srue);
                resetmyname_cancel=shareHistoryDialog.findViewById(R.id.resetmyname_cancel);
                shareHistoryDialog.setCanceledOnTouchOutside(true);
                break;


        }
    }
}
