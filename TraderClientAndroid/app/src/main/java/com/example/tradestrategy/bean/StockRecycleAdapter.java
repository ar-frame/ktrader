package com.example.tradestrategy.bean;

import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.tradestrategy.R;

import java.util.List;

public class StockRecycleAdapter extends RecyclerView.Adapter {
   private List<StockData> mEntity;
    public StockRecycleAdapter(List<StockData> mEntity){
        this.mEntity=mEntity;

    }
    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int i) {
        return new ViewHolder(LayoutInflater.from(parent.getContext()).inflate(R.layout.stock_list,parent,false));
    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder viewHolder, int i) {
        StockData stockData=mEntity.get(i);
    }

    @Override
    public int getItemCount() {
        return mEntity.size();
    }
    public class  ViewHolder extends RecyclerView.ViewHolder{
        public TextView recycler_list;
        public ViewHolder(View itemview){
            super(itemview);
           // recycler_list=itemview.findViewById(R.id.recycler_list);
        }



    }


}
