package com.example.tradestrategy.shares.adapter;

import android.support.annotation.NonNull;

import com.chad.library.adapter.base.BaseQuickAdapter;
import com.chad.library.adapter.base.BaseViewHolder;
import com.example.tradestrategy.R;
import com.example.tradestrategy.shares.bean.SearchHistoryData;

import java.util.List;

public class SearchAdapter extends BaseQuickAdapter<SearchHistoryData, BaseViewHolder> {
    public  SearchAdapter(List<SearchHistoryData> data){
        super(R.layout.rv_item_share_searchhistory,data);


    }
    public  SearchAdapter(){
        super(R.layout.rv_item_share_searchhistory);

    }

    @Override
    protected void convert(@NonNull BaseViewHolder helper, SearchHistoryData data) {
        helper.setText(R.id.history_item,data.getHistorytext()).addOnClickListener(R.id.history_item);


    }

}
